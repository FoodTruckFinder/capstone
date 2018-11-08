<?php

namespace Cnm\FoodTruckFinder;
require_once "autoload.php";
require_once (dirname(__DIR__, 2)) . "vendor/autoload.php";

use Ramsey\Uuid\Uuid;

class Favorite implements \JsonSerializable {

	use ValidateUuid;
	use ValidateDate;

	/**
	 * id for the Profile that favorited the food truck; this is a foreign key
	 * @var Uuid $favoriteProfileId
	 */
	private $favoriteProfileId;
	/**
	 * id for the food truck that was favorited; this is a foreign key
	 * @var Uuid $favoriteTruckId
	 */
	private $favoriteFoodTruckId;
	/**
	 * date and time for when a food truck is added as a favorite
	 * @var \DateTime
	 */
	private $favoriteAddDate;

	/** constructor for this favorite
	 *
	 * @param Uuid | string $newFavoriteProfileId is uuid for profile that favorited the foodtruck
	 * @param Uuid | string $newFavoriteFoodTruckId is uuid for the favorited truck
	 * @param \DateTime | string $newFavoriteAddDate datetime value
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct($newFavoriteProfileId, $newFavoriteFoodTruckId, $newFavoriteAddDate) {
		try {
			$this->setFavoriteProfileId($newFavoriteProfileId);
			$this->setFavoriteFoodTruckId($newFavoriteFoodTruckId);
			$this->setFavoriteAddDate($newFavoriteAddDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
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
			$uuid = self::validateUuid($newFavoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

		}
		// store the uuid
		$this->favoriteProfileId = $uuid;
	}

	/** accessor method for favorite food truck id
	 *
	 * @return Uuid value of the favorite food truck id
	 */
	public function getFavoriteFoodTruckId(): Uuid {
		return $this->favoriteFoodTruckId;
	}

	/**
	 * mutator method for favorite food truck id
	 *
	 * @param Uuid | string $newFavoriteFoodTruckId new value of the favorited food truck id
	 * @throws \InvalidArgumentException if $newFavoriteFoodTruckId is not a valid uuid
	 * @throws RangeException if $newFavoriteFoodTruckId is not positive
	 */
	public function setFavoriteFoodTruckId(Uuid $newFavoriteFoodTruckId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newFavoriteFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

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
		return ($this->favoriteAddDate);
	}

	/**
	 * mutator method for favorite add date
	 *
	 * @param \DateTime | string | null $newFavoriteAddDate date as a Datetime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newFavoriteAddDate is not a valid object or string
	 * @throws \RangeException if $newFavoriteAddDate is not a valid object or string
	 */
	public function setFavoriteAddDate($newFavoriteAddDate = null): void {
		//base case if the date is null, use the current date time
		if($newFavoriteAddDate === null) {
			$this->favoriteAddDate = new \DateTime();
			return;
		}
		// store the favorite add date using the ValidateDate Trait
		try {
			$newFavoriteAddDate = self::validateDateTime($newFavoriteAddDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
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
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId->getBytes(), "favoriteFoodTruckId" => $this->favoriteFoodTruckId->getBytes(), "favoriteAddDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this favoriteProfileId from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE from favorite WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the favorite by favoriteProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid | string $favoriteProfileId favorite profile id to search by
	 * @return SplFixedArray SplFixedArrays of favorites found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getFavoritebyFavoriteProfileId(\PDO $pdo, $favoriteProfileId): \SplFixedArray {
		// sanitize favoriteProfileId before searching
		try {
			$favoriteProfileId = self::validateUuid($favoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new\PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteFoodTruckProfileId, favoriteAddDate FROM favorite WHERE favoriteProfileId = favoriteProfileId";
		$statement = $pdo->prepare($query);
		// Bind the favorite profile id to the place holder in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of favorites by profile id
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteFoodTruckProfileId"], ["favoriteAddDate"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
		return($favorites);
	}

	/** gets all favorites
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Favorites
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