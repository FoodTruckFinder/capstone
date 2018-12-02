<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use FoodTruckFinder\Capstone\Favorite;
use FoodTruckFinder\Capstone\FoodTruck;


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
	$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort22/fooddelivery");
	$pdo = $secrets->getPdoObject();
		// determine which HTTP method was used
		$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

		//sanitize the search parameters
		$favoriteFoodTruckId = $id = filter_input(INPUT_GET, "favoriteFoodTruckId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
		$favoriteProfileId = $id = filter_input(INPUT_GET, "favoriteProfileId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
		if($method === "GET") {
			//set XSRF cookie
			setXsrfCookie();
			//gets  a specific favorite associated based on its composite key
			if ($favoriteFoodtruckId !== null && $favoriteProfileId !== null) {
				$favorite = Favorite::getFavoriteByFavoriteFoodTruckIdAndFavoriteProfileId($pdo, $favoriteFoodtruckId, $favoriteProfileId);
				if($favorite!== null) {
					$reply->data = $favorite;
				}
				//if none of the search parameters are met throw an exception
			} else if(empty($favoriteFoodtruckId) === false) {
				$reply->data = Favorite::getFavoriteByFavoriteFoodTruckId($pdo, $favoriteFoodtruckId)->toArray();
				//get all the favorites associated with the foodTruckId
			} else if(empty($favoriteProfileId) === false) {
				$reply->data = Favorite::getFavoriteByFavoriteProfileId($pdo, $favoriteProfileId)->toArray();
			} else {
				throw new InvalidArgumentException("incorrect search parameters ", 404);
			}
		} else if($method === "POST" || $method === "PUT") {
			//decode the response from the front end
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);
			if(empty($requestObject->favoriteFoodTruckId) === true) {
				throw (new \InvalidArgumentException("No FoodTruck linked to the Favorite", 405));
			}
			if(empty($requestObject->favoriteProfileId) === true) {
				throw (new \InvalidArgumentException("No favorite linked to the foodTruck", 405));
			}
			if(empty($requestObject->favoriteAddDate) === true) {
				$requestObject->favoriteAddDate =  date("y-m-d H:i:s");
			}
			if($method === "POST") {
				//enforce that the end user has a XSRF token.
				verifyXsrf();
				//enforce the end user has a JWT token
				//validateJwtHeader();
				// enforce the user is signed in
				if(empty($_SESSION["profile"]) === true) {
					throw(new \InvalidArgumentException("you must be logged in to favorite a food truck", 403));
				}
				validateJwtHeader();
				$favorite = new Favorite ($_SESSION["profile"]->getFoodTruckId(), $requestObject->favoriteProfileId);
				$favorite->insert($pdo);
				$reply->message = "favorite food truck successful";
			} else if($method === "PUT") {
				//enforce the end user has a XSRF token.
				verifyXsrf();
				//enforce the end user has a JWT token
				validateJwtHeader();
				//grab the favorite by its composite key
				$favorite = Favorite::getFavoriteByFavoriteFoodTruckIdAndFavoriteProfileId($pdo, $requestObject->favoriteFoodTruckId, $requestObject->favoriteProfileId);
				if($favorite === null) {
					throw (new RuntimeException("favorite does not exist"));
				}
				//enforce the user is signed in and only trying to edit their own favorite
				if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getFavoriteProfileId() !== $favorite->getFavoriteProfileId()) {
					throw(new \InvalidArgumentException("You are not allowed to delete this favorite", 403));
				}
				//validateJwtHeader();
				//perform the actual delete
				$favorite->delete($pdo);
				//update the message
				$reply->message = "favorite successfully deleted";
			}
			// if any other HTTP request is sent throw an exception
		} else {
			throw new \InvalidArgumentException("invalid http request", 400);
		}
		//catch any exceptions that is thrown and update the reply status and message
	} catch(\Exception | \TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}
	header("Content-type: application/json");
	if($reply->data === null) {
		unset($reply->data);
	}
	// encode and return reply to front end caller
	echo json_encode($reply);

