<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FoodTruckFinder\Capstone\Social;
use FoodTruckFinder\Capstone\FoodTruck;

/**
 * Api for the Social class
 *
 *
 * @author Rae Jack <bjack2@cnm.edu>
 **/
//verify the session, start session if not already active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort22/fooddelivery");
	$pdo = $secrets->getPdoObject();
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize the search parameters
	$id = filter_input(INPUT_GET, "socialId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$socialFoodTruckId = filter_input(INPUT_GET, "socialFoodTruckId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$socialUrl = filter_input(INPUT_GET, "socialUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	/**
	 * Get API for Social
	 **/
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets the specific social that is associated, based on its composite key (get by both)
		if(empty($socialFoodTruckId) === false) {
			$social = Social::getSocialBySocialFoodTruckId($pdo, $socialFoodTruckId)->toArray();
			if($social !== null) {
				$reply->data = $social;
				//if none of the search parameters are met, throw an exception
			} else
				throw new InvalidArgumentException("invalid search parameters ", 404);
		}
		/**
		 * Post API for Social
		 **/
	} else
		if($method === "PUT" || $method === "POST") {

			// enforce the user has a XSRF token
			verifyXsrf();

			//  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
			$requestContent = file_get_contents("php://input");

			// This Line Then decodes the JSON package and stores that result in $requestObject
			$requestObject = json_decode($requestContent);

			//make sure social content is available (required field)
			if(empty($requestObject->socialUrl) === true) {
				throw(new \InvalidArgumentException ("No content for Social.", 405));
			}

			// make sure social date is accurate (optional field)

			//  make sure profileId is available
			if(empty($requestObject->socialFoodTruckId) === true) {
				throw(new \InvalidArgumentException ("No Social Food Truck ID.", 405));
			}

			//perform the actual put or post
			if($method === "PUT") {

				// retrieve the tweet to update
				$social = Social::getSocialBySocialId($pdo, $id);
				if($social === null) {
					throw(new RuntimeException("Social does not exist", 404));
				}

				//enforce the user is signed in and only trying to edit their own social
				if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $social->getSocialId()->toString()) {
					throw(new \InvalidArgumentException("You are not allowed to edit this social", 403));
				}

				// update all attributes
				$social->setSocialFoodTruckId($requestObject->socialFoodTruckId);
				$social->setSocialUrl($requestObject->socialUrl);
				$social->update($pdo);

				// update reply
				$reply->message = "Social updated OK";

			} else if($method === "POST") {

				// enforce the user is signed in
				if(empty($_SESSION["profile"]) === true) {
					throw(new \InvalidArgumentException("you must be logged in to post social media", 403));
				}

				// create new social and insert into the database
				$social = new Social (generateUuidV4(), $requestObject->socialFoodTruckId, $requestObject->socialUrl);
				$social->insert($pdo);

				// update reply
				$reply->message = "Social created OK";
			}
		} else if($method === "DELETE") {

			//enforce that the end user has a XSRF token.
			verifyXsrf();

			// retrieve the Social to be deleted/ Not sure if getSocialBySocialId is correct
			$social = Social::getSocialBySocialId($pdo, $id);
			if($social === null) {
				throw(new InvalidArgumentException("Social does not exist", 404));
			}

			$foodTruck = FoodTruck::getFoodTruckByFoodTruckId($pdo, $social->getSocialFoodTruckId());
			if($foodTruck === null) {
				throw(new InvalidArgumentException("Social does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own social
			if(empty($_SESSION["profile"])=== true && $foodTruck->getFoodTruckId()->toString() !== $social->getSocialFoodTruckId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this social", 403));
			}
			// delete social
			$social->delete($pdo);
			// update reply
			$reply->message = "Social deleted OK";
		}

		}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw (new $exceptionType($exception->getMessage(), 0, $exception));
	}


header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);






