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
}