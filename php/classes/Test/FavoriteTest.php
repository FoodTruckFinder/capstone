<?php

namespace FoodTruckFinder\Capstone\Test;

use FoodTruckFinder\Capstone\Profile;
use FoodTruckFinder\Capstone\Favorite;
use FoodTruckFinder\Capstone\FoodTruck;

require_once ("FoodTruckFinderTestSetup.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test of the Favorite class.
 *
 * This is a complete PHPUnit test of the Favorite class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Favorite
 * @author Bernina Gray <bgray11@cnm.edu>
 **/
class FavoriteTest extends FoodTruckFinderTest {
	/**
	 * Profile that created the favorite for the food truck; this is for the foreign key relations
	 * @var Profile $profile
	 **/
	protected $profile;

	/**
	 * FoodTruck that was liked; this is for foreign key relations
	 * @var FoodTruck $foodTruck
	 **/
	protected $foodTruck;

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 **/
	protected $VALID_HASH;

	/**
	 * timestamp of the Favorite; this starts as null and is assigned later
	 * @var \DateTime $VALID_FAVORITE_DATE
	 **/
	protected $VALID_FAVORITE_ADD_DATE;

	/**
	 * valid activationToken to create the profile to own the test
	 * @var string $VALID_ACTIVATION
	 **/
	protected $VALID_ACTIVATION;

	/**
	 * create dependent objects before running each test
	 *
	 * @throws \Exception
	 */
	public final function setUp(): void {
		//run the default setUp() method first
		parent::setUp();
		// create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
		// create and insert a profile to own the test Favorite
		$this->profile = new Profile(generateUuidV4(), $this->VALID_ACTIVATION, "ownertestemail@fake.com", $this->VALID_HASH, 1, "ChadGarcia");
		$this->profile->insert($this->getPDO());
		// create and insert the mocked profile
		$this->foodTruck = new FoodTruck(generateUuidV4(), $this->profile->getProfileId(), "Food truck description", "https://www.tacostogo.com/", "https://www.tacostogo.com/menu.html", "TacosToGo FoodTruck", "505-505-8226");
		$this->foodTruck->insert($this->getPDO());
		// calculate the date (just use the time the unit test was setup
		$this->VALID_FAVORITE_ADD_DATE = new \DateTime();
	}

	/**
	 * test inserting a valid Favorite and verify that the actual mySQL data matches
	 **/
	public function testInsertValidFavorite(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->foodTruck->getFoodTruckId(), $this->profile->getProfileId(), $this->VALID_FAVORITE_ADD_DATE);
		$favorite->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoritebyFavoriteFoodTruckIdAndFavoriteProfileId($this->getPDO(), $this->foodTruck->getFoodTruckId(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($this->foodTruck->getFoodTruckId(), $pdoFavorite->getFavoriteFoodTruckId());
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoFavorite->getFavoriteAddDate(),$favorite->getFavoriteAddDate(), "", .001);
	}

	/**
	 * test creating a Favorite and then deleting it
	 **/
	public function testDeleteValidFavorite(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		// create a new Favorite and insert into mySQL
		$favorite = new Favorite( $this->foodTruck->getFoodTruckId(), $this->profile->getProfileId(), $this->VALID_FAVORITE_ADD_DATE);
		$favorite->insert($this->getPDO());
		// delete the Favorite from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$favorite->delete($this->getPDO());
		// grab the data from mySQL and enforce the foodTruck does not exist
		$pdoFavorite = Favorite::getFavoriteByFavoriteFoodTruckIdAndFavoriteProfileId($this->getPDO(), $this->foodTruck->getFoodTruckId(), $this->profile->getProfileId());
		$this->assertNull($pdoFavorite);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
	}

	/**
	 * test inserting a Favorite and grabbing it from mySQL
	 **/
	public function testGetValidFavoriteByFoodTruckByFoodTruckIdAndProfileId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		// create a new Favorite and insert into mySQL
		$favorite = new Favorite($this->foodTruck->getFoodTruckId(), $this->profile->getProfileId(), $this->VALID_FAVORITE_ADD_DATE);
		$favorite->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteFoodTruckIdAndFavoriteProfileId($this->getPDO(), $this->foodTruck->getFoodTruckId(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteFoodTruckId(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoFavorite->getFavoriteAddDate(), $this->VALID_FAVORITE_ADD_DATE, "", .001);
	}

	/**
	 * test grabbing a Favorite by foodTruck id
	 **/
	public function testGetValidFavoriteByFoodTruckId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		// create a new Favorite and insert into mySQL
		$favorite = new Favorite($this->foodTruck->getFoodTruckId(), $this->profile->getProfileId(), $this->VALID_FAVORITE_ADD_DATE);
		$favorite->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteFoodTruckId($this->getPDO(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FoodTruckFinder\\Capstone\\Favorite", $results);

		// grab the results from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteFoodTruckId(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());

		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoFavorite->getFavoriteAddDate(), $this->VALID_FAVORITE_ADD_DATE, "", .001);
	}

	/**
	 * test grabbing a Favorite by profile id
	 **/
	public function testGetValidFavoriteByProfileId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert into mySQL
		$favorite = new Favorite($this->foodTruck->getFoodTruckId(), $this->profile->getProfileId(), $this->VALID_FAVORITE_ADD_DATE);
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("FoodTruckFinder\\Capstone\\Favorite", $results);

		// grab the results from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteAddDate(), $this->VALID_FAVORITE_ADD_DATE, "", .001);
	}
}