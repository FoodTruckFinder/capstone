<?php

namespace Edu\Cnm\FoodTruckFinder\Test;

use Edu\Cnm\FoodTruckFinder\{Profile, Favorite, Foodtruck};
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * PHPUnit test of the Favorite class.
 *
 * This is a complete PHPUnit test of the Favorite class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Favorite
 * @author Bernina Gray <bgray11@cnm.edu>
 **/
class FavoriteTest extends FoodTruckTest {
		/**
		 * Profile that created the favorited FoodTruck; this is the foreign key relations
		 * @var Favorite $profile
		 **/
		protected $profile;

		/**
		 * FoodTruck that was liked; this is for foreign key relations
		 * @var FoodTruck $foodTruck
		 **/
		protected $foodtruck;

		/**
		 * timestamp of the Favorite; this starts as null and is assigned later
		 * @var \DateTime $VALID_FAVORITEDATE
		 **/
		protected $VALID_FAVORITEDATE;
/**
 * create dependent objects before running each test
 **/
public final function setUp() : void {
		//run the default setUp() method first
		parent::setUp();
		// create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
		// create and insert the mocked profile



}