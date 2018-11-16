<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use FoodTruckFinder\Capstone\Profile;
use FoodTruckFinder\Capstone\FoodTruck;


/**
 * api for the foodTruck class
 *
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/fooddelivery.ini");

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckProfileId = filter_input(INPUT_GET, "foodTruckProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckDescription = filter_input(INPUT_GET, "foodTruckDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckImageUrl = filter_input(INPUT_GET, "foodTruckImageUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckMenuUrl = filter_input(INPUT_GET, "foodTruckMenuUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckName = filter_input(INPUT_GET, "foodTruckName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$foodTruckPhoneNumber = filter_input(INPUT_GET, "foodTruckPhoneNumber", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("food truck id cannot be empty or negative", 405));
	}

// GET request
if ($method === "GET") {

//if it's not a GET request, we determine if we have a PUT or POST request
} else if($method === "PUT" || $method === "POST") {

	//do setup needed for PUT and POST
	if($method === "PUT") {
		//determine if we have a PUT request. Process PUT request here

	} else if ($method === "POST") {
		//process POST request here

	}

	//if above requests are neither PUT nor POST, use DELETE below
} else if($method === "DELETE") {

	//process DELETE request
}