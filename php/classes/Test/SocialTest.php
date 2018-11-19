<?php

namespace FoodTruckFinder\Capstone\Test;

use FoodTruckFinder\Capstone\{Profile, FoodTruck, Social};
use Ramsey\Uuid\Uuid;

// grab test setup
require_once("FoodTruckFinderTestSetup.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


/**
 * PHPUnit test of the Social class.
 *
 * @see Social
 * @author Rae Jack
 */
class SocialTest extends FoodTruckFinderTest {


	/**
	 * Profile that created the FoodTruck; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;


	/**
	 * FoodTruck that created the Location; this is for foreign key relations
	 * @var FoodTruck $foodTruck
	 *
	 **/
	protected $foodTruck = null;



	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */

	protected $VALID_PROFILE_HASH;


	/**
	 * valid social id, this is a primary key
	 * @var Uuid $VALID_PROFILE_ID
	 */
	protected $VALID_SOCIAL_ID;

	/**
	 * placeholder for valid social food truck Id
	 * @var Uuid $VALID_SOCIAL_FOOD_TRUCK_ID
	 */
	protected $VALID_SOCIAL_FOOD_TRUCK_ID_;

	/**
	 * valid social URL
	 * @var string $VALID_SOCIAL_URL
	 */
	protected $VALID_SOCIAL_URL = "https://www.facebook.com";

	/**
	 * valid social URL
	 * @var string $VALID_SOCIAL_URL2
	 */

	protected  $VALID_SOCIAL_URL2 = "https://www.facebook.com";

	/**
	 *Test set up for Uuid
	 */

	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I,["time_cost" => 384]);
		// create and insert a Profile to own the test FoodTruck


		$this->profile = new Profile (generateUuidV4(), null,"example@gmail.com", $this->VALID_PROFILE_HASH, 1, "CHAD");
		$this->profile->insert($this->getPDO());

		// create and insert a FoodTruck Record to own the test Location
		$this->foodTruck = new FoodTruck(generateUuidV4(),$this->profile->getProfileId() , "I am a PHPFoodTruck Description", "http://www.jammincrepes.com/wp-content/uploads/2017/02/Also-Okay-to-use-1024x617.jpg", "https://www.ryouhooked.com/menu.html", "Bubba Shimp n Grits FoodTruck", "505-555-5555");
		$this->foodTruck->insert($this->getPDO());


		$this->social = new Social (generateUuidV4(), $this->foodTruck->getFoodTruckId(), $this->VALID_SOCIAL_URL);
		$this->social->insert($this->getPDO());

	}

	/**
	 * test creating a Social, editing it, and then updating it
	 */
	public function testUpdateValidSocial() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		// create a new social and update it in mySQL
		$socialId = generateUuidV4();

		$social = new Social($socialId, $this->foodTruck->getFoodTruckId(), $this->VALID_SOCIAL_URL );
		$social->insert($this->getPDO());

		// edit the social and update it in mySQL
		$social->setSocialUrl($this->VALID_SOCIAL_URL2);
		$social->update($this->getPDO());

		// grab the date from mySQL and enforce the fields match out expectations
		$pdoSocial = Social::getSocialBySocialId($this->getPDO(), $social->getSocialId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertEquals($pdoSocial->getSocialId(), $socialId);
		$this->assertEquals($pdoSocial->getSocialFoodTruckId(), $this->foodTruck->getFoodtruckId());
		$this->assertEquals($pdoSocial->getSocialUrl(), $this->VALID_SOCIAL_URL2);
	}




// Has errors, not sure

	/**
	 * test inserting a valid social and verify that the actual mySQL data matches
	 */
	public function testInsertValidSocial() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		$socialId = generateUuidV4();

		$social = new Social($socialId, $this->foodTruck->getFoodTruckId(), $this->VALID_SOCIAL_URL);
		$social->insert($this->getPDO());


		// Has syntax errors with colons
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoSocial = Social::getSocialBySocialId($this->getPDO(), $social->getSocialId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertEquals($pdoSocial->getSocialId(), $this->social->getSocialId());
		$this->assertEquals($pdoSocial->getSocialFoodTruckId(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($pdoSocial->getSocialUrl(), $this->VALID_SOCIAL_URL);
	}

// Has errors, not sure
	/**
	 * test creating a social and then deleting it
	 **/
	public function testDeleteValidSocial() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		// create a new social and insert into mySQL
		$socialId = generateUuidV4();

		$social = new Social($socialId, $this->foodTruck->getFoodTruckId(), $this->VALID_SOCIAL_URL);
		$social->insert($this->getPDO());

		// delete the Social from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$social->delete($this->getPDO());

		// grab the data from mySQL and enforce the foodTruck does not exist
		$pdoSocial = Social::getSocialBySocialFoodTruckId($this->getPDO(), $social->getSocialId());
		$this->assertNull($pdoSocial);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("social"));
	}

	// social id test?
	/**
	 * test creating a social and then taking it from mySQL by socialId
	 */
	public function testGetValidSocialById() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		// create a new social and insert into mySQL
		$socialId = generateUuidV4();

		$social = new Social($socialId, $this->foodTruck->getFoodTruckId(), $this->VALID_SOCIAL_URL);
		var_dump($social);
		$social->insert($this->getPDO());

		// grab the date from mySQL and enforce the fields match out expectations
		$pdoSocial = Social::getSocialBySocialId($this->getPDO(), $social->getSocialId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertEquals($pdoSocial->getSocialId(), $socialId);
		$this->assertEquals($pdoSocial->getSocialFoodTruckId(), $this->foodTruck->getFoodTruckId());
		$this->assertEquals($pdoSocial->getSocialUrl(), $this->VALID_SOCIAL_URL);
	}


	// Social food truck Id test?
	/**
	 * test creating a social and then taking it from mySQL by socialFoodTruckId
	 */

	/**
	 * test inserting a social and retrieving it from mySQL
	 **/
	public function testGetValidSocialBySocialFoodTruckId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		// create a new social and insert to into mySQL
		$socialId = generateUuidV4();
		$social = new Social($socialId, $this->foodTruck->getFoodTruckId(), $this->VALID_SOCIAL_URL);
		$social->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Social::getSocialBySocialId($this->getPDO(), $this->social->getSocialFoodTruckId());
		//Added var dump for results, no change
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FoodTruckFinder\\Capstone\\FoodTruck", $results);

		// grab the result from the array and validate it
		$pdoSocial = $results[0];

		$this->assertEquals($pdoSocial->getSocialId(), $social);
		$this->assertEquals($pdoSocial->getSocialFoodTruckId(), $this->social->getSocialId());
		$this->assertEquals($pdoSocial->getSocialUrl(), $this->VALID_SOCIAL_URL);

	}

}
