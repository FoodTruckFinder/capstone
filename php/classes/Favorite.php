<?php

namespace FoodTruckFinder\Capstone;
require_once("autoload.php");
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");


use DateTime;
use Ramsey\Uuid\Uuid;

class Favorite implements \JsonSerializable {

	use ValidateUuid;
	use ValidateDate;

	/**
	 * id of the Profile that favorited; this is a component of a composite primary key (and a foreign key)
	 * @var Uuid $favoriteProfileId
	 */
	private $favoriteProfileId;
	/**
	 * id of the food truck that was favorited; this is a composite of a primary key (and a foreign key)
	 * @var Uuid $favoriteFoodTruckId
	 */
	private $favoriteFoodTruckId;
	/**
	 * date and time for when a food truck is added as a favorite
	 * @var DateTime
	 */
	private $favoriteDate;

	/** constructor for this favorite
	 *
	 * @param string | Uuid $newFavoriteProfileId id of the parent profile
	 * @param string | Uuid $newFavoriteFoodTruckId id of the parent FoodTruck
	 * @param \DateTime|null $newFavoriteDate date the foodTruck was liked (or null for current time)
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct($newFavoriteProfileId, $newFavoriteFoodTruckId, $newFavoriteDate = null) {
		try {
			$this->setFavoriteProfileId($newFavoriteProfileId);
			$this->setFavoriteFoodTruckId($newFavoriteFoodTruckId);
			$this->setFavoriteDate($newFavoriteDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			// determine what exception type was thrown
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
	 * @param string  $newFavoriteProfileId new value of the profile id
	 * @throws \RangeException if $newFavoriteProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setFavoriteProfileId($newFavoriteProfileId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newFavoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the uuid
		$this->favoriteProfileId = $uuid;
	}

	/** accessor method for food truck id
	 *
	 * @return uuid value of food truck id
	 */
	public function getFavoriteFoodTruckId(): Uuid {
		return $this->favoriteFoodTruckId;
	}

	/**
	 * mutator method for favorite food truck id
	 *
	 * @param string $newFavoriteFoodTruckId new value of the food truck id
	 * @throws \RangeException if $newFooFoodTruckId is not positive
	 * @throws \TypeError if $newFavoriteFoodTruckId is not an integer
	 */
	public function setFavoriteFoodTruckId($newFavoriteFoodTruckId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newFavoriteFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the uuid
		$this->favoriteFoodTruckId = $uuid;
	}

	/**
	 * accessor method for favorite date
	 *
	 * @return DateTime DateTime value of the favorite food truck
	 */
	public function getFavoriteDate(): DateTime {
		return ($this->favoriteDate);
	}

	/**
	 * mutator method for favorite date
	 *
	 * @param \DateTime|string|null $newFavoriteDate favorite date as a Datetime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newFavoriteDate is not a valid object or string
	 * @throws \RangeException if $newFavoriteDate is a date that does not exist
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function setFavoriteDate($newFavoriteDate): void {
		// base case if the date is null, use the current date time
		if($newFavoriteDate === null) {
			$this->favoriteDate = new \DateTime();
			return;
		}
		// store the favorite date using the ValidateDate Trait
		try {
			$newFavoriteDate = self::validateDateTime($newFavoriteDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->favoriteDate = $newFavoriteDate;
	}

	/**
	 * inserts this favorite into mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a pdo connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO 'favorite' (favoriteProfileId, favoriteFoodTruckId, favoriteDate) VALUES (:favoriteProfileId, :favoriteFoodTruckId, :favoriteDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteDate->format("Y-m-d H:i:s.u");
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId->getBytes(), "favoriteFoodTruckId" => $this->favoriteFoodTruckId->getBytes(), "favoriteDate" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * deletes this favorite from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM 'favorite' WHERE favoriteProfileId = :favoriteProfileId" AND "favoriteFoodTruckId = :favoriteFoodTruckId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the favorite by foodTruckId and ProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $favoriteProfileId profile id to search for
	 * @param string $favoriteFoodTruckId food truck id to search for
	 * @return Favorite|null Favorite found or null if not found
	 **/
	public static function getFavoriteByFavoriteFoodTruckIdAndFavoriteProfileId(\PDO $pdo, string $favoriteProfileId, string $favoriteFoodTruckId): ?Favorite {
		// sanitize favoriteProfileId before searching
		try {
			$favoriteProfileId = self::validateUuid($favoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		try {
			$favoriteFoodTruckId = self::validateUuid($favoriteFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteFoodTruckId, favoriteDate FROM 'favorite' WHERE favoriteProfileId = :favoriteProfileId AND favoriteFoodTruckId = :favoriteFoodTruckId";
		$statement = $pdo->prepare($query);
		// bind the favorite profile id to the place holder in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId->getBytes(), "favoriteFoodTruckId" => $favoriteFoodTruckId->getBytes()];
		$statement->execute($parameters);
		// grab the favorite from mySQL
		try {
			$favorite = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteFoodTruckId"], $row["favoriteDate"]);
			}
		} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
		return($favorite);
	}
	/** get favorite by favorite profile id
	 *
	 * @param \PDO $pdo connection object
	 * @param  string $favoriteProfileId profile id to search for
	 * @return \SplFixedArray SplFixedArray of favorites found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getFavoriteByFavoriteProfileId(\PDO $pdo, string $favoriteProfileId): \SplFixedArray {
		// sanitize favoriteFoodTruckId before searching
		try {
			$favoriteProfileId = self::validateUuid($favoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException |\Exception | \TypeError $exception) {
				throw(new\PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteFoodTruckId, favoriteDate FROM 'favorite' WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);
		// Bind the member variables to the place holder in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode( \PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteFoodTruckId"], ["favoriteDate"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($favorites);
	}
	/** gets the favorite by food truck id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $favoriteFoodTruckId food truck id to search for
	 * @return \SplFixedArray array of Favorites found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 *
	 **/
	public static function getFavoriteByFavoriteFoodTruckId(\PDO $pdo, string $favoriteFoodTruckId) : \SplFixedArray {
		try {
					$favoriteFoodTruckId = self::validateUuid($favoriteFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteFoodTruckId, favoriteDate FROM'favorite' WHERE favoriteFoodTruckId = :favoriteFoodTruckId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["favoriteFoodTruckId" => $favoriteFoodTruckId->getBytes()];
		$statement->execute($parameters);
		// build the array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false); {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteFoodTruckId"], $row["favoriteDate"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch (\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
}

	/**
	 * formats the state variable for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		unset($fields["profileActivationToken"]);
		unset($fields["profileHash"]);
		return($fields);
	}
}

