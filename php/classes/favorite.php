<?php

namespace Edu/Cnm/$foodFinderFinder;

require_once "autoload.php";
require_once (dirname(__DIR__, 2)) . "vendor/autoload.php";

class Favorite implements \JsonSerializable {

		use ValidateUuid;

		/**
		 * id for favoriteUser; this is a foreign key
		 * @var Uuid $favoriteUserId
		 */
		private $favoriteUserId;
		/**
		 * id for favoriteTruck; this is a foreign key
		 * @var Uuid $favoriteTruckId
		 */
		private $favoriteTruckId;
		/**
		 *
		 */
}