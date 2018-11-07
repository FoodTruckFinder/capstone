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
}