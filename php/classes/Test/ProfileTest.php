<?php

namespace Edu\Cnm\FoodTruckFinder\Test;

use Edu\Cnm\FoodTruckFinder\{Profile};


/**
 * PHPUnit test of the Profile class.
 *
 * @see \Edu\Cnm\FoodTruckFinder\Profile
 * @author Daniel Nakitare <dnakitare@cnm.edu>
 */
class ProfileTest extends FoodTruckFinderTest {


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
	public function testUpdateValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new profile and update it in mySQL
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
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
	public function testGetValidProfileById() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert into mySQL
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

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
	 * test grabbing a Profile that doesn't exist
	 */
	public function testGetInvalidProfileByProfileId () : void {
		// grab a profile id that doesn't exist?
		$invalidProfileId = generateUuidV4();

		$profile = Profile::getProfileByProfileId($this->getPDO() , "$invalidProfileId");
		$this->assertNull($profile);
	}

	/**
	 * test getting a Profile by profile name
	 */
	public function testGetValidProfileByProfileName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert into mySQL
		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_IS_OWNER, $this->VALID_PROFILE_NAME);
		$profile->insert($this->getPDO());

		// get Profile for database using profile name
		$results = Profile::getProfileByProfileName($this->getPDO(), $this->VALID_PROFILE_NAME);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		// make sure no other objects are contaminating the profile
		$this->asseertContainsOnlyInstanceOf("Edu\\Cnm\\FoodTruckFinder\\Profile", $results);

		// make sure results are same as expected
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_PROFILE_IS_OWNER);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILE_NAME);
	}






}