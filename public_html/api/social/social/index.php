<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/secrets.php");

use FoodTruckFinder\Capstone\Favorite;
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
	$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort22/fooddelivery");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize the search parameters
	$SocialId = filter_input(INPUT_GET, "SocialId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$socialFoodTruckId = filter_input(INPUT_GET, "socialFoodTruckId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	/**
	 * Get API for Social
	 **/
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets the specific social that is associated, based on its composite key (get by both)
		if ($socialFoodTruckId !== null && $socialFoodTruckId !== null) {
			$social = Social::getSocialBySocialIdAndSocialFoodTruckd($pdo, $SocialId, $socialFoodTruckId, $socialUrl);
			if($social!== null) {
				$reply->data = $social;
			}
			//get all of the socials associated with the profileId
		} else if(empty($socialId) === false) {
			$social = Social::getSocialBySocialId($pdo, $socialFoodTruckId)->toArray();
			if($social !== null) {
				$reply->data = $social;
			}
			//get all of the socials associated with the profileId
		} else if(empty($socialFoodTruckTruckId) === false) {
			$social = Social::getSocialBySocialFoodTruckId($pdo, $socialFoodTruckId)->toArray();
			if($social !== null) {
				$reply->data = $social;
			}
			//if none of the search parameters are met, throw an exception
		} else {
			throw new InvalidArgumentException("invalid search parameters ", 404);
		}
		/**
		 * Post API for Social
		 **/
	} else if($method === "POST") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		//enforce the end user has a JWT token
		validateJwtHeader();
		//decode the response from the frontend
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->socialFoodTruckId) === true) {
			throw (new \InvalidArgumentException("No profile linked to the social", 405));
		}
		if(empty($requestObject->socialId) === true) {
			throw (new \InvalidArgumentException("No profile linked to the social", 405));
		}
//TODO: Not sure if this is needed. Check with George
//		if(Social::getSocialBySocialIdAndSocialFoodTruckId($pdo, $_SESSION["profile"]->getProfileId(), $requestObject->socialId)!==null){
//			throw(new \InvalidArgumentException("The Social already exists."));
//		}
//		if (Profile::getProfileByProfileId($pdo,$requestObject->socialId)===null){
//			throw(new \InvalidArgumentException("The profile does not exist."));
//		}
		//enforce that the user is signed in
		//not sure what 400 code to put in? and not sure about the success message
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("You must be logged in to social ", 405));
		}
		$social = new Social($requestObject->socialId, $_SESSION["profile"]->getProfileId());
		$social->insert($pdo);
		echo("116");
		$reply->message = "Successfully entered social accounts";
	}
	/**
	 * Put API for Social
	 *
	 * You can only delete only id, thus we have to use a PUT.
	 **/
	else if($method === "PUT") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		// retrieve the social to be deleted
		$social = Social::getSocialBySocialIdAndSocialFoodTruckId($pdo, $socialId, $socialFoodTruckId, $socialUrl);
		if($social === null) {
			throw(new RuntimeException("Social does not exist", 404));
		}
		//enforce that the user is signed in and only trying to edit their own social / not sure about 400 code again
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $social->getSocialFoodTruckId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this social link", 418));
		}

		else if($method === "DELETE") {

			//enforce that the end user has a XSRF token.
			verifyXsrf();

			// retrieve the Social to be deleted
			$social = Social::getSocialByTSocialId($pdo, $id);
			if($social === null) {
				throw(new RuntimeException("Social does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own social
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $social->getSocialProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this social", 403));
			}

			// delete social
			$social->delete($pdo);
			// update reply
			$reply->message = "Social deleted OK";
		}
// encode and return reply to front end caller
echo json_encode($reply);
