<?php

namespace Edu\Cnm\FoodTruckFinder\ValidateUuid;


use Edu\Cnm\FoodTruckFinder\ValidateUuid;

Cnm/FoodTruckFinder;
require_once ("Autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Social implements \JsonSerializable {
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


	/** constructor for this social
	 *
	 * @param string|Uuid $newSocialId id of this social or null if  a social
	 * @param string|Uuid $newSocialFoodTruckId id of the Profile that sent this social
	 * @param string $newSocialUrl string containing actual Url data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */

	public function __construct($newSocialId, $newSocialFoodTruckId, string $newSocialUrl) {

		try {
			$this->setSocialId($newSocialId);
			$this->setSocialFoodTruckId($newSocialFoodTruckId);
			$this->setSocialUrl($newSocialUrl);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for social  id
	 *
	 * @return Uuid value of the social id
	 */

	public function getSocialId(): Uuid {
		return $this->socialId;
	}

	/**
	 * mutator method for profile id
	 *
	 * @param Uuid | string $newSocialId new value of the social id
	 * @throws \RangeException if $newSocialId is not positive
	 * @throws \TypeError if $newSocialId violates type hints
	 */

	public function setSocialId($newSocialId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newSocialId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the uuid
		$this->socialId = $uuid;
		{
		}
		/**
		 * accessor method for socialFoodTruckId
		 * @return Uuid value of the social foodtruck id
		 */


	}

	public function getSocialFoodTruckId(): Uuid {
		return ($this->socialFoodTruckId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param Uuid | string $newSocialFoodTruckId new value of the location id
	 * @throws \RangeException if $newSocialId is not positive
	 * @throws \TypeError if $newSocialFoodTruckId violates type hints
	 */

	public function setSocialFoodTruckId(Uuid $newSocialFoodTruckId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newSocialFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the uuid
		$this->socialFoodTruckId = $uuid;
	}

	/**
	 *accessor method for Social Url
	 *
	 * @return string of social Url
	 */

	public function getSocialUrl(): string {
		return ($this->socialUrl);
	}

	/**
	 * mutator method for social Url
	 *
	 * @param string $newSocialUrl new value of the social url
	 * @throws \InvalidArgumentException if $newSocialUrl is not a valid data type
	 * @throws \RangeException if $newSocialUrl is longer than  characters
	 */

	public function setSocialUrl(string $newSocialUrl): void {
		// verify the string is 500 characters
		$newSocialUrl = trim($newSocialUrl);
		$newSocialUrl = filter_var($newSocialUrl, FILTER_VALIDATE_URL);
		if(empty($newSocialUrl) === true) {
			throw(new \InvalidArgumentException("Social Url link is empty or insecure."));
		}

		// verify the string is validated
		if(strlen($newSocialUrl) > 500) {
			throw(new \RangeException("Social Url is too large, limit 500 characters"));
		}
// store the social url link
		$this->socialUrl = $newSocialUrl;
	}








//PDO Statements begin


//SELECT statement
	/**
	 * gets the social by SocialId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $socialId social id to search for
	 * @return Social|null Product found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getSocialBySocialId(\PDO $pdo, $socialId) : ?Product {
		// sanitize the social Id before searching
		try {
			$socialId = self::validateUuid($socialId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT socialId, socialFoodTruckId, socialUrl, FROM social WHERE socialId = :socialId";
		$statement = $pdo->prepare($query);

		// bind the social id to the place holder in the template
		$parameters = ["socialId" => $socialId->getBytes()];
		$statement->execute($parameters);


		// grab the social from mySQL
		try {
			$social = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$social = new  Social($row["socialId"], $row["socialFoodTruckId"], $row["socialUrl"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($social);
	}







	/**
	 * inserts this social Url into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
			// create query template
			$query = "INSERT INTO (socialId, socialFoodTruckId, socialUrl,)";
			$statement = $pdo->prepare($query);

			// bind the member variables to the place holders in the template
			$parameters = ["socialId" => $this->socialId->getBytes(), "socialFoodTruckId" => $this->socialFoodTruckId->getBytes(), "socialUrl" => $this->socialUrl];
			$statement->execute($parameters);
		}


	/**
	 * updates this Product in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {

			// create query template
			$query = "UPDATE social SET  socialFoodTruckId = :socialFoodTruckId, socialUrl = :socialUrl WHERE socialId = :socialId ";
			$statement = $pdo->prepare($query);


			$parameters = ["socialId" => $this->socialId->getBytes(), "socialFoodTruckId" => $this->socialFoodTruckId->getBytes(), "socialUrl"
			=> $this->socialUrl];
			$statement->execute($parameters);
		}



	/**
	 * deletes this social from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM social WHERE socialId = :socialId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["socialId" => $this->socialId->getBytes()];
		$statement->execute($parameters);

		}

	}

