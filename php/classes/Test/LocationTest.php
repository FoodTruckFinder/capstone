<?php

namespace Edu\Cnm\FoodTruckFinder\Test;

use Edu\Cnm\FoodTruckFinder\{FoodTruck, Location};

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

		// create and insert a FoodTruck Record to own the test Location
		$this->foodTruck = new FoodTruck(generateUuidV4(), generateUuidV4(), "I am a PHPFoodTruck Description", "http://www.jammincrepes.com/wp-content/uploads/2017/02/Also-Okay-to-use-1024x617.jpg", "https://www.ryouhooked.com/menu.html", "Bubba Shimp n Grits FoodTruck");
		$this->foodTruck->insert($this->getPDO());

		//format the location start time to use for testing
		$this->VALID_LOCATIONSTARTTIME = new \DateTime();
		$this->VALID_LOCATIONSTARTTIME->sub(new \DateInterval("P10H"));

		//format the location end time to use for testing
		$this->VALID_LOCATIONENDTIME = new\DateTime();
		$this->VALID_LOCATIONENDTIME->add(new \DateInterval("P10H"));



	}

	/**
	 * test inserting a valid Location and verify that the actual mySQL data matches
	 **/
	public function testInsertValidLocationId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$locationId = generateUuidV4();
		$location = new Location($locationId, $this->foodTruck->getFoodTruckId(), $this->VALID_LOCATIONENDTIME, $this->VALID_LOCATIONLATITUDE, $this->VALID_LOCATIONLONGITUDE, $this->VALID_LOCATIONSTARTTIME);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoLocation = Location::getLocationFoodTruckIdByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertEquals($pdoLocation->getLocationId(), $locationId);
		$this->assertEquals($pdoLocation->getLocationFoodTruckId(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($pdoLocation->getLocationLatitude(), $this->VALID_LOCATIONLATITUDE);
		$this->assertEquals($pdoLocation->getLocationLongitude(), $this->VALID_LOCATIONLONGITUDE);
		//format the Location Start and End Time to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getLocationStartTime()->getTimestamp(), $this->VALID_LOCATIONSTARTTIME->getTimestamp());
		$this->assertEquals($pdoLocation->getLocationEndTIme()->getTimestamp(), $this->VALID_LOCATIONENDTIME->getTimestamp());
	}

	/**
	 * test inserting a Location, editing it, and then updating it
	 **/
	public function testUpdateValidLocationId() : void {
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
		$this->assertEquals($pdoLocation->getLocationId(), $locationId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertEquals($pdoLocation->getLocationFoodTruckId(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($pdoLocation->getLocationEndTime(), $this->VALID_LOCATIONENDTIME);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoLocation->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}


	/**
	 * test creating a LocationId and then deleting it
	 **/
	public function testDeleteValidLocationId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Tweet and insert to into mySQL
		$locationId = generateUuidV4();
		$location = new Location($locationId, $this->foodTruck->getFoodTruckId(),$this->VALID_LOCATIONENDTIME, $this->VALID_LOCATIONLATITUDE, $this->VALID_LOCATIONLONGITUDE, $this->VALID_LOCATIONSTARTTIME);
		$location->insert($this->getPDO());

		// delete the Tweet from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("location"));
		$location->delete($this->getPDO());

		// grab the data from mySQL and enforce the Tweet does not exist
		$pdoLocation = Location::getLocationFoodTruckIdByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertNull($pdoLocation);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("location"));
	}

	/**
	 * test inserting a Tweet and regrabbing it from mySQL
	 **/
	public function testGetValidTweetByTweetProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getTweetByTweetProfileId($this->getPDO(), $tweet->getTweetProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];

		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}

	/**
	 * test grabbing a Tweet by tweet content
	 **/
	public function testGetValidTweetByTweetContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getTweetByTweetContent($this->getPDO(), $tweet->getTweetContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}

	/**
	 * test grabbing all Tweets
	 **/
	public function testGetAllValidTweets() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Tweet and insert to into mySQL
		$tweetId = generateUuidV4();
		$tweet = new Tweet($tweetId, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getAllTweets($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);

		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetId(), $tweetId);
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}
}











?>