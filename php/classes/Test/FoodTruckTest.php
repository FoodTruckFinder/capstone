<?php

namespace FoodTruckFinder\Capstone\Test;

use FoodTruckFinder\Capstone\{Profile, FoodTruck};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 1) . "/ValidateUuid.php");

/**
 * Full PHPUnit test for the FoodTruck class
 *
 * This is a complete PHPUnit test of the FoodTruck class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see FoodTruck
 * @author Greg Klein <gklein@cnm.edu>
 **/

 class FoodTruckTest extends FoodTruckFinderTest {
	 /**
	  * Profile that created the FoodTruck; this is for foreign key relations
	  * @var Profile profile
	  **/
	  protected $profile = null;

	 /**
	  * valid profile hash to create the profile object to own the test
	  * @var $VALID_HASH
	  */
	 protected $VALID_PROFILE_HASH;

	 /**
	  * content of the food truck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION
	  **/
	  protected $VALID_FOODTRUCKDESCRIPTION = "Food truck description";

	 /**
	  * content of the updated foodTruck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION2
	  **/
	  protected $VALID_FOODTRUCKDESCRIPTION2 = "second food truck description";

	 /**
	  * content of the food truck image url
	  * @var string $VALID_FOODTRUCKIMAGEURL
	  **/
	 protected $VALID_FOODTRUCKIMAGEURL = "truckimgurl.com";

	 /**
	  * content of the updated foodTruck image url
	  * @var string $VALID_FOODTRUCKIMAGEURL2
	  **/
	 protected $VALID_FOODTRUCKIMAGEURL2 = "secondimgurl.com";

	 /**
	  * content of the food truck menu url
	  * @var string $VALID_FOODTRUCKMENUURL
	  **/
	 protected $VALID_FOODTRUCKMENUURL = "foodtruckmenuurl.com";

	 /**
	  * content of the updated foodTruck menu url
	  * @var string $VALID_FOODTRUCKMENUURL2
	  **/
	 protected $VALID_FOODTRUCKMENUURL2 = "secondmenuurl.com";

	 /**
	  * content of the food truck name
	  * @var string $VALID_FOODTRUCKNAME
	  **/
	 protected $VALID_FOODTRUCKNAME = "foodtruck name";

	 /**
	  * content of the updated foodTruck name
	  * @var string $VALID_FOODTRUCKNAME2
	  **/
	 protected $VALID_FOODTRUCKNAME2 = "second foodtruck name";

	 /**
	  * content of the food truck phone number
	  * @var string $VALID_FOODTRUCKPHONENUMBER
	  **/
	 protected $VALID_FOODTRUCKPHONENUMBER = "5555555555";

	 /**
	  * content of the updated foodTruck phone number
	  * @var string $VALID_FOODTRUCKPHONENUMBER2
	  **/
	 protected $VALID_FOODTRUCKPHONENUMBER2 = "6666666666";

 /**
 * create dependent objects before running each test
 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

		// create and insert a Profile to own the test FoodTruck
		$this->profile = new Profile(generateUuidV4(), null,"example@gmail.com", $this->VALID_PROFILE_HASH, 1, "chadstruck");
		$this->profile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid food truck and verify that the actual mySQL data matches
	 **/
		public function testInsertValidFoodTruck() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("foodTruck");

		// create a new food truck and insert to into mySQL
		$foodTruckId = generateUuidV4();
		$foodTruck = new FoodTruck($foodTruckId, $this->profile->getProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
		$foodTruck->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFoodTruck = FoodTruck::getFoodTruckByFoodTruckId($this->getPDO(), $foodTruck->getFoodTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("foodTruck"));
		$this->assertEquals($pdoFoodTruck->getFoodTruckId(), $foodTruckId);
		$this->assertEquals($pdoFoodTruck->getFoodTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckDescription(), $this->VALID_FOODTRUCKDESCRIPTION);
		$this->assertEquals($pdoFoodTruck->getFoodTruckImageUrl(), $this->VALID_FOODTRUCKIMAGEURL);
		$this->assertEquals($pdoFoodTruck->getFoodTruckMenuUrl(), $this->VALID_FOODTRUCKMENUURL);
		$this->assertEquals($pdoFoodTruck->getFoodTruckName(), $this->VALID_FOODTRUCKNAME);
		$this->assertEquals($pdoFoodTruck->getFoodTruckPhoneNumber(), $this->VALID_FOODTRUCKPHONENUMBER);
	}

	/**
	 * test inserting a FoodTruck, editing the description, and then updating it
	 **/
		public function testUpdateValidFoodTruckDescription() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("foodTruck");

		// create a new food truck and insert to into mySQL
		$foodTruckId = generateUuidV4();
		$foodTruck = new FoodTruck($foodTruckId, $this->profile->getProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
		$foodTruck->insert($this->getPDO());

		// edit the food truck image url and update it in mySQL
		$foodTruck->setFoodTruckDescription($this->VALID_FOODTRUCKDESCRIPTION2);
		$foodTruck->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFoodTruck = FoodTruck::getFoodTruckByFoodTruckId($this->getPDO(), $foodTruck->getFoodTruckId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckId(), $foodTruckId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("foodTruck"));
		$this->assertEquals($pdoFoodTruck->getFoodTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckDescription(), $this->VALID_FOODTRUCKDESCRIPTION2);
	}

	/**
	 * test inserting a FoodTruck, editing the image url, and then updating it
	 **/
		public function testUpdateValidFoodTruckImageUrl() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("foodTruck");

		// create a new food truck and insert to into mySQL
		$foodTruckId = generateUuidV4();
		$foodTruck = new FoodTruck($foodTruckId, $this->profile->getProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
		$foodTruck->insert($this->getPDO());

		// edit the food truck menu url and update it in mySQL
		$foodTruck->setFoodTruckImageUrl($this->VALID_FOODTRUCKIMAGEURL2);
		$foodTruck->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFoodTruck = FoodTruck::getFoodTruckByFoodTruckId($this->getPDO(), $foodTruck->getFoodTruckId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckId(), $foodTruckId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("foodTruck"));
		$this->assertEquals($pdoFoodTruck->getFoodTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckImageUrl(), $this->VALID_FOODTRUCKIMAGEURL2);
	}

	/**
	 * test inserting a FoodTruck, editing the menu url, and then updating it
	 **/
		public function testUpdateValidFoodTruckMenuUrl() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("foodTruck");

		// create a new food truck and insert to into mySQL
		$foodTruckId = generateUuidV4();
		$foodTruck = new FoodTruck($foodTruckId, $this->profile->getProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
		$foodTruck->insert($this->getPDO());

		// edit the food truck menu url and update it in mySQL
		$foodTruck->setFoodTruckMenuUrl($this->VALID_FOODTRUCKMENUURL2);
		$foodTruck->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFoodTruck = FoodTruck::getFoodTruckByFoodTruckId($this->getPDO(), $foodTruck->getFoodTruckId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckId(), $foodTruckId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("foodTruck"));
		$this->assertEquals($pdoFoodTruck->getFoodTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckMenuUrl(), $this->VALID_FOODTRUCKMENUURL2);
	}

	/**
	 * test inserting a FoodTruck, editing the name, and then updating it
	 **/
		public function testUpdateValidFoodTruckName() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("foodTruck");

		// create a new food truck and insert to into mySQL
		$foodTruckId = generateUuidV4();
		$foodTruck = new FoodTruck($foodTruckId, $this->profile->getProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
		$foodTruck->insert($this->getPDO());

		// edit the food truck name and update it in mySQL
		$foodTruck->setFoodTruckName($this->VALID_FOODTRUCKNAME2);
		$foodTruck->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFoodTruck = FoodTruck::getFoodTruckByFoodTruckId($this->getPDO(), $foodTruck->getFoodTruckId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckId(), $foodTruckId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("foodTruck"));
		$this->assertEquals($pdoFoodTruck->getFoodTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckName(), $this->VALID_FOODTRUCKNAME2);
	}

	/**
	 * test inserting a FoodTruck, editing the phone number, and then updating it
	 **/
		public function testUpdateValidFoodTruckPhoneNumber() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("foodTruck");

		// create a new food truck and insert to into mySQL
		$foodTruckId = generateUuidV4();
		$foodTruck = new FoodTruck($foodTruckId, $this->profile->getProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
		$foodTruck->insert($this->getPDO());

		// edit the food truck phone number and update it in mySQL
		$foodTruck->setFoodTruckPhoneNumber($this->VALID_FOODTRUCKPHONENUMBER2);
		$foodTruck->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFoodTruck = FoodTruck::getFoodTruckByFoodTruckId($this->getPDO(), $foodTruck->getFoodTruckId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckId(), $foodTruckId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("foodTruck"));
		$this->assertEquals($pdoFoodTruck->getFoodTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckPhoneNumber(), $this->VALID_FOODTRUCKPHONENUMBER2);
	}

		/**
		 * test creating a food truck and then deleting it
		 **/
		public function testDeleteValidFoodTruck() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("foodTruck");

		// create a new food truck and insert to into mySQL
		$foodTruckId = generateUuidV4();
		$foodTruck = new FoodTruck($foodTruckId, $this->profile->getProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
		$foodTruck->insert($this->getPDO());

		// delete the food truck from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("foodTruck"));
		$foodTruck->delete($this->getPDO());

		// grab the data from mySQL and enforce the food truck does not exist
		$pdoFoodTruck = FoodTruck::getFoodTruckByFoodTruckId($this->getPDO(), $foodTruck->getFoodTruckId());
		$this->assertNull($pdoFoodTruck);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("foodTruck"));
	}

		/**
		 * test inserting a food truck and regrabbing it from mySQL
		 **/
		public function testGetValidFoodTruckByFoodTruckProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("foodTruck");

		// create a new food truck and insert to into mySQL
		$foodTruckId = generateUuidV4();
		$foodTruck = new FoodTruck($foodTruckId, $this->profile->getProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
		$foodTruck->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = FoodTruck::getFoodTruckByFoodTruckProfileId($this->getPDO(), $foodTruck->getFoodTruckProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("foodTruck"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruckFinder", $results);

		// grab the result from the array and validate it
		$pdoFoodTruck = $results[0];

		$this->assertEquals($pdoFoodTruck->getFoodTruckId(), $foodTruckId);
		$this->assertEquals($pdoFoodTruck->getFoodTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFoodTruck->getFoodTruckDescription(), $this->VALID_FOODTRUCKDESCRIPTION);
		$this->assertEquals($pdoFoodTruck->getFoodTruckImageUrl(), $this->VALID_FOODTRUCKIMAGEURL);
		$this->assertEquals($pdoFoodTruck->getFoodTruckMenuUrl(), $this->VALID_FOODTRUCKMENUURL);
		$this->assertEquals($pdoFoodTruck->getFoodTruckName(), $this->VALID_FOODTRUCKNAME);
		$this->assertEquals($pdoFoodTruck->getFoodTruckPhoneNumber(), $this->VALID_FOODTRUCKPHONENUMBER);
	}
 }