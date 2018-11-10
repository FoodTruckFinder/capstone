<?php

namespace Edu\Cnm\FoodTruckFinder\Test;

use Edu\Cnm\FoodTruckFinder\{profile, foodTruck};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

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
	  protected $VALID_FOODTRUCKDESCRIPTION = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION2
	  **/
	  protected $VALID_FOODTRUCKDESCRIPTION2 = "PHPUnit test still passing";

	 /**
	  * content of the food truck image url
	  * @var string $VALID_FOODTRUCKIMAGEURL
	  **/
	 protected $VALID_FOODTRUCKIMAGEURL = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck image url
	  * @var string $VALID_FOODTRUCKIMAGEURL2
	  **/
	 protected $VALID_FOODTRUCKIMAGEURL2 = "PHPUnit test still passing";

	 /**
	  * content of the food truck menu url
	  * @var string $VALID_FOODTRUCKMENUURL
	  **/
	 protected $VALID_FOODTRUCKMENUURL = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck menu url
	  * @var string $VALID_FOODTRUCKMENUURL2
	  **/
	 protected $VALID_FOODTRUCKMENUURL2 = "PHPUnit test still passing";

	 /**
	  * content of the food truck name
	  * @var string $VALID_FOODTRUCKNAME
	  **/
	 protected $VALID_FOODTRUCKNAME = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck name
	  * @var string $VALID_FOODTRUCKNAME2
	  **/
	 protected $VALID_FOODTRUCKNAME2 = "PHPUnit test still passing";

	 /**
	  * content of the food truck phone number
	  * @var string $VALID_FOODTRUCKPHONENUMBER
	  **/
	 protected $VALID_FOODTRUCKPHONENUMBER = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck phone number
	  * @var string $VALID_FOODTRUCKPHONENUMBER2
	  **/
	 protected $VALID_FOODTRUCKPHONENUMBER2 = "PHPUnit test still passing";
 }


/**
 * create dependent objects before running each test
 **/
public final function setUp()  : void {
	// run the default setUp() method first
	parent::setUp();

	// create and insert a Profile to own the test FoodTruck
	$this->profile = new FoodTruck(generateUuidV4(), null,"this is a food truck", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "chadstruck", "5555555555");
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
 * test inserting a FoodTruck, editing it, and then updating it
 **/
	public function testUpdateValidFoodTruck() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("foodTruck");

	// create a new Tweet and insert to into mySQL
	$foodTruckId = generateUuidV4();
	$foodTruck = new FoodTruck($foodTruckId, $this->profile->getFoodTruckProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
	$foodTruck->insert($this->getPDO());

	// edit the food truck description and update it in mySQL
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
	 * test creating a food truck and then deleting it
	 **/
	public function testDeleteValidFoodTruck() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("foodTruck");

	// create a new food truck and insert to into mySQL
	$foodTruckId = generateUuidV4();
	$foodTruck = new FoodTruck($foodTruckId, $this->profile->getFoodTruckProfileId(), $this->VALID_FOODTRUCKDESCRIPTION, $this->VALID_FOODTRUCKIMAGEURL, $this->VALID_FOODTRUCKMENUURL, $this->VALID_FOODTRUCKNAME, $this->VALID_FOODTRUCKPHONENUMBER);
	$foodTruck->insert($this->getPDO());

	// delete the food truck from mySQL
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("foodTruck"));
	$foodTruck->delete($this->getPDO());

	// grab the data from mySQL and enforce the food truck does not exist
	$pdoFoodTruck = FoodTruck::getFoodTruckByFoodTruckId($this->getPDO(), $foodTruck->getFoodTruckId());
	$this->assertNull($pdoFoodTruck);
	$this->assertEquals($numRows, $this->getConnection()->getRowCount("foodTruck"));
}
