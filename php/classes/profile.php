<?php

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
		// store the id
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
		//verify the string is hexadecimal
		if(ctype_xdigit($newProfileActivationToken) !== true) {
			throw (new \InvalidArgumentException("String is not hexadecimal"));
		}
		//store the string
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
		// verify if email is well formed
		if(filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL) === false) {
			throw (new \Exception("email in not valid format"));
		}
		$this->profileEmail = $newProfileEmail;
	}

	/

}