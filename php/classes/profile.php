<?php

class profile implements \JsonSerializable {

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
	 * @param string|Uuid $newProfileId id of this profile or null if new profile
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

	public function construct($newProfileId, $newProfileActivationToken, $newProfileEmail, $newProfileHash, $newProfileIsOwner, $newProfileName) {
		try {
			$this->setProfileId($newProfileId);
		}
	}
}