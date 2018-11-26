<?php

namespace FoodTruckFinder\Capstone;

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use FoodTruckFinder\Capstone\Profile;

/**
 * API for the Profile class
 *
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
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileActivationToken = filter_input(INPUT_GET, "profileActivationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	// make sure the profile id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($profileId) === true)) {
		throw(new \InvalidArgumentException("profile id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a Profile by content
		if(empty($profileId) === false) {
			$reply->data = Profile::getProfileByProfileId($pdo, $profileId);
		} elseif(empty($profileActivationToken) === false) {
			$reply->data = Profile::getProfileByProfileActivationToken($pdo, $profileActivationToken);
		} elseif(empty($profileEmail) == false) {
			$reply->data = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		}
	} elseif($method === "PUT") {
		// enforce that the XSRF token is present in the header
		verifyXsrf();

		// enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $profileId) {
			throw (new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		validateJwtHeader();

		// decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);


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



