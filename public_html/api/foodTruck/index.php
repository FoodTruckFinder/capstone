<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use FoodTruckFinder\Capstone\Profile;
use FoodTruckFinder\Capstone\FoodTruck;

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