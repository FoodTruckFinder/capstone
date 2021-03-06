<?php

namespace FoodTruckFinder\Capstone;

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FoodTruckFinder\Capstone\Profile;

/**
 * API for the Profile class
 * @see Profile
 * @author <dnakitare@cnm.edu>
 */

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new \stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort22/fooddelivery");
	$pdo = $secrets->getPdoObject();

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize inputs
	$id = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileName = filter_input(INPUT_GET, "profileName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); // this changes but is not used to search for profile in the profile class

	// make sure the id  is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new \InvalidArgumentException("id cannot be empty of negative", 405));
	}

	if($method === "GET") {
		// set XSRF-TOKEN to prevent Cross Site Request Forgery
		setXsrfCookie();


		// get a profile by content
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

		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		// enforce that the end user has a JWT token
		validateJwtHeader();

		// decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw (new \RuntimeException("Profile does not exist", 404));
		}
// todo front end needs to fill each field to complete PUT
		// profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw (new \InvalidArgumentException("No profile email", 405));
		}

		// profile name is a required field
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
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
//encode and return reply to front end caller
echo json_encode($reply);


