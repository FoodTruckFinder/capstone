<?php


require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once (dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use \FoodTruckFinder\Capstone\Profile;

/**
 * API for handling sign-in
 *
 * @author dnakitare@cnm.edu
 */

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare and empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/fooddelivery.ini");

	// determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD, $_SERVER") ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method === "POST") {
		// decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// profile email is a required field
		if(empty($requestObject->profileEmail)  === true) {
			throw (new \InvalidArgumentException("No profile email present", 405));
		}

		// verify that profile password is present
		if(empty($requestObject->profileHash) === true) {
			throw (new	\InvalidArgumentException("Must input valid password", 405));
		}

		// verify that confirm password is present
		if(empty($requestObject->profileHashConfirm) === true) {
			throw (new	\InvalidArgumentException("Must input valid password", 405));
		}

		// verify that profile is or is not owner
		if(empty($requestObject->profileIsOwner) === true) {
			throw (new	\InvalidArgumentException("Must input profile type", 405));
		}

		// verify that profile name is present
		if(empty($requestObject->profileName) === true) {
			throw (new	\InvalidArgumentException("Must input profile type", 405)):
		}

		// make sure the password and confirm password match
		if($requestObject->profileHash !== $requestObject->profileHashConfirm) {
			throw (new \InvalidArgumentException("Password do not match"));
		}

		$hash = password_hash($requestObject->profileHash, PASSWORD_ARGON2I, ["time_cost =>384"]);

		$profileActivationToken = bin2hex(random_bytes(16));

		// create the profile object and prepare to insert inot the database
		$profile = new Profile(generateUuidV4(), $profileActivationToken, $requestObject->profileEmail, $hash, $requestObject->profileIsOwner, $requestObject->profileName);

		// insert the profile into the database
		$profile->insert($pdo);

		// compose the email message to sen with the activation token
		$messageSubject = "Food trucks spotted on the horizon -- Account Activation";

		// building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
		// make sure URL is /public_html/pai/activation/$activation
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
		// create the path
		$urlglue = $basePath . "/api/activation/?activation=" . $profileActivationToken;
		// create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		// compose message to send with email
		$message = <<< EOF
<h2>Welcome to 505 Food Truck Finder.</h2>
<p>In order to sign in you must confirm your account</p>
<p><a href="$confirmLink">Confirmation Link</a></p>
EOF;

		// create swift email
		$swiftMessage = new Swift_Message();
		// attach the sender to the message
		// this takes the form of associative array where the email is the key to a real name
		$swiftMessage->setFrom(["505foodtruckfinder@gmail.com" => "505FoodTruckFinder"]);




	}
}