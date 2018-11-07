<?php

namespace Edu\Cnm\FoodTruckFinder;

require_once "autoload.php";
require_once (dirname(__DIR__, 2) . "vendor/autoload.php");

class Profile implements \JsonSerializable {

	use ValidateUuid;

	/**
	 * id for this profile; this is a primary key
	 * @var Uuid $profileId
	 */
	private $profileId;
	/**
	 * activation token for this profile
	 * @var string $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * the email associated with this profile
	 * @var string $profileEmail
	 */
	private $profileEmail;
	/**
	 * the hashed password of this profile
	 * @var string $profileHash
	 */
	private $profileHash;
	/**
	 * the boolean to check if profile is a truck owner
	 * @var integer $profileIsOwner
	 */
	private $profileIsOwner;
	/**
	 * the profile name provided by the user
	 * @var string $profileName
	 */
	private $profileName;

	/**
	 * constructor for this profile
	 *
	 * @param Uuid | string $newProfileId id of this profile or null if new profile
	 * @param string $newProfileActivationToken activation token of this profile or null if new profile
	 * @param string $newProfileEmail email of this profile or null if new profile
	 * @param string $newProfileHash hashed password of this profile or null if new profile
	 * @param integer $newProfileIsOwner boolean assigning truck owner status of this profile or null if new profile
	 * @param string $newProfileName name of the profile or null if new profile
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */

	public function __construct($newProfileId, $newProfileActivationToken, $newProfileEmail, $newProfileHash, $newProfileIsOwner, $newProfileName) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileIsOwner($newProfileIsOwner);
			$this->setProfileName($newProfileName);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new	$exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of the profile id
	 */
	public function getProfileId() : Uuid {
		return $this->profileId;
	}
	/**
	 * mutator method for profile id
	 *
	 * @param Uuid | string $newProfileId new value of the profile id
	 *@throws \RangeException if $newProfileId is not positive
	 *@throws \TypeError if $newProfileId violates type hints
	 */
	public function setProfileId(uuid $newProfileId) : void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newProfileId);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

		}
		// store the uuid
		$this->profileId = $uuid;
	}

	/**
	 * accessor method for profile activation token
	 *
	 * @return string of profile activation token
	 */
	public function getProfileActivationToken(): string {
		return $this->profileActivationToken;
	}
	/**
	 * mutator method for profile activation token
	 *
	 * @param string $newProfileActivationToken new value of the profile activation hash
	 * @throws \InvalidArgumentException if $newProfileActivationToken is not a valid data type
	 * @throws \RangeException if $newProfileActivationToken is longer than 32 characters
	 */
	public function setProfileActivationToken(string $newProfileActivationToken): void {
		// verify the string is 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw (new \RangeException("string is not 32 characters"));
		}
		// verify the string is hexadecimal
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw (new \InvalidArgumentException("String is not hexadecimal"));
		}
		// sanitize activation token string
		$newProfileActivationToken = filter_var($newProfileActivationToken, FILTER_SANITIZE_STRING);
		// store the string
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return	string of the profile email
	 */
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}
	/**
	 * mutator method for profile email
	 *
	 * @param string $newProfileEmail new value of the profile email
	 * @throws \InvalidArgumentException if $newProfileEmail is empty
	 * @throws \RangeException if profile email is longer than 128 characters
	 * @throws \Exception if profile email is not well-formed
	 */
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the profile email is not empty
		if(empty($newProfileEmail) === true) {
			throw (new \InvalidArgumentException("email field is empty"));
		}
		// verify email address is not too long
		if(strlen($newProfileEmail) > 128) {
			throw (new \RangeException("email address is too long"));
		}
		// sanitize email string
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING);
		// sanitize email
		$newProfileEmail = filter_var($newProfileEmail,FILTER_SANITIZE_EMAIL);
		// verify if email is well formed
		if(filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL) === false) {
			throw (new \Exception("email in not valid format"));
		}
		// store the string
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string of profile hash
	 */
	public function getProfileHash(): string {
		return $this->profileHash;
	}
	/**
	 * mutator method for profile hash
	 *
	 * @param string $newProfileHash new value of the profile hash
	 * @throws \InvalidArgumentException if $newProfileHash is empty
	 * @throws \RangeException if profile hash is longer than 97 characters
	 * @throws \Exception if profile hash is not hexadecimal
	 */
	public function setProfileHash(string $newProfileHash): void {
		// verify if the profile hash is not empty
		if(empty($newProfileHash) === true) {
			throw (new \InvalidArgumentException("profile hash is empty"));
		}
		// verify the hash is not too long
		if(strlen($newProfileHash) > 97) {
			throw (new \RangeException("hash is too long"));
		}
		// verify that hash is hexadecimal
		if(ctype_xdigit($newProfileHash) === false) {
			throw (new \Exception("hash is not hexadecimal"));
		}
		// store the string
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for the boolean profile is owner
	 *
	 * @return string of profile is owner
	 */
	/**
	 * @return int of profile is owner boolean
	 */
	public function getProfileIsOwner(): int {
		return $this->profileIsOwner;
	}
	/**
	 * mutator method for the boolean profile is owner
	 *
	 * @param integer $newProfileIsOwner new value of the boolean profile is owner
	 * @throws \InvalidArgumentException if $newProfileIsOwner is empty
	 * @throws \RangeException if integer is longer than 1 character
	 * @throws \Exception if integer is not 1 or 0
	 */
	public function setProfileIsOwner(int $newProfileIsOwner): void {
		// check integer is not empty
		if(empty($newProfileIsOwner) === true) {
			throw (new	\InvalidArgumentException("profile is owner is empty"));
		}
		// check profile is owner
		if(is_int($newProfileIsOwner) === false) {
			throw (new \InvalidArgumentException("profile is owner is not integer"));
		}
		// check profile is owner is to long
		if(strlen((int)$newProfileIsOwner) !== 1) {
			throw (new \RangeException("integer is too long"));
		}
		// check profile is owner is either 1 or 0
		if($newProfileIsOwner !== 0 or $newProfileIsOwner !== 1) {
			throw (new \Exception("boolean is not 1 or 0"));
		}
		// store the integer
		$this->profileIsOwner = $newProfileIsOwner;
	}

	/**
	 *accessor method for profile name
	 *
	 * @return string of profile name
	 */
	public function getProfileName(): string {
		return $this->profileName;
	}
	/**
	 * mutator method for the profile name
	 *
	 * @param string $newProfileName new profile name
	 * @throws \InvalidArgumentException if $newProfile is empty
	 * @throws \RangeException if string is too long
	 */
	public function setProfileName(string $newProfileName): void {
		// check if string is empty
		if(empty($newProfileName) === false) {
			throw (new \InvalidArgumentException("profile name is empty"));
		}
		// check if string is too long
		if(strlen($newProfileName) > 32) {
			throw (new \RangeException("profile is too long"));
		}
		// sanitize string
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING);
		// store the string
		$this->profileName = $newProfileName;
	}


	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError id $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileName) VALUES (:profileId, :profileActivationToken, :profileEmail, :profileHash, :profileIsOwner, :profileName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileHash, "profileHash" => $this->profileHash, "profileIsOwner" => $this->profileIsOwner, "profileName" => $this->profileName];
	}

}