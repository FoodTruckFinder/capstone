<?php

class Location implements \JsonSerializable {

	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for this location this is a primary key
	 * @var Uuid $locationId
	 */

	private $locationId;

	/**
	 * id for this Foodtruck this is a foreign key from the foodTruck table
	 * @var Uuid $locationFoodTruckId
	 */
	private $locationFoodTruckId;
	/**
	 * the location end time for when a foodtruck completes service
	 * @var datetime datatype $locationEnd
	 */
	private $locationEndTime;
	/**
	 * stores the latitude coordinate associated with locationFoodTruckId
	 * @var float which stores lat coords
	 */
	private $locationLatitude;
	/*
	* stores the longitude coordinate associated with locationFoodTruckId
	* @var float which stores long coords
	*/
	private $locationLongitude;
	/**
	 * the location start time for when a foodtruck begins service
	 * @var datetime datatype $locationStart
	 */
	private $locationStartTime;

	/**
	 * constructor for this location
	 *
	 * @param Uuid | string $newLocationId id of this location
	 * @param Uuid | string $newLocationFoodTruckId id of foodtruck at this location
	 * @param DATETIME | $newLocationEndTime datetime value
	 * @param float $newLocationLatitude latitude coordinate of this location
	 * @param float $newLocationLongitude longitude coordinate of this location
	 * @param DATETIME $newLocationStartTime datetime value
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */

	public function __construct($newLocationId, $newLocationFoodTruckId, $newLocationEndTime, $newLocationLatitude, $newLocationLongitude, $newLocationStartTime) {
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
	 * @return Uuid value of the location id
	 */
	public function getLocationId(): Uuid {
		return $this->locationId;
	}

	/**
	 * mutator method for location id
	 *
	 * @param Uuid | string $newLocationId new value of the location id
	 * @throws \RangeException if $newLocationId is not positive
	 * @throws \TypeError if $newLocationId violates type hints
	 */
	public function setLocationId(uuid $newLocationId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newLocationId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

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
	 * @param Uuid | string $newLocationId new value of the location id
	 * @throws \RangeException if $newLocationId is not positive
	 * @throws \TypeError if $newLocationId violates type hints
	 */
	public function setLocationFoodTruckId(uuid $newLocationFoodTruckId): void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newLocationFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

		}
		// store the uuid
		$this->locationFoodTruckId = $uuid;
	}

	/**
	 * accessor method for locationEndTime
	 *
	 * @return DATETIME value of the location end time
	 */
	public function getLocationEndTime(): \DateTime {
		return ($this->locationEndTime);

	}

	/**
	 * mutator method for locationStartTime
	 *
	 *
	 *
	 *
	 */

	public function setLocationStartTime($newLocationStartTime = null) void {
///base case if the date is null use the current date and time
if($newLocationStartTime === null) {
    $this->setLocationStartTime = new \DateTime();
    return;
}

//store the start time using the ValidateDate Trait
try {
	$newLocationStartTime = self::validateDateTime($newLocationStartTime);
} catch(\InvalidArgumentException | \RangeException $exception) {
	$exceptionType = get_class($exception);
	throw (new $exceptionType($exception->getMessage(), 0, $exception));
}
$this->locationStartTime = $newLocationStartTime;
}


/**
 * accessor method for locationLatitude
 *
 * @return float lat coords of FoodTrucks Location
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
	if(floatval($newLocationLatitude) > 90) {
		throw(new \RangeException("Location latitude is not between -90 and 90"));
	}
	if(floatval($newLocationLatitude) < -90) {
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
 * @param float $newLocationLatitude new value of location latitude
 * @throws \InvalidArgumentException if $newLocationLatitude is not a float or insecure
 * @throws \RangeException if $newLocationLatitude is not within -90 to 90
 * @throws \TypeError if $newLocationLatitude is not a float
 **/

public
function setLocationLongitude(float $newLocationLongitude): void {
	// verify the latitude exists on earth
	if(floatval($newLocationLongitude) > 180) {
		throw(new \RangeException("location longitude is not between -180 and 180"));
	}
	if(floatval($newLocationLongitude) < -180) {
		throw(new \RangeException("location longitude is not between -180 and 180"));
	}
	// store the latitude
	$this->locationLongitude = $newLocationLongitude;
}


/**
 * mutator method for locationEndTime
 *
 *
 *NEEDS TO BE SOLVED
 *
 */
public
function setLocationEndTime($newLocationEndTime = null): void {
	if(empty($newLocationEndTime) === true) {
		throw (new \InvalidArgumentException("Location end time is empty, Please enter a location end time"));
	}
	if(strlen($newLocationEndTime) !== 14) {
		throw (new \RangeException("LocationEndTime is not in the correct format"));
	}
	try {
		$newLocationEndTime = self::validateDateTime($newLocationEndTime);
	} catch(\InvalidArgumentException | \RangeException $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));

		// store the string
		$this->locationEndTime = $newLocationEndTime;
	}
}


}


?>