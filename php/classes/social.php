<?php

namespace Edu/Cnm/FoodTruckFinder;
require_once ("Autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class  social {
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

	public function__construct($newSocialId, $newSocialFoodTruckId, string $newSocialUrl){
		try{

	/**
 * @param mixed $newSocialId
 */
	public function setSocialId($newSocialId): void {
		$this->socialId = $newSocialId;
	}

}
}

}

