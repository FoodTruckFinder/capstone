<?php

namespace FoodTruckFinder\Capstone\Test;
use FoodTruckFinder\Capstone\Location;
use FoodTruckFinder\Capstone\Profile;
use FoodTruckFinder\Capstone\FoodTruck;

require_once ("FoodTruckFinderTestSetup.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Location class
 *
 * This is a complete PHPUnit test of the Location class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Location
 * @author Dylan McDonald  <dmcdonald21@cnm.edu>
 * @author David Sanderson <sanderdj90@gmail.com>
 **/
class LocationTest extends FoodTruckFinderTest {
	/**
	 * FoodTruck that created the Location; this is for foreign key relations
	 * @var FoodTruck $foodTruck
	 *
	 **/
	protected $foodTruck = null;

	/**
	 * Uuid of the location
	 * @var uuid $VALID_LOCATION_ID
	 */
	protected $VALID_LOCATION_ID = null;

	/**
	 * UUId of the foodTruck
	 * @var uuid $VALID_LOCATIONFOODTRUCK_ID
	 **/
	protected $VALID_LOCATION_FOODTRUCK_ID = null;

	/**
	 * Valid Date Object and is assigned later.
	 */
	protected $VALID_LOCATIONENDTIME = null;

	/**
	 * latitude coords of location
	 * @var float $VALID_LOCATIONLATITUDE
	 **/
	protected $VALID_LOCATIONLATITUDE = 87;

	/**
	 * longitude coords of location
	 * @var \float $VALID_LOCATIONLONGITUDE
	 **/
	protected $VALID_LOCATIONLONGITUDE = -160;

	/**
	 * Valid Date Object and is assigned later.
	 */
	protected $VALID_LOCATIONSTARTTIME = null;



	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();


	/**	// create and insert a Profile Record to own the test FoodTruck
		$this->profile = new Profile(generateUuidV4(), );
	 *
	 * */

		// create and insert a Profile Record to own the FoodTruck and test Location
		$password = "1234abcd";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->profile = new Profile(generateUuidV4(), null,"example@gmail.com", $this->VALID_PROFILE_HASH, 1, "chadstruck");
		$this->profile->insert($this->getPDO());




		// create and insert a FoodTruck Record to own the test Location
		$this->foodTruck = new FoodTruck(generateUuidV4(), $this->profile->getProfileId(), "I am a PHPFoodTruck Description", "http://www.jammincrepes.com/wp-content/uploads/2017/02/Also-Okay-to-use-1024x617.jpg", "https://www.ryouhooked.com/menu.html", "Bubba Shrimp n Grits FoodTruck", "505-555-5555");
		$this->foodTruck->insert($this->getPDO());


		//format the location start time to use for testing
		$this->VALID_LOCATIONSTARTTIME = new \DateTime();
		$this->VALID_LOCATIONSTARTTIME->sub(new \DateInterval("PT10H"));

		//format the location end time to use for testing
		$this->VALID_LOCATIONENDTIME = new\DateTime();
		$this->VALID_LOCATIONENDTIME->add(new \DateInterval("PT10H"));



	}

	/**
	 * test inserting a valid Location and verify that the actual mySQL data matches
	 **/
	public function testInsertValidLocation() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");
		// create a new Location and insert to into mySQL
		$locationId = generateUuidV4();
		$location = new Location($locationId, $this->foodTruck->getFoodTruckId(), $this->VALID_LOCATIONENDTIME, $this->VALID_LOCATIONLATITUDE, $this->VALID_LOCATIONLONGITUDE, $this->VALID_LOCATIONSTARTTIME);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoLocation = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertEquals($pdoLocation->getLocationId(), $locationId);
		$this->assertEquals($pdoLocation->getLocationFoodTruckId(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($pdoLocation->getLocationLatitude(), $this->VALID_LOCATIONLATITUDE);
		$this->assertEquals($pdoLocation->getLocationLongitude(), $this->VALID_LOCATIONLONGITUDE);
		//format the Location Start and End Time to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getLocationStartTime()->getTimestamp(), $this->VALID_LOCATIONSTARTTIME->getTimestamp());
		$this->assertEquals($pdoLocation->getLocationEndTime()->getTimestamp(), $this->VALID_LOCATIONENDTIME->getTimestamp());
	}

	/*
	 * test inserting a Location, editing it, and then updating it
	 * @throws
	public function testUpdateValidLocation() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$locationId = generateUuidV4();
		$location = new Location($locationId, $this->foodTruck->getFoodTruckId(), $this->VALID_LOCATIONENDTIME, $this->VALID_LOCATIONLATITUDE, $this->VALID_LOCATIONLONGITUDE, $this->VALID_LOCATIONSTARTTIME);
		$location->insert($this->getPDO());

		// edit the locationId and update it in mySQL
		$VALID_LOCATION_ID = generateUuidV4();
		$location->setLocationId($this->$VALID_LOCATION_ID);
		$location->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoLocation = Location::getLocationFoodTruckIdByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertEquals($pdoLocation->getLocationId(), $VALID_LOCATION_ID);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertEquals($pdoLocation->getLocationFoodTruckId(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($pdoLocation->getLocationEndTime()->getTimestamp(), $this->VALID_LOCATIONENDTIME->getTimestamp());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getLocationLatitude(), $this->VALID_LOCATIONLATITUDE);
		$this->assertEquals($pdoLocation->getLocationLongitude(), $this->VALID_LOCATIONLONGITUDE);
		$this->assertEquals($pdoLocation->getLocationStartTime()->getTimestamp(), $this->VALID_LOCATIONSTARTTIME->getTimestamp());
	}
	 **/


	/**
	 * test creating a Location and then deleting it
	 *
	 **/
	public function testDeleteValidLocation() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$locationId = generateUuidV4();
		$location = new Location($locationId, $this->foodTruck->getFoodTruckId(),$this->VALID_LOCATIONENDTIME, $this->VALID_LOCATIONLATITUDE, $this->VALID_LOCATIONLONGITUDE, $this->VALID_LOCATIONSTARTTIME);
		$location->insert($this->getPDO());

		// delete the Location from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$location->delete($this->getPDO());

		// grab the data from mySQL and enforce the Location does not exist
		$pdoLocation = Location::getLocationFoodTruckIdByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertNull($pdoLocation);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("location"));
	}

	/**
	 * test inserting a Location and retrieving it from mySQL
	 */
	public function testGetValidLocationByLocationFoodTruckId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$locationId = generateUuidV4();
		$location = new Location($locationId, $this->foodTruck->getFoodTruckId(),$this->VALID_LOCATIONENDTIME, $this->VALID_LOCATIONLATITUDE, $this->VALID_LOCATIONLONGITUDE, $this->VALID_LOCATIONSTARTTIME);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Location::getLocationByLocationFoodTruckId($this->getPDO(), $location->getLocationFoodTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));

		// grab the result from the array and validate it
		$pdoLocation = $results;

		$this->assertEquals($pdoLocation->getLocationId(), $locationId);
		$this->assertEquals($pdoLocation->getLocationFoodTruckId(), $this->foodTruck->getFoodTruckId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getLocationEndTime()->getTimestamp(), $this->VALID_LOCATIONENDTIME->getTimestamp());
		$this->assertEquals($pdoLocation->getLocationLatitude(), $this->VALID_LOCATIONLATITUDE);
		$this->assertEquals($pdoLocation->getLocationLongitude(), $this->VALID_LOCATIONLONGITUDE);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getLocationStartTime()->getTimestamp(), $this->VALID_LOCATIONSTARTTIME->getTimestamp());
	}

	/**
	 * test grabbing a Location by LocationFoodTruckId
	 **/

	/*
	public function testGetValidLocationByLocationId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$locationId = generateUuidV4();
		$location = new Location($locationId, $this->foodTruck->getFoodTruckId(),$this->VALID_LOCATIONENDTIME, $this->VALID_LOCATIONLATITUDE, $this->VALID_LOCATIONLONGITUDE, $this->VALID_LOCATIONSTARTTIME);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));

		// grab the result from the array and validate it
		$pdoLocation = $results;

		$this->assertEquals($pdoLocation->getLocationId(), $locationId);
		$this->assertEquals($pdoLocation->getLocationFoodTruckId(), $this->foodTruck->getFoodTruckId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getLocationEndTime()->getTimestamp(), $this->VALID_LOCATIONENDTIME->getTimestamp());
		$this->assertEquals($pdoLocation->getLocationLatitude(), $this->VALID_LOCATIONLATITUDE);
		$this->assertEquals($pdoLocation->getLocationLongitude(), $this->VALID_LOCATIONLONGITUDE);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getLocationStartTime()->getTimestamp(), $this->VALID_LOCATIONSTARTTIME->getTimestamp());
	}
*/

	/**
	 * test grabbing all Locations
	 **/
	public function testGetAllValidLocations() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$locationId = generateUuidV4();
		$location = new Location($locationId, $this->foodTruck->getFoodTruckId(), $this->VALID_LOCATIONENDTIME, $this->VALID_LOCATIONLATITUDE, $this->VALID_LOCATIONLONGITUDE, $this->VALID_LOCATIONSTARTTIME);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Location::getAllLocations($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FoodTruckFinder\\Capstone\\Location", $results);

		// grab the result from the array and validate it
		$pdoLocation = $results[0];
		$this->assertEquals($pdoLocation->getLocationId(), $locationId);
		$this->assertEquals($pdoLocation->getLocationFoodTruckId(), $this->foodTruck->getFoodTruckId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getLocationEndTime()->getTimestamp(), $this->VALID_LOCATIONENDTIME->getTimestamp());
		$this->assertEquals($pdoLocation->getLocationLatitude(), $this->VALID_LOCATIONLATITUDE);
		$this->assertEquals($pdoLocation->getLocationLongitude(), $this->VALID_LOCATIONLONGITUDE);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getLocationStartTime()->getTimestamp(), $this->VALID_LOCATIONSTARTTIME->getTimestamp());
	}
}







