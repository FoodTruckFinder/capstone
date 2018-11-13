<?php

namespace FoodTruckFinder\Capstone\Test;

use FoodTruckFinder\Capstone\Social;



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
	protected $VALID_SOCIAL_FOOD_TRUCK_ID_;

	/**
	 * vaild social URL
	 * @var string $VALID_SOCIAL_URL
	 */
	protected $VALID_SOCIAL_URL = "";

	/**
	 *Test set up for Uuid
	 */

	public final function setUp() : void {
		parent::setUp();

		// create and insert a Profile to own the test FoodTruck
		$this->testInsertValidSocial(); = new social(generateUuidV4(), null,"this is a social url", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "chadstruck", "5555555555");
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

		$social = new Soical($socialId, $this->VALID_SOCIAL_FOOD_TRUCK_ID_, $this->VALID_SOCIAL_URL );
		$social->insert($this->getPDO());

		// edit the social and update it in mySQL
		$social->setSocialContent($this->VALID_SOCIAL_ID, $this->VALID_SOCIAL_FOOD_TRUCK_ID_, $this->VALID_SOCIAL_URL);
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
		$data = file_get_contents("$this->API?socialUrl=$socialUrl");
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

		// create a new Favorite and insert into mySQL
		$favorite = new Social($this->Social->getSocialId(), $this->SocialFoodTruckId->getSocialFoodTruckId());
		$favorite->insert($this->getPDO());

		// delete the Social from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("Social"));
		$this->delete($this->getPDO());

		// grab the data from mySQL and enforce the foodTruck does not exist
		$pdoSocial = Social::getSocialBySocialFoodTruckIdAndSocialProfileId($this->getPDO(), $this->social->getSocialId(), $this->foodtruck->getSocialFoodTruckId());
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
		$pdoSocial = Profile::getSocialySocialId($this->getPDO(), $social->getSocialId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertEquals($pdoSocial->getSocialId(), $socialId);
		$this->assertEquals($pdoSocial->getSocialFoodTruckId(), $this->VALID_SOCIAL_FOOD_TRUCK_ID_);
		$this->assertEquals($pdoSocial->getSocialUrl(), $this->VALID_SOCIAL_URL);
	}

		/**
		 * test getting a Social that doesn't exist by social id
		 */
		public
		function testGetInvalidSocialBySocialId(): void {
			// grab a social id that doesn't exist?
			$invalidSocialId = generateUuidV4();

			$social = Social::getSocialBySocialId($this->getPDO(), "$invalidSocialId");
			$this->assertNull($social);
		}


	// Social food truck Id test?
	/**
	 * test creating a social and then taking it from mySQL by socialFoodTruckId
	 */
	public function testGetValidSocialFoodTruckById() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		// create a new social and insert into mySQL
		$socialFoodTruckId = generateUuidV4();

		$social = new Social($socialFoodTruckId, $this->VALID_SOCIAL_FOOD_TRUCK_ID_, $this->VALID_SOCIAL_URL);
		$social->insert($this->getPDO());

		// grab the date from mySQL and enforce the fields match out expectations
		$pdoSocial = Profile::getSocialySocialFoodTruckId($this->getPDO(), $social->getSocialFoodTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertEquals($pdoSocial->getSocialId(),$socialId);
		$this->assertEquals($pdoSocial->getSocialFoodTruckId(), $this->VALID_SOCIAL_FOOD_TRUCK_ID_);
		$this->assertEquals($pdoSocial->getSocialUrl(), $this->VALID_SOCIAL_URL);
	}

	/**
	 * test getting a social that doesn't exist by social food truck id
	 */
	public
	function testGetInvalidSocialBySocialFoodTruckId(): void {
		// grab a social food truck id that doesn't exist?
		$invalidSocialFoodTruckId = generateUuidV4();

		$social = Social::getSocialBySocialFoodTruckId($this->getPDO(), "$invalidSocialFoodTruckId");
		$this->assertNull($social);
	}

}
