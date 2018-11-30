<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
use \FoodTruckFinder\Capstone\{Location, Profile, FoodTruck};

/**
 * * api for Location class
 *
 * GET, POST, PUT, and DELETE
 *
 * @author David Sanderson sanderdj90@gmail.com
 **/

//verify the session and start it if it isn't active

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/foodtruck.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//stores the Primary Key ($locationId) for the GET method
	$locationId = filter_input(INPUT_GET, "locationId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$locationFoodTruckId = filter_input(INPUT_GET, "locationFoodTruckId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$locationLatitude = filter_input(INPUT_GET, "locationLatitude", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$locationLongitude = filter_input(INPUT_GET, "locationLongitude", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	// handle GET request - if locationId or locationFoodTruckId is present, that location is returned, otherwise all location are returned.

	//make sure the locationId is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && empty($locationId) === true) {
		throw(new InvalidArgumentException("id cannot be empty", 405));
	}
	//handle GET request if id is present, that location is returned, otherswise return all locations
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific location by locationId, locationFoodTruckId or return all locations

		if(empty($locationId) === false) {
			$location = Location::getLocationByLocationId($pdo, $locationId);
			if($location !== null) {
				$reply->data = $location;
			}
		}
		else if(empty($locationFoodTruckId) === false) {
			$location = Location::getLocationByLocationFoodTruckId($pdo, $locationFoodTruckId);
			if($location !== null) {
				$reply->data = $location;
			}
		}
		else {
			$locations = Location::getAllLocations($pdo)->toArray();
			if($locations !== null) {
				$reply->data = $locations;
			}
		}
	} else if($method === "PUT" || $method === "POST") {


		// enforce the user has a XSRF Token
		verifyXsrf();

		// Retrieves the JSON pkg that the front end sent, and stores it in $requestContent.

		$requestContent = file_get_contents("php://input");

		// This line then decodes the JSON pkg and stores that result in $requestObject

		$requestObject = json_decode($requestContent);

		//make sure the location has a lat and long
		if(empty($requestObject->locationLatititude) === true || (empty($requestObject->locationLongitude) === true)) {
			throw(new \InvalidArgumentException("No long or lat coordinates for location.", 405));
		}

		//make sure the location has a start and end time
		if(empty($requestObject->locationStartTime) === true || (empty($requestObject->locationEndTime) === true)) {
			throw(new \InvalidArgumentException("Location is missing a start or end time", 405));
		}


		/*
		//TODO NOT SURE About Lines  94-102
		//make sure the start time is accurate
		if(empty($requestObject->locationStartTime) === true) {
			$requestObject->locationStartTime = null;
		}
		//make sure the end time is accurate
		if(empty($requestObject->locationEndTime) === true) {
			$requestObject->locationEndTime = null;
		} else {
			$locationStartTime = DateTime::createFromFormat("U.u", $requestObject->locationStartTime / 1000);
			if($locationStartTime === false) {
				throw(new RuntimeException("invalid start time", 400));
			}
			$requestObject->locationStartTime = $locationStartTime;
		}
		//TODO Format start and end times before putting or posting??
*/




//TODO FINISH PUT/POST
	}

	if($method === "PUT") {

		//retrieve the location to update
		$location = Location::getLocationByLocationId($pdo, $locationId);
		if($location === null) {
					throw(new RuntimeException("Location does not exist.", 404));
		}

		//retrieve the foodtruck to update
		$foodTruck = FoodTruck::getFoodTruckByFoodTruckProfileId($pdo, $foodTruckProfileId);
		if($foodTruck === null) {
			throw(new RuntimeException("FoodTruck does not exist.", 404));
		}
		//enforce the user is signed in and is a foodtruck owner
		//TODO Add a logic block that checks that their foodtruckId matches the locationfoodtruckId this is to enforce that the unique foodtruck owner is only able to edit their location
		if($foodTruck->getFoodTruckProfileId()->toString()  !== $_SESSION["profile"]->getProfileId()->toString  &&  empty($_SESSION["profile"]) === false) {
			throw(new \InvalidArgumentException("You are not allowed to edit this location", 403));
		}

		//update all attributes
		$location -> setLocationLatitude($requestObject->locationLatitude);
		$location -> setLocationLongitude($requestObject->locationLongitude);
		$location -> setLocationStartTime($requestObject->locationStartTime);
		$location -> setLocationEndTime($requestObject->locationEndTime);

		$location->update($pdo);

		//update reply
		$reply->message = "Location successfully updated";

	}
	else if($method === "POST") {
		//enforce the user is signed in and a foodtruck owner
		if(empty($_SESSION["profile"]) == true || $profile -> profileIsOwner === false) {
			throw(new \InvalidArgumentException("you must be logged in as a foodtruck owner to post foodtruck locations", 403));

		}

		//create new Location and insert into the database
		//TODO how do I tie the profile session to the location so that I can insert it into the DB? STOPPED BELOW
		$location = new Location(generateUuidV4(), $foodTruck->getFoodTruckId(), $requestObject->locationEndTime, $requestObject->locationLatitude, $requestObject->locationLongitude, $requestObject->locationStartTime);
		$location->insert($pdo);

		//update reply
		$reply->message = "Location successfully created";
	}

	else if ($method === "DELETE") {

		//enforce the user has a XSRF Token
		verifyXsrf();

		//retrieve the Location to be deleted
		$location = Location::getLocationByLocationId($pdo, $locationId);
		if($location === null) {
					throw(new RuntimeException("Location not found", 404));
		}

		//retrieve the foodtruck to update
		$foodTruck = FoodTruck::getFoodTruckByFoodTruckProfileId($pdo, $foodTruckProfileId);
		if($foodTruck === null) {
			throw(new RuntimeException("FoodTruck does not exist.", 404));
		}

		//TODO rewrite if block to enforce that foodTruckProfileId === $_SESSION["profile] and $_SESSION["profile] is not empty
		if($foodTruck->getFoodTruckProfileId()->toString()  !== $_SESSION["profile"]->getProfileId()->toString  &&  empty($_SESSION["profile"]) === false) {
					throw(new \InvalidArgumentException("You are not allowed to delete this location", 403));
	}
	//delete location
	$location->delete($pdo);
	// update reply
	$reply->message = "Location Deleted.";


}
else {
		throw (new InvalidArgumentException("Invalid HTTP Method Request", 418));
	}
// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
// In these lines, the Exceptions are caught and the $reply object is updated with the code + message from the caught exception.
header("Content-type: application/json");
// sets up the response header.
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);