<?php

namespace FoodTruckFinder\Capstone\Test;

use FoodTruckFinder\Capstone\Social;

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
class SocialTest extends foodTruckFinderTest {
	/**
	 * valid social id, this is a primary key
	 * @var uuid $VALID_PROFILE_ID
	 */
	protected $VALID_SOCIAL_ID = "710a0875-9775-4312-a075-7b1bb2f72622";

	/**
	 * placeholder for valid social food truck Id
	 * @var string $VALID_SOCIAL_FOOD_TRUCK_ID
	 */
	protected $VALID_SOCIAL_FOOD_TRUCK_ID_ = "26e44c14-3ff0-4a66-b730-7a116eb82bbf";

	/**
	 * valid social URL
	 * @var string $VALID_SOCIAL_URL
	 */
	protected $VALID_SOCIAL_URL = "https://www.werock.com/Learn-the-Net-330002341216/";

	/**
	 *Test set up for Uuid
	 */

	public final function setUp() : void {
		parent::setUp();

		// create and insert a Social to own the test FoodTruck- error found
		$this->$this = new Social(generateUuidV4(), new SocialFoodTruckId (), "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif");
		$this->$this->insert($this->getPDO());
	}


	/**
	 * test creating a Social, editing it, and then updating it
	 */
	public function testUpdateValidSocial() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		// create a new social and update it in mySQL
		$socialId = generateUuidV4();

		$social = new Social($socialId, $this->VALID_SOCIAL_FOOD_TRUCK_ID_, $this->VALID_SOCIAL_URL );
		$social->insert($this->getPDO());

		// edit the social and update it in mySQL
		$social->setSocial($this->VALID_SOCIAL_ID, $this->VALID_SOCIAL_FOOD_TRUCK_ID_, $this->VALID_SOCIAL_URL);
		$social->update($this->getPDO());

		// grab the date from mySQL and enforce the fields match out expectations
		$pdoSocial = Social::getSocialBySocialId($this->getPDO(), $social->getSocialId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertEquals($pdoSocial->getSocialId(), $socialId);
		$this->assertEquals($pdoSocial->getSocialFoodTruckId(), $this->VALID_SOCIAL_FOOD_TRUCK_ID_);
		$this->assertEquals($pdoSocial->getSocialUrl(), $this->VALID_SOCIAL_URL);
	}


// Not sure is this is right or needed social url test
	/**
	 * Test testing social URL
	 */
	public function test_Social_url($socialUrl){
		$data = file_get_contents("$this->?socialUrl=$socialUrl");
		$result = json_decode($data, true);
		$this->assertEquals(true, $result['result']);
		$this->assertEquals(500, $result['code']);
	}




// Has errors, not sure

	/**
	 * test inserting a valid social and verify that the actual mySQL data matches
	 */
	public function testInsertValidSocial() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		$socialId = generateUuidV4();

		$social = new Social( $this->VALID_SOCIAL_ID, $this->VALID_SOCIAL_FOOD_TRUCK_ID_, $this->VALID_SOCIAL_URL);
		$social->insert($this->getPDO());


		// Has syntax errors with colons
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoSocial = Social::getSocialBySocialId($this->getPDO(), $social->getSocialId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertEquals($pdoSocial->getSocialBySocialFoodTruckId(), $socialId);
		$this->assertEquals($pdoSocial->getSocialBySocialUrl(), $this->VALID_SOCIAL_URL);
	}

// Has errors, not sure
	/**
	 * test creating a social and then deleting it
	 **/
	public function testDeleteValidSocial() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Social");

		// create a new social and insert into mySQL
		$pdoSocial = new Social($this->Social->getSocialId(), $this->SocialFoodTruckId->getSocialFoodTruckId(), $this->socialUrl->getSocialUrl());
		$pdoSocial->insert($this->getPDO());

		// delete the Social from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Social"));
		$this->delete($this->getPDO());

		// grab the data from mySQL and enforce the foodTruck does not exist
		$pdoSocial = Social::getSocialBySocialFoodTruckId($this->getPDO(), $this->social->getSocialId(), $this->foodtruck->getSocialFoodTruckId());
		$this->assertNull($pdoSocial);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("Social"));
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

		$social = new Social($socialId, $this->VALID_SOCIAL_FOOD_TRUCK_ID_, $this->VALID_SOCIAL_URL);
		$social->insert($this->getPDO());

		// grab the date from mySQL and enforce the fields match out expectations
		$pdoSocial = Social::getSocialySocialId($this->getPDO(), $social->getSocialId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertEquals($pdoSocial->getSocialId(), $socialId);
		$this->assertEquals($pdoSocial->getSocialFoodTruckId(), $this->VALID_SOCIAL_FOOD_TRUCK_ID_);
		$this->assertEquals($pdoSocial->getSocialUrl(), $this->VALID_SOCIAL_URL);
	}


	// Social food truck Id test?
	/**
	 * test creating a social and then taking it from mySQL by socialFoodTruckId
	 */

	/**
	 * test inserting a social and retrieving it from mySQL
	 **/
	public function testGetValidSocialBySocialFoodTruckProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		// create a new social and insert to into mySQL
		$socialId = generateUuidV4();
		$social = new social ($socialId, $this->profile->getProfileId(), $this->VALID_SOCIAL_URL);
		$social->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Social::getSocialBySocialId($this->getPDO(), $social->getSocialFoodTruckId());
		var_dump($results);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FoodTruckFinder\\Capstone\\FoodTruck", $results);

		// grab the result from the array and validate it
		$pdoSocial = $results[0];

		$this->assertEquals($pdoSocial->getSocialId(), $social);
		$this->assertEquals($pdoSocial->getSocialFoodTruckId(), $this->profile->getProfileId());
		$this->assertEquals($pdoSocial->getSocialUrl(), $this->VALID_SOCIAL_URL);

	}



}
