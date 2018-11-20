<?php

require_once dirname(__3__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use FoodTruckFinder\Capstone\Favorite;
use FoodTruckFinder\Capstone\FoodTruck;

};

/**
 * Api for the Favorite class
 *
 * @author bernina gray
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort22/fooddelivery.ini");

		// determine which HTTP method was used
		$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

		// sanitize

