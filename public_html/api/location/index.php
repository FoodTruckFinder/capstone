<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FoodTruckFinder\Capstone\Location;
use FoodTruckFinder\Capstone\FoodTruck;

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
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort22/fooddelivery");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//stores the Primary Key ($id) for the GET method

	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$locationFoodTruckId = filter_input(INPUT_GET, "locationFoodTruckId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$locationLatitude = filter_input(INPUT_GET, "locationLatitude", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$locationLongitude = filter_input(INPUT_GET, "locationLongitude", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

	// handle GET request - if id or locationFoodTruckId is present, that location is returned, otherwise all location are returned.

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && empty($id) === true) {
		throw(new InvalidArgumentException("location id or location foodtruck cannot be empty", 405));
	}
	//handle GET request if id is present, that location is returned, otherswise return all locations
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific location by id, locationFoodTruckId or return all locations

		if(empty($id) === false) {
			$location = Location::getLocationByLocationId($pdo, $id);
			if($location !== null) {
				$reply->data = $location;
			}
		} else if(empty($locationFoodTruckId) === false) {
			$location = Location::getLocationByLocationFoodTruckId($pdo, $locationFoodTruckId);
			if($location !== null) {
				$reply->data = $location;
			}
		} else {
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
		if(empty($requestObject->locationLatitude) === true || (empty($requestObject->locationLongitude) === true)) {
			throw(new \InvalidArgumentException("No long or lat coordinates for location.", 405));
		}


		//make sure the start time is accurate
		if(empty($requestObject->locationStartTime) === true) {
			$requestObject->locationStartTime = null;
		}
		//make sure the end time is accurate
		if(empty($requestObject->locationEndTime) === true) {
			$requestObject->locationEndTime = null;
		}


	}

	if($method === "PUT") {

		//retrieve the location to update
		$location = Location::getLocationByLocationId($pdo, $id);
		if($location === null) {
			throw(new RuntimeException("Location does not exist.", 404));
		}

		//retrieve the foodtruck to update
		$foodTruck = FoodTruck::getFoodTruckByFoodTruckProfileId($pdo, $foodTruckProfileId);
		if($foodTruck === null) {
			throw(new RuntimeException("FoodTruck does not exist.", 404));
		}
		//enforce the user is signed in and their FoodTruckProfileId matches their ProfileId
		if($foodTruck->getFoodTruckProfileId()->toString() !== $_SESSION["profile"]->getProfileId()->toString() && empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("You are not allowed to edit this location", 403));
		}

		//update all attributes
		$location->setLocationLatitude($requestObject->locationLatitude);
		$location->setLocationLongitude($requestObject->locationLongitude);
		$location->setLocationStartTime($requestObject->locationStartTime);
		$location->setLocationEndTime($requestObject->locationEndTime);

		$location->update($pdo);

		//update reply
		$reply->message = "Location successfully updated";

	} else if($method === "POST") {
		//enforce the user is signed in and a foodtruck owner
		if(empty($_SESSION["profile"]) == true) {
			throw(new \InvalidArgumentException("you must be logged in as a foodtruck owner to post foodtruck locations", 403));

		}
		if($_SESSION["profile"]->getProfileIsOwner() !== 1) {
			throw(new \InvalidArgumentException("You are not allowed to perform this action.", 403));
		} //retrieve the foodtruck to own the new record TODO enter a test value for foodTruckId
		else {

			//create new Location and insert into the database
			$location = new Location(generateUuidV4(), $requestObject->locationFoodTruckId, $requestObject->locationEndTime, $requestObject->locationLatitude, $requestObject->locationLongitude, $requestObject->locationStartTime);

			$location->insert($pdo);

			//update reply
			$reply->message = "Location successfully created";
		}
	} else if($method === "DELETE") {

		//enforce the user has a XSRF Token
		verifyXsrf();

		//retrieve the Location to be deleted locationid
		$location = Location::getLocationByLocationId($pdo, $id);
		if($location === null) {
			throw(new RuntimeException("Location not found", 404));
		}

		//TODO make it so records can be deleted by location id OR locationFoodTruck id CURRENTLY YOU NEED BOTH
		//retrieve the foodtruck to delete by foodtruck id
		$foodTruck = FoodTruck::getFoodTruckByFoodTruckId($pdo, $locationFoodTruckId);
		if($foodTruck === null) {
			throw(new RuntimeException("FoodTruck does not exist.", 404));
		}


		if($foodTruck->getFoodTruckProfileId()->toString() !== $_SESSION["profile"]->getProfileId()->toString() && empty($_SESSION["profile"]) === false) {
			throw(new \InvalidArgumentException("You are not allowed to delete this location", 403));
		}
		//delete location
		$location->delete($pdo);
		// update reply
		$reply->message = "Location Deleted.";


	} else {
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