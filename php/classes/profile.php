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
	 * @return Uuid value of the profile
	 */
	/**
	 * @return Uuid
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
	/**
	 * @param Uuid $profileId
	 */
	public function setProfileId($newProfileId) : void {
		try {
			$uuid = self::validateUuid($newProfileId);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

		}
		$this->profileId = $uuid;
	}

	/**
	 * accessor method for profile activation token
	 *
	 * @param string $newProfileActivationToken new value of the profile activation hash
	 * @throws \InvalidArgumentException if $newProfileActivationToken is not a valid data type
	 * @throws \RangeException if $newProfileActivationToken is too long
	 * @throws \TypeError if data types violate type hints
	 */
	/**
	 * @return string
	 */
	public function getProfileHash() : string {
		return $this->profileHash;
	}
	/**
}