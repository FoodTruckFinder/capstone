<?php

require_once (dirname(__DIR__,3). "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once  (dirname(__DIR__, 3) ."/php/lib/uuid.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once (dirname(__DIR__, 3) . "/php/lib/jwt.php");
use FoodTruckFinder\capstone\{Profile, FoodTruck};
/**
 * the user upload an image file to Cloudinary, the server grabs the secure image URL from Cloudinary
 * and updates the foodTruckImageUrl field of a specified foodTruck
 * @see Profile
 * @see FoodTruck
 * @author greg klein <gklein@cnm.edu>
 * @version 1.0.0
 */

// verify that a session is active, if not -- start the session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// determine the HTTP method used (we only allow the POST method to be used for image uploading)
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if ($method !== "POST") {
		throw (new \Exception("This HTTP method is not supported for image upload.", 405));
	}

	// verify that a XSRF-TOKEN is present
	verifyXsrf();

	// make sure that a user is logged in before uploading a picture
	if(empty($_SESSION["profile"]) || empty($_SESSION["profile"]->getProfileId()->toString())) {
		throw(new \InvalidArgumentException("You must be logged in to upload food truck images.", 403));
	}

	// validate header
	validateJwtHeader();

	$config = readConfig("/etc/apache2/capstone-mysql/fooddelivery.ini");
	$cloudinary = json_decode($config["cloudinary"]);
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

	// assigning variable to the food truck image, add image extension
	$tempAnimalFileName = $_FILES["foodtruckimage"]["tmp_name"];

	// upload image to cloudinary and get public id
	$cloudinaryResult = \Cloudinary\Uploader::upload($tempFoodTruckFileName, array("width" => 500, "crop" => "scale"));

	// after sending the image to Cloudinary, set foodTruckImageUrl to the ft record
	$reply->data = $cloudinaryResult["secure_url"];

	// update reply
	$reply->message = "Image uploaded Ok.";
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

//encode and return reply to the front-end caller
header("Content-Type: application/json");
if (!$reply->data) {
	unset($reply->data);
}

// encode and return reply to front-end caller
echo json_encode($reply);