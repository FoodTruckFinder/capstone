<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
use \FoodTruckFinder\Capstone\Location;

/**
 * * api for Location class
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/fooddelivery.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//stores the Primary Key ($locationId) for the GET method
	$locationId = filter_input(INPUT_GET, "locationId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$locationFoodTruckId = filter_input(INPUT_GET, "locationFoodTruckId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$locationLatitude = filter_input(INPUT_GET, "locationLatitude", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	$locationLongitude = filter_input(INPUT_GET, "locationLongitude", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	// handle GET request - if id is present, that location is returned, otherwise all location are returned
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
		// If the method request is not GET an invalid argument exception is thrown
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