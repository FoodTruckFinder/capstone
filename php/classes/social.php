<?php

namespace Edu/Cnm/FoodTruckFinder;
require_once ("Autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");



class  social implements \ JsonSerializable {
	use ValidateUrl;
	use ValidateUuid;


	private $socialId;

	/**
	 * id for this social; this is the primary key
	 * @var Uuid $socialId
	 **/

	private $socialFoodTruckId;
	/**
	 * id of the social that sent this social; this is a foreign key
	 * @var Uuid $socialFoodTruckId
	 *
	 **/

	private $socialUrl;
	/**
	 * This is a string and will be a string
	 *
	 **/


	/* constructor for this social
 *
 * @param string|Uuid $socialId id of this social or null if  a social
 * @param string|Uuid $socialFoodTruckId id of the Profile that sent this social
 * @param string socialUrl string containing actual Url data
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 * @Documentation https://php.net/manual/en/language.oop5.decon.php
 */

public function__construct($newSocialId, $newSocialFoodTruckId, string $newSocialUrl)
try {
$this->setSocialId($newSocialId)
$this->setSocialFoodTruckId($newSocialFoodTruckId)
$this->setSocialUrl($newSocialUrl)
}

catch
(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw (new   $exceptionType($exception->getMessage(), 0, $exception));
	}

	/**
	 * accessor method for social  id
	 *
	 * @return Uuid value of the social id
	 */

	public function getSocialId(): Uuid {
	return $this->SocialId;
}

/**
 * mutator method for profile id
 *
 * @param Uuid | string $newSocialId new value of the social id
 * @throws \RangeException if $newSocialId is not positive
 * @throws \TypeError if $newSocialId violates type hints
 */


/**
 * @param mixed $newSocialId
 */
	 public function setSocialId($newSocialId): void {
	// verify the id is a valid uuid
	try {
		$uuid = self::validateUuid($newSocialId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

	}
	// store the uuid
	$this->SocialId = $uuid;
	{
	}
	/**
	 * accessor method for socialFoodTruckId
	 * @return Uuid value of the social foodtruck id
	 */


}
	public function setSocialFoodTruckId(): Uuid {
	return $this->SocialFoodTruckId;


	/**
	 * mutator method for profile id
	 *
	 * @param Uuid | string $newSocialId new value of the location id
	 * @throws \RangeException if $newSocialId is not positive
	 * @throws \TypeError if $newsocialId violates type hints
	 */

	public
	function getSocialFoodTruckId(uuid $newSocialFoodTruckId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newSocialFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

		}
		// store the uuid
		$this->socialFoodTruckId = $uuid;
	}
	/**
	 *accessor method for Social Url
	 *
	 * @return string of social Url
	 */
}

	public function setSocialUrl(): string {
	return $this->socialUrl;
}

/**
 * mutator method for social Url
 *
 * @param string $newSocialUrl new value of the profile activation hash
 * @throws \InvalidArgumentException if $newSocialUrl is not a valid data type
 * @throws \RangeException if $newSocialUrl is longer than 32 characters
 */

public function getSocialUrl(string $newSocialUrl): void {
	// verify the string is 32 characters
	if(strlen($newSocialUrl) !== 32) {
		throw (new \RangeException("string is not 32 characters"));
	}

	// verify the string is hexadecimal
	if(ctype_xdigit($newSocialUrl) === false) {
		throw (new \InvalidArgumentException("String is not hexadecimal"));
	}
	// sanitize activation token string
	$newSocialUrl = filter_var($newSocialUrl, FILTER_SANITIZE_STRING);
	// store the string
	$this->socialUrl = $newSocialUrl;
}
	}