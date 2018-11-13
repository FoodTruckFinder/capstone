<?php

namespace FoodTruckFinder\Capstone\Test;

use FoodTruckFinder\Capstone\Profile;

//
require_once ("FoodTruckFinderTestSetup.php");

// get the autoloader
require_once (dirname(__DIR__). "/autoload.php");

// get the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test of the Profile class.
 *
 * @see Profile
 * @author Daniel Nakitare <dnakitare@cnm.edu>
 */
class ProfileTest extends FoodTruckFinderTest {

	/**
	 * placeholder for valid profile activation token
	 * @var string $VALID_ACTIVATION_TOKEN
	 */
	protected $VALID_ACTIVATION_TOKEN = "928764b5b55e063c13339e72f90f3f6a";

	/**
	 * vaild profile email
	 * @var string $VALID_PROFILE_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL = "thisisanemail@email.edu";

	/**
	 * vaild profile email
	 * @var string $VALID_PROFILE_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL2 = "thatisanemail@email.cnm";

	/**
	 * placeholder for a valid profile hash
	 * @var $VALID_PROFILE_HASH;
	 */
	protected $VALID_PROFILE_HASH;

	/**
	 * placeholder for a valid profile hash
	 * @var $VALID_PROFILE_HASH;
	 */
	protected $VALID_PROFILE_HASH2;

	/**
	 * valid profile is owner boolean
	 * @var $VALID_PROFILE_IS_OWNER
	 */
	protected $VALID_PROFILE_IS_OWNER = 1;

	/**
	 * valid profile is profile name
	 * @var $VALID_PROFILE_NAME
	 */
	protected $VALID_PROFILE_NAME = "Chad";

	/**
	 * valid profile is profile name
	 * @var $VALID_PROFILE_NAME
	 */
	protected $VALID_PROFILE_NAME2 = "Brad";

	/**
	 * default setup operation to create salt and hash
	 */
	public final function setUp() : void {
		parent::setUp();

		// creating hashed password and random token
		$password = "1234abcd";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
	}

	/**
	 * test beginning
	 * test creating a valid Profile and verify that the actual mySQL data matches
	 */
	public function testInsertValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create new profile and insert into mySQL
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
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
	 * test creating a Profile, editing it, and then updating it
	 */
	public function testUpdateValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new profile and update it in mySQL
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// edit the profile and update it in mySQL
		$profile->setProfileEmail($this->VALID_PROFILE_EMAIL);
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

		// create a new Profile and insert into mySQL
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// grab the data from mySQL and make sure the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test creating a Profile and then grabbing it from mySQL by profileId
	 */
	public function testGetValidProfileByProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert into mySQL
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// grab the profile from mySQL and enforce the fields match out expectations
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
	 * test getting a Profile by profile email
	 */
	public function testGetProfilebyProfileEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert into mySQL
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// get the Profile from database by profile email
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_PROFILE_IS_OWNER);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}

	/**
	 * test getting a Profile by its activation token
	 */
	public function testGetValidProfileByActivationToken() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert into mySQL
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// get Profile from the database by profile activation token
		$pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_PROFILE_IS_OWNER);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}

}