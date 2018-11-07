<?php

namespace Cnm\FoodTruckFinder;
require_once "autoload.php";
require_once (dirname(__DIR__, 2)) . "vendor/autoload.php";

use Ramsey\Uuid\Uuid;

class Favorite implements \JsonSerializable {

	use ValidateUuid;
	use ValidateDate;

	/**
	 * id for favoriteProfile; this is a foreign key
	 * @var Uuid $favoriteProfileId
	 */
	private $favoriteProfileId;
	/**
	 * id for favoriteTruck; this is a foreign key
	 * @var Uuid $favoriteTruckId
	 */
	private $favoriteFoodTruckId;
	/**
	 * stores the datetime for when a food truck is  added as a favorite
	 */
	private $favoriteAddDate;

	/** constructor for this favorite
	 *
	 * @param Uuid | string $newFavoriteProfileId is uuid for profile that favorited the foodtruck
	 * @param Uuid | string $newFavoriteFoodTruckId is uuid for the favorited truck
	 * @param DateTime | $newFavoriteAddDate datetime value
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct($newFavoriteProfileId, $newFavoriteTruckId, $newFavoriteAddDate) {
		try {
			$this->setFavoriteProfileId($newFavoriteProfileId);
			$this->setFavoriteFoodTruckId($newFavoriteTruckId);
			$this->setFavoriteAddDate($newFavoriteAddDate);
		} catch(\InvalidArgumentException | RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/** accessor method for favorite profile id
	 *
	 * @return Uuid value of the favorite profile id
	 */
	public function getFavoriteProfileId(): Uuid {
		return $this->favoriteProfileId;
	}

	/** mutator method for favorite profile id
	 *
	 * @param Uuid | string $newFavoriteProfileId new value of the favorite profile id
	 * @throws \InvalidArgumentException if $newFavoriteProfileId is not a valid uuid
	 * @throws RangeException if $newFavoriteProfileId is not positive
	 */
	public function setFavoriteProfileId(uuid $newFavoriteProfileId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid(newFavoriteProfileId);
		} catch(\InvalidArgumentException | RangeException | \Exception | \TypeError $exception) {

		}
		// store the uuid
		$this->favoriteProfileId = $uuid;
	}

	/** accessor method for favorite food truck id
	 *
	 * @return Uuid value of the favorite food truck id
	 */
	public function getFavoriteFoodTruckId(): uuid {
		return $this->favoriteFoodTruckId;
	}

	/**
	 * mutator method for favorite food truck id
	 *
	 * @param Uuid | string $newFavoriteFoodTruckId new value of the favorited food truck id
	 * @throws \InvalidArgumentException if $newFavoriteFoodTruckId is not a valid uuid
	 * @throws RangeException if $newFavoriteFoodTruckId is not positive
	 */
	public function setFavoriteFoodTruckId(uuid $newFavoriteFoodTruckId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newFavoriteFoodTruckId);
		} catch(\InvalidArgumentException | RangeException | \Exception | \TypeError $exception) {

		}
		//store the uuid
		$this->favoriteFoodTruckId = $uuid;
	}

	/**
	 * accessor method for favorite add date
	 *
	 * @return \DateTime DateTime value of the favorite food truck add
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws RangeException if the date is not a Gregorian date
	 */
	public function getFavoriteAddDate(): \DateTime {
		return ($this->FavoriteAddDate);
	}

	/**
	 * mutator method for favorite add date
	 *
	 * @param \DateTime | string $newFavoriteAddDate date to validate
	 * @throws \InvalidArgumentException if the date is in an invalid format
	 * @throws RangeException if the date is not a Gregorian date
	 * @throws \Exception if some other error occurs
	 */
	public function setFavoriteAddDate($newFavoriteAddDate = null): void {
		//base case if the date is null use the current date time
		if($newFavoriteAddDate === null) {
			$this->favoriteAddDate = new \DateTime();
			return;
		}
		// store the favorite add date using the ValidateDate Trait
		try {
			$newFavoriteAddDate = self::validateDateTime($newFavoriteAddDate);
		} catch(\InvalidArgumentException | RangeException $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->favoriteAddDate = $newFavoriteAddDate;
	}

	/**
	 * inserts this Favorite Profile Id into mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a pdo connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO favorite (favoriteProfileId, favoriteFoodTruckId, favoriteAddDate) VALUES (:favoriteProfileId, :favoriteFoodTruckId, :favoriteAddDate)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteProfileId->format("Y-m-d H:i:s.u");
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId->getBytes(), "favoriteFoodTruckId" => $this->favoriteFoodTruckIdId->getBytes(), "favoriteAddDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 *
	 */
		/**
		 * Specify data which should be serialized to JSON
		 * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
		 * @return mixed data which can be serialized by <b>json_encode</b>,
		 * which is a value of any type other than a resource.
		 * @since 5.4.0
		 */
		public function jsonSerialize() {
			// TODO: Implement jsonSerialize() method.
	}
}