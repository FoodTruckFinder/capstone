<?php

require_once (dirname(__DIR__,3). "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

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
	if($method === "POST") {
		verifyXsrf();
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/fooddelivery.ini");

		//cloudinary api stuff
		$config = readConfig("/etc/apache2/capstone-mysql/fooddelivery.ini");
		$cloudinary = json_decode($config["cloudinary"]);
		\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

		//assigning variables to the user image name, MIME type, and image extension
		$tempUserFileName = $_FILES["foodtruck"]["tmp_name"];

		//upload image to cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, ["width"=>500, "crop"=>"scale"]);

		//after sending the image to Cloudinary, grab the public id and create a new image
		$reply->data = $cloudinaryResult["public_id"];
		$reply->message = "Image upload ok";
	} else{
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");

// encode and return reply to front end caller
echo json_encode($reply);