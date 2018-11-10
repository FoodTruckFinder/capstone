<?php

namespace Edu\Cnm\FoodTruckFinder\Test;

use Edu\Cnm\FoodTruckFinder\Test\social;
use Edu\Cnm\FoodTruckFinder\ValidateUuid\Social;


/**
 * PHPUnit test of the Social class.
 *
 * @see Social
 * @author Rae Jack
 */
class SocialTest extends LocationTest {
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

		// creating hashed password and random token
		$password = "1234abcd";
		$this->VALID_SOCIAL_ID = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_SOCIAL_FOOD_TRUCK_ID_ = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid social and verify that the actual mySQL data matches
	 */
	public function testInsertValidSocial() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("social");

		$socialId = generateUuidV4();

		$social = new Profile($social, $this->VALID_SOCIAL_ID, $this->VALID_SOCIAL_FOOD_TRUCK_ID_, $this->VALID_SOCIAL_URL);
		$social->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoSocial = Social::getSocialBySocialId($this->getPDO(), $social->getSocialId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("social"));
		$this->assertEquals($pdoSocial->getSocialBySocialFoodTruckId()Id(); $socialId;
		$this->assertEquals($pdoSocial->getSocialBySocialUrl(), $this->VALID_SOCIAL_URL);
	}
}