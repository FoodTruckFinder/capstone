<?php

namespace FoodTruckFinder\Capstone;

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once ("/etc/apache2/capstone-mysql/Secrets.php");

use FoodTruckFinder\Capstone\Profile;

/**
 * API for the Profile class
 * @see Profile
 * @author <dnakitare@cnm.edu>
 */

// verify the session, start if not active
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort22/fooddelivery");
	$pdo = $secrets->getPdoObject();

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize inputs
	$id = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// make sure the id  is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new \InvalidArgumentException("id cannot be empty of negative", 405));
	}

	if($method === "GET") {
		// set XSRF-TOKEN to prevent Cross Site Request Forgery
		setXsrfCookie();


		// get a Profile by content
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($profileEmail) === false) {
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null) {
				$reply->data = $profile;
			}
		}

	} elseif($method === "PUT") {
		// enforce that the XSRF token is present in the header
		verifyXsrf();

		// enforce the user is signed in and only trying to edit their own profile
		$profile = Profile::getProfileByProfileId($pdo, $_SESSION["profile"]->getProfileId());
		if(!$profile) {
			throw (new \InvalidArgumentException("You must be logged in to modify your profile.", 405));
		}

		// validate header
		validateJwtHeader();

		// decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if(!$requestObject) {
			throw (new \Exception("Data is missing or invalid", 404));
		}

		// we only allow the logged in user to modify his/her email address, name,


		// retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $profileId);
		if($profile === null) {
			throw (new \RuntimeException("Profile does not exist", 404));
		}

		// profile email
		if(empty($requestObject->profileEmail) === true) {
			throw (new \InvalidArgumentException("No profile email", 405));
		}

		// profile name
		if(empty($requestObject->profileName) === true) {
			throw (new \InvalidArgumentException("No profile name", 405));
		}

		$profile->setProfileEmail($requestObject->profileEmail);
		$profile->setProfileName($requestObject->profileName);
		$profile->update($pdo);

		// update reply
		$reply->message = "Profile information update";

	} else {
		throw (new \InvalidArgumentException("Invalid HTTP request", 400));
	}
	// catch any exceptions that were thrown and update the status and message state variable fields
} catch
(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);



