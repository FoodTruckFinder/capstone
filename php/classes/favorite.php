<?php

namespace Edu/

use http\Exception\InvalidArgumentException;

Cnm/$foodFinderFinder;

require_once "autoload.php";
require_once (dirname(__DIR__, 2)) . "vendor/autoload.php";

class Favorite implements \JsonSerializable {

		use ValidateUuid;

		/**
		 * id for favoriteProfile; this is a foreign key
		 * @var Uuid $favoriteProfileId
		 */
		private $favoriteUserId;
		/**
		 * id for favoriteTruck; this is a foreign key
		 * @var Uuid $favoriteTruckId
		 */
		private $favoriteTruckId;
		/**
		 * stores the datetime for when a foodtruck is  added as a favorite
		 */
		private $favoriteAddDate;

		/** constructor for this favorite
		 *
		 * @param Uuid | string $newFavoriteProfileId is uuid for profile that favorited the foodtruck
		 * @param Uuid | string $newFavoriteTruckId is uuid for the favorited truck
		 * @param DateTime | $newFavoriteAddDate  datetime value
		 * @throws \InvalidArgumentException if the data types are not valid
		 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
		 * @throws \TypeError if data types violate type hints
		 * @throws \Exception if some other exception occurs
		 */
		public function __construct($newFavoriteProfileId, $newFavoriteTruckId, $newFavoriteAddDate) {
			try {
				$this->setFavoriteProfileId($newFavoriteProfileId);
				$this->setFavoriteTruckId($newFavoriteTruckId);
				$this->set
			}
		}
}