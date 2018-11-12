<?php

namespace FoodTruckFinder\Capstone\Test;

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
		 * Profile that created the favorite FoodTruck; this is the foreign key relations
		 * @var Profile $profile
		 **/
		protected $profile;

		/**
		 * FoodTruck that was liked; this is for foreign key relations
		 * @var FoodTruck $foodTruck
		 **/
		protected $foodTruck;

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
		$this->profile = new Profile(generateUuidV4(), null, "@phpunit", "test@phpunit.de", $this->VALID_HASH, "+12125551212");
		$this->profile->insert($this->getPDO());

		// create and insert the mocked foodtruck
		$this->foodTruck = new foodTruck(generateUuidV4(), $this->profile->getProfileId,  "PHPUnit like test passing");
		$this->foodTruck->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_LIKEDATE = new \DateTime();
}

/**
 * test inserting a valid Favorite and verify that the actual mySQL data matches
 **/
public function testInsertValidFavorite() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->foodTruck->getFoodTruckId(), $this->VALID_FAVORITEDATE);
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoritebyFavoriteFoodTruckIdAndFavoriteProfileId($this->getPDO(), $this->profile->getProfileId(), $this->foodTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteFoodTruckId(), $this->foodtruck->getFoodTruckId());
		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoFavorite->getFavoritedate()->getTimeStamp(), $this->VALID_FAVORITEDATE->getTimestamp());
}
/**
 * test creating a Favorite and then deleting it
 **/
public function testDeleteValidFavorite() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Favorite");

		// create a new Favorite and insert into mySQL
		$favorite = new Favorite($this->profile->getprofileId(), $this->foodTruck->getFoodTruckId(), $this->VALID_FAVORITEDATE);
		$favorite->insert($this->getPDO());

		// delete the Favorite from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Favorite"));
		$favorite->delete($this->getPDO());

		// grab the data from mySQL and enforce the foodTruck does not exist
		$pdoFavorite = Favorite::getFavoriteByFavoriteFoodTruckIdAndFavoriteProfileId($this->getPDO(), $this->profile->getProfileId(), $this->foodtruck->getFoodTruckId());
		$this->assertNull($pdoFavorite);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("Favorite"));
}

/**
 * test inserting a Favorite and grabbing it from mySQL
 **/
public function testGetValidFoodTruckByFoodTruckProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Favorite");

		// create a new Favorite and insert into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->foodTruck->getFoodTruckId(), $this->VALID_FAVORITEDATE);
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteFoodTruckIdAndFavoriteProfileId($this->getPDO(), $this->profile->getProfileId(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteFoodtruckId(), $this->foodTruck->getFoodTruckId());

		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoFavorite->getFavoriteDate()->getTimeStamp(), $this->VALID_FAVORITEDATE->getTimestamp());
}

/**
 * test grabbing a Favorite that does not exist
 **/
public function testGetInvalidFavoriteByFoodTruckIdAndProfileId() {
		// grab a foodTruck id and profile id that exceeds the maximum allowable foodTruck id and profile id
		$favorite = Favorite::getFavoriteByFavoriteFoodTruckIdAndFavoriteProfileId($this->getPDO(), generateUuidV4(), generateUuidV4());
		$this->assertNull($favorite);
}

/**
 * test grabbing a Favorite by foodTruck id
 **/
public function testGetValidFavoriteByFoodTruckId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Favorite");

		// create a new Favorite and insert into mySQL
		$favorite = new Favorite($this->getPDO());
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteFoodTruckId($this->getPDO(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Favorite"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruckFinder\\Favorite", $results);

		// grab the results from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteFoodTruckId(), $this->foodTruck->getFoodTruckId());

		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoFavorite->getFavoriteDate()->getTimeStamp(), $this->VALID_FAVORITEDATE->getTimestamp());
}
/**
 * test grabbing a Favorite by profile id
 **/
public function testGetValidFavoriteByProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Favorite");

		// create a new Favorite and insert into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->foodTruck->getFoodTruckId(), $this->VALID_FAVORITEDATE);
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Favorite"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruckFinder\\Favorite", $results);

		// grab the results from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteDate()->getTimeStamp(), $this->VALID_FAVORITEDATE->getTimeStamp());
}

/**
 * test grabbing a Favorite by a profile id that does not exist
 **/
public function testGetInvalidFavoriteByProfileId() : void {
		// grab a foodTruck id that exceeds the maximum allowable profile id
		$favorite = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $favorite);
}
}