<?php

namespace Edu\Cnm\FoodTruckFinder\Test;

use Edu\Cnm\FoodTruckFinder\Favorite;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * PHPUnit test of the Favorite class.
 *
 * @see Favorite
 * @author Bernina Gray <bgray11@cnm.edu>
 **/
class FavoriteTest extends FoodTruckTest {
		/**
		 * Profile that created the favorite; this is the foreign key relations
		 * @var Favorite profile
		 **/
		protected $profile = null;

		/**
		 * the id referencing the favorited food truck
		 * @var favorite id
		 **/
		protected $id = null;

		/**
		 * timestamp of the Favorite; this starts as null and is assigned later
		 * @var \DateTime $VALID_TWEETDATE
		 **/
		protected $VALID_FAVORITEDATE = null;


}