<?php

namespace FoodTruckFinder\Capstone;



require_once "autoload.php";
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Location implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for this location this is a primary key
	 * @var Uuid $locationId
	 */
	//declare properties
	private $locationId;

	/**
	 * id for this foodTruck this is a foreign key from the foodTruck table
	 * @var Uuid $locationFoodTruckId
	 */
	private $locationFoodTruckId;
	/**
	 * the location end time for when a foodTruck completes service
	 * @var \DateTime $locationEnd
	 */
	private $locationEndTime;
	/**
	 * stores the latitude coordinate associated with locationFoodTruckId
	 * @var float which stores lat coordinates
	 */
	private $locationLatitude;
	/**
	 * stores the longitude coordinate associated with locationFoodTruckId
	 * @var float which stores long coordinates
	 **/
	private $locationLongitude;
	/**
	 * the location start time for when a foodtruck begins service
	 * @var \DateTime $locationStart
	 */
	private $locationStartTime;

	/**
	 * constructor for this location
	 *
	 * @param Uuid | $newLocationId id of this location
	 * @param Uuid | $newLocationFoodTruckId id of foodtruck at this location
	 * @param /DATETIME |null|string $newLocationEndTime datetime value
	 * @param float $newLocationLatitude latitude coordinate of this location
	 * @param float $newLocationLongitude longitude coordinate of this location
	 * @param /DATETIME $newLocationStartTime datetime value
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., string is too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */

	public function __construct($newLocationId, $newLocationFoodTruckId, $newLocationEndTime = null, float $newLocationLatitude, float $newLocationLongitude, $newLocationStartTime) {
		try {
			$this->setLocationId($newLocationId);
			$this->setLocationFoodTruckId($newLocationFoodTruckId);
			$this->setLocationEndTime($newLocationEndTime);
			$this->setLocationLatitude($newLocationLatitude);
			$this->setLocationLongitude($newLocationLongitude);
			$this->setLocationStartTime($newLocationStartTime);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new   $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for location id
	 *
	 * @return Uuid value of the Location
	 */
	public function getLocationId(): Uuid {
		return $this->locationId;
	}

	/**
	 * mutator method for location id
	 *
	 * @param Uuid |  $newLocationId new value of the location id
	 * @throws \RangeException if $newLocationId is not positive
	 * @throws \TypeError if $newLocationId violates type hints
	 */
	public function setLocationId($newLocationId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newLocationId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the uuid
		$this->locationId = $uuid;
	}

	/**
	 * accessor method for locationFoodTruckId
	 *
	 * @return Uuid value of the location foodtruck id
	 */
	public function getLocationFoodTruckId(): Uuid {
		return $this->locationFoodTruckId;
	}

	/**
	 * mutator method for profile id
	 *
	 * @param Uuid | $newLocationFoodTruckId new value of the location id
	 * @throws \RangeException if $newLocationId is not positive
	 * @throws \TypeError if $newLocationId violates type hints
	 */
	public function setLocationFoodTruckId($newLocationFoodTruckId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newLocationFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the uuid
		$this->locationFoodTruckId = $uuid;
	}

	/**
	 * accessor method for locationEndTime
	 *
	 * returns locationEndTime
	 */
	public function getLocationEndTime(): ?\DateTime {
		return ($this->locationEndTime);

	}

	/**
	 * mutator method for locationEndTime
	 * @param null $newLocationEndTime
	 * checks if location end time is empty, if it is the default end time is 4 hours from the start time.
	 *  @try runs locationEndtime through validateDateTime
	 * @throws \Exception \InvalidArgumentException or \RangeException if not a valid date.
	 */

	public function setLocationEndTime( $newLocationEndTime): void {
		if($newLocationEndTime === null) {
			$date = new \DateTime();
			$date->add(new \DateInterval('PT4H'));
			$this->locationEndTime = $date;
			return;
		//	throw(new \TypeError("Date is empty."));
		}
		try {
			$newLocationEndTime = self::validateDateTime($newLocationEndTime);
		} catch(\InvalidArgumentException | \RangeException | \TypeError |\Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//store the new Event End Time
		$this->locationEndTime = $newLocationEndTime;
	}


	/**
	 * accessor method for locationStartTime
	 *
	 * @return \DateTime of the location end time
	 */
	public function getLocationStartTime(): \DateTime {
		return ($this->locationStartTime);

	}

	/**
	 * mutator method for $newLocationStartTime
	 *
	 * @param null $newLocationStartTime
	 * @try runs locationStartTime through validateDateTime
	 * @throws \Exception  if not a valid date/time
	 *
	 *
	 */
	public function setLocationStartTime($newLocationStartTime = null): void {
		//base case if the date is null use the current date and time
		if($newLocationStartTime === null) {
			$this->locationStartTime = new \DateTime();
			return;
		}
		//store the start time using the ValidateDate Trait
		try {
			$newLocationStartTime = self::validateDateTime($newLocationStartTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the datetime value
		$this->locationStartTime = $newLocationStartTime;
	}


	/**
	 * accessor method for locationLatitude
	 *
	 * @return float lat coordinates of FoodTrucks Location
	 */
	public function getLocationLatitude(): float {
		return ($this->locationLatitude);
	}

	/** mutator method for locationLatitude
	 *
	 * @param float $newLocationLatitude new value of location latitude
	 * @throws \InvalidArgumentException if $newLocationLatitude is not a float or insecure
	 * @throws \RangeException if $newLocationLatitude is not within -90 to 90
	 * @throws \TypeError if $newLocationLatitude is not a float
	 **/
	public function setLocationLatitude(float $newLocationLatitude): void {
		// verify the latitude exists on earth
		if($newLocationLatitude > 90) {
			throw(new \RangeException("Location latitude is not between -90 and 90"));
		}
		if($newLocationLatitude < -90) {
			throw(new \RangeException("location latitude is not between -90 and 90"));
		}
		// store the latitude
		$this->locationLatitude = $newLocationLatitude;
	}


	/**
	 * accessor method for locationLongitude
	 *
	 * @return float long coords of FoodTrucks Location
	 */
	public function getLocationLongitude(): float {
		return ($this->locationLongitude);
	}

	/** mutator method for locationLongitude
	 *
	 * @param float $newLocationLongitude new value of location latitude
	 * @throws \InvalidArgumentException if $newLocationLatitude is not a float or insecure
	 * @throws \RangeException if $newLocationLatitude is not within -90 to 90
	 * @throws \TypeError if $newLocationLatitude is not a float
	 **/

	public function setLocationLongitude(float $newLocationLongitude): void {
		// verify the latitude exists on earth
		if ($newLocationLongitude > 180) {
			throw(new \RangeException("location longitude is not between -180 and 180"));
		}
		if($newLocationLongitude < -180) {
			throw(new \RangeException("location longitude is not between -180 and 180"));
		}
		// store the latitude
		$this->locationLongitude = $newLocationLongitude;
	}

	/**
	 * inserts this Location into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO location(locationId, locationFoodTruckId, locationEndTime, locationLatitude, locationLongitude, locationStartTime) VALUES(:locationId, :locationFoodTruckId, :locationEndTime, :locationLatitude, :locationLongitude, :locationStartTime)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedStartTime = $this->locationStartTime->format("Y-m-d H:i:s.u");
		$formattedEndTime = $this->locationEndTime -> format("Y-m-d H:i:s.u");
		$parameters = ["locationId" => $this->locationId->getBytes(), "locationFoodTruckId" => $this->locationFoodTruckId->getBytes(), "locationEndTime" => $formattedEndTime, "locationLatitude" => $this->locationLatitude, "locationLongitude" => $this->locationLongitude, "locationStartTime" => $formattedStartTime];
		$statement->execute($parameters);
	}
	/**
	 * deletes this Location from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM location WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["locationId" => $this->locationId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this Location in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE location SET locationFoodTruckId = :locationFoodTruckId, locationEndTime = :locationEndTime, locationLatitude = :locationLatitude, locationLongitude = :locationLongitude, locationStartTime = :locationStartTime, WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);


		$formattedStartTime = $this->locationStartTime->format("Y-m-d H:i:s.u");
		$formattedEndTime = $this->locationEndTime -> format("Y-m-d H:i:s.u");
		$parameters = ["locationId" => $this->locationId->getBytes(),"locationFoodTruckId" => $this->locationFoodTruckId->getBytes(), "locationEndTime" => $formattedEndTime, "locationLatitude" => $this->locationLatitude, "locationLongitude" => $this->locationLongitude, "locationStartTime" => $formattedStartTime];
		$statement->execute($parameters);
	}

	/**
	 * @param \PDO $pdo PDO connection object
	 * @param $locationFoodTruckId Uuid of FoodTruck to search by
	 * @return Location| null returns
	 */

	public static function getLocationByLocationFoodTruckId(\PDO $pdo, $locationFoodTruckId) : ?Location {
		// sanitize the locationFoodTruckId before searching
		try {
			$locationFoodTruckId = self::validateUuid($locationFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT locationId, locationFoodTruckId, locationEndTime, locationLatitude, locationLongitude, locationStartTime FROM location WHERE locationFoodTruckId = :locationFoodTruckId";
		$statement = $pdo->prepare($query);

		// bind the locationFoodTruckId to the place holder in the template
		$parameters = ["locationFoodTruckId" => $locationFoodTruckId->getBytes()];
		$statement->execute($parameters);

		// grab the location from mySQL
		try {
			$location = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$location = new Location($row["locationId"], $row["locationFoodTruckId"], $row["locationEndTime"], $row["locationLatitude"], $row["locationLongitude"], $row["locationStartTime"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($location);
	}

	/**
	 * gets the Location by Location Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid| location Id to search by
	 * @return location Object found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/


	public static function getLocationByLocationId(\PDO $pdo, $locationId) : ?Location {
		// sanitize the locationId before searching
		try {
			$locationId = self::validateUuid($locationId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT locationId, locationFoodTruckId, locationEndTime, locationLatitude, locationLongitude, locationStartTime FROM location WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);

		// bind the location id to the place holder in the template
		$parameters = ["locationId" => $locationId->getBytes()];
		$statement->execute($parameters);

		// grab the location from mySQL
		try {
			$location = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$location = new Location($row["locationId"], $row["locationFoodTruckId"], $row["locationEndTime"], $row["locationLatitude"], $row["locationLongitude"], $row["locationStartTime"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($location);
	}

	/**
	 * gets the Location Id by Location Food Truck Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid| $locationFoodTruckId to search by
	 * @return \SplFixedArray SplFixedArray of Locations found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getLocationIdByLocationFoodTruckId(\PDO $pdo, $locationFoodTruckId): \SplFixedArray {
		try {
			$locationFoodTruckId = self::validateUuid($locationFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template

		$query = "SELECT locationId, locationFoodTruckId, locationEndTime, locationLatitude, locationLongitude, locationStartTime FROM location WHERE locationFoodTruckId = :locationFoodTruckId";
		$statement = $pdo->prepare($query);
		// bind the location FoodTruck id to the place holder in the template
		$parameters = ["locationFoodTruckId" => $locationFoodTruckId->getBytes()];
		$statement->execute($parameters);
		// build an array of locations
		$locations = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$location = new Location($row["locationId"], $row["locationFoodTruckId"], $row["locationEndTime"], $row["locationLatitude"], $row["locationLongitude"], $row["locationStartTime"]);
				$locations[$locations->key()] = $location;
				$locations->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($locations);
	}


	/**
	 * gets the Location Food Truck Id by Location Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid| $locationId to search by
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @return Location | null $foodTrucks with matching Location Id
	 **/



	public static function getLocationFoodTruckIdByLocationId(\PDO $pdo, $locationId): ?Location {
		try {
			$locationId = self::validateUuid($locationId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template

		$query = "SELECT locationId, locationFoodTruckId, locationEndTime, locationLatitude, locationLongitude, locationStartTime FROM location WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);
		// bind the location id to the place holder in the template
		$parameters = ["locationId" => $locationId->getBytes()];
		$statement->execute($parameters);
			try {
				$foodTruck = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$foodTruck = new Location($row["locationId"], $row["locationFoodTruckId"], $row["locationEndTime"], $row["locationLatitude"], $row["locationLongitude"], $row["locationStartTime"]);
				}
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

		return ($foodTruck);
	}




	/**
	 * gets all Locations
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Locations found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllLocations(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT locationId, locationFoodTruckId, locationEndTime, locationLatitude, locationLongitude, locationStartTime FROM location";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of locations
		$locations = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$location = new Location($row["locationId"], $row["locationFoodTruckId"], $row["locationEndTime"], $row["locationLatitude"], $row["locationLongitude"], $row["locationStartTime"]);
				$locations[$locations->key()] = $location;
				$locations->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($locations);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["locationId"] = $this->locationId->toString();
		$fields["locationFoodTruckId"] = $this->locationFoodTruckId->toString();
		$fields["locationLatitude"] = $this->locationLatitude;
		$fields["locationLongitude"] = $this->locationLongitude;
		//format the date so that the front end can consume it
		$fields["locationStartTime"] = round(floatval($this->locationStartTime->format("U.u")) * 1000);
		$fields["locationEndTime"] = round(floatval($this->locationEndTime->format("U.u")) * 1000);
		return ($fields);
	}

}

