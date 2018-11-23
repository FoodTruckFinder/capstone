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
	}
}