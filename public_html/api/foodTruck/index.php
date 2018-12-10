<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FoodTruckFinder\Capstone\Location;
use FoodTruckFinder\Capstone\FoodTruck;

/**
 * api for the foodTruck class
 *
 **/

//verify the session, start if not active
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

	// $_SESSION["profile"] = Profile::getProfileByProfileId($pdo, "b3200b81-2cdd-47dc-9e8e-21f9bd69fe3b");

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckProfileId = filter_input(INPUT_GET, "foodTruckProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckDescription = filter_input(INPUT_GET, "foodTruckDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckImageUrl = filter_input(INPUT_GET, "foodTruckImageUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckMenuUrl = filter_input(INPUT_GET, "foodTruckMenuUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckName = filter_input(INPUT_GET, "foodTruckName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckPhoneNumber = filter_input(INPUT_GET, "foodTruckPhoneNumber", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
   $active = filter_input(INPUT_GET, "active", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


   //make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("food truck id cannot be empty or negative", 405));
	}

// GET request
	if($method === "GET") {
		if($method === "GET") {
			//set XSRF cookie

			setXsrfCookie();

			//get a specific foodTruck based on arguments provided or all the foodTrucks and update reply
			if(empty($id) === false) {
				$reply->data = FoodTruck::getFoodTruckByFoodTruckId($pdo, $id);
			} else if(empty($foodTruckProfileId) === false) {
				$reply->data = FoodTruck::getFoodTruckByFoodTruckProfileId($pdo, $foodTruckProfileId);
			} else if(empty($foodTruckName) === false) {
				$reply->data = FoodTruck::getFoodTruckByFoodTruckName($pdo, $foodTruckName);
			} else if(empty($active) === false){
				$reply->data = FoodTruck::getAllActiveFoodTrucks($pdo)->toArray();
			} else {
				$reply->data = FoodTruck::getAllFoodTrucks($pdo)->toArray();
			}
		}


//if it's not a GET request, we determine if we have a PUT or POST request
	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		//  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestContent = file_get_contents("php://input");

		// This Line Then decodes the JSON package and stores that result in $requestObject
		$requestObject = json_decode($requestContent);

		//make sure food truck name is available (required field)
		if(empty($requestObject->foodTruckName) === true) {
			throw(new \InvalidArgumentException ("No name for food truck.", 405));
		}

		if($method === "PUT") {
			//determine if we have a PUT request. Process PUT request here
			// retrieve the food Truck to update

			$foodTruck = FoodTruck::getFoodTruckByFoodTruckId($pdo, $id);
			if($foodTruck === null) {
				throw(new RuntimeException("Food truck does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own tweet
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $foodTruck->getFoodTruckProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this food truck", 403));
			}

			// update all attributes
			$foodTruck->setFoodTruckDescription($requestObject->foodTruckDescription);
			$foodTruck->setFoodTruckImageUrl($requestObject->foodTruckImageUrl);
			$foodTruck->setFoodTruckMenuUrl($requestObject->foodTruckMenuUrl);
			$foodTruck->setFoodTruckName($requestObject->foodTruckName);
			$foodTruck->setFoodTruckPhoneNumber($requestObject->foodTruckPhoneNumber);
			$foodTruck->update($pdo);

			// update reply
			$reply->message = "Food truck updated OK";


		} else if($method === "POST") {
			//process POST request here
			// enforce the user is signed in

			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to edit food trucks", 403));
			}

			// create new food truck and insert into the database
			$foodTruck = new FoodTruck(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $requestObject->foodTruckDescription, $requestObject->foodTruckImageUrl, $requestObject->foodTruckMenuUrl, $requestObject->foodTruckName, $requestObject->foodTruckPhoneNumber);
			$foodTruck->insert($pdo);

			// update reply
			$reply->message = "Food Truck created OK";
		}


		//if above requests are neither PUT nor POST, use DELETE below
	} else if($method === "DELETE") {
		//process DELETE request
		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the food truck to be deleted
		$foodTruck = FoodTruck::getFoodTruckByFoodTruckId($pdo, $id);
		if($foodTruck === null) {
			throw(new RuntimeException("Food truck does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own food truck
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $foodTruck->getFoodTruckProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this food truck", 403));
		}

		// delete foodtruck //TODO add cascading deletes to delete all related foodtruck records favorite -> social -> location KILL THE CHILDREN
		$foodTruck->delete($pdo);
		// update reply
		$reply->message = "Food Truck deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);
