<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use \FoodTruckFinder\Capstone\Profile;

/**
 * API for app user sign-in
 *
 * @author David Sanderson <sanderdj90@@gmail.com>
 **/

/**
 * Prepare an empty reply.
 **/

//check the session status. If it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the database connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/foodtruck.ini");
	//determine which HTTP method, store the result in $method
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "POST") {
		//check xsrf token
		verifyXsrf();
		//grab request content, decode json into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//check for password
		if(empty($requestObject->profileHash) === true) {
			throw (new \InvalidArgumentException("A valid password must be entered.", 401));
		} else {
			$profileHash = $requestObject->profileHash;
		}
		//check for email
		if(empty($requestObject->profileEmail) === true) {
			throw (new \InvalidArgumentException("A valid email address must be entered.", 401));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}
		//grab the profile by email address
		$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		if(empty($profile) === true) {
			throw (new \RuntimeException("Invalid username", 401));
		}

		//hash the user's password
		$hash = password_hash($profileHash, PASSWORD_ARGON2I, ["time_cost" =>384]);
		//enforce that the user's password matches their password in mySQL
      if ($hash !== $profile->getProfileHash()) {
      	throw (new \InvalidArgumentException("Invalid username or password.", 401));
		}
		//grab profile by profileId from MySQL and put into the session
		$profile = Profile::getProfileByProfileId($pdo, $profile->getProfileId());
		//check if user still has an active user activation token. User must validate token before signing in.
		if(!empty($profile->getProfileActivationToken()) || $profile->getProfileActivationToken() !== null) {
			throw (new \RuntimeException("Please verify your account via email before logging in.", 403));
		}
		//add profile to session upon successful sign-in
		$_SESSION["profile"] = $profile;
		//create the auth payload
		$authObject = (object) [
			"profileId" => $profile->getProfileId(),
			"profileName" => $profile->getProfileName()
		];
		//create & set the JWT
		setJwtAndAuthHeader("auth", $authObject);
		//update reply
		$reply->message = "Welcome to 505FoodTruckFinder! You are now signed in.";
	} else {
		throw (new \InvalidArgumentException("Invalid HTTP request!"));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
//sets up the response header
header("Content-type: application/json");
//JSON encode the $reply object and echo it to the front end.
echo json_encode($reply);