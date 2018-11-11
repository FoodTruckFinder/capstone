<?php

namespace Edu\Cnm\FoodTruckFinder\Test;

use Edu\Cnm\FoodTruckFinder\{Profile};


/**
 * PHPUnit test of the Profile class.
 *
 * @see Profile
 * @author Daniel Nakitare <dnakitare@cnm.edu>
 */
class ProfileTest extends FoodTruckFinderTest {
	/**
	 * valid profile id, this is a primary key
	 * @var uuid $VALID_PROFILE_ID
	 */
	protected $VALID_PROFILE_ID = null;

	/**
	 * placeholder for valid profile activation token
	 * @var string $VALID_ACTIVATION_TOKEN
	 */
	protected $VALID_ACTIVATION_TOKEN = null;

	/**
	 * vaild profile email
	 * @var string $VALID_PROFILE_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL = "this@email.edu";

	/**
	 * placeholder for a valid profile hash
	 * @var $VALID_PROFILE_HASH;
	 */
	protected $VALID_PROFILE_HASH = null;

	/**
	 * valid profile is owner boolean
	 * @var $VALID_PROFILE_IS_OWNER
	 */
	protected $VALID_PROFILE_IS_OWNER = "0";

	/**
	 * valid profile is profile name
	 * @var $VALID_PROFILE_NAME
	 */
	protected $VALID_PROFILE_NAME = "IAmATest011";

	/**
	 * default setup operation to create salt and hash
	 */
	public final function setUp() : void {
		parent::setUp();

		// creating hashed password and random token
		$password = "1234abcd";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid Profile and verify thath the actual mySQL data matches
	 */
	public function testInsertValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create new profile and insert into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ID, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_PROFILE_IS_OWNER);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 */
	public function testUpdateValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new profile and update it in mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ID, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// edit the profile and update it in mySQL
		$profile->setProfileContent($this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_NAME);
		$profile->update($this->getPDO());

		// grab the date from mySQL and enforce the fields match out expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_PROFILE_IS_OWNER);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}

	/**
	 * test creating and then deleting a Profile
	 */
	public function testDeleteValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

	}






}