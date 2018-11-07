<?php

namespace Edu/Cnm/FoodTruckFinder;

require_once "autoload.php";
require_once (dirname(__DIR__, 2) . "vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class FoodTruck {

	/**
	*id for foodTruck. primary key.
	* @var Uuid $foodTruckId
	**/
	private $foodTruckId;
	/**
	 *id for profile associated with this foodTruck. foreign key. is indexed.
	 * @var Uuid $foodTruckProfileId
	 **/
	 private $foodTruckProfileId;
	/**
	 *description for food truck.
	 * @var varchar $foodTruckDescription
	 **/
	 private $foodTruckDescription;
	/**
	 *image url for foodTruck.
	 * @var varchar $foodTruckImageUrl
	 **/
	private $foodTruckImageUrl;
	/**
	 * menu url for foodTruck
	 * @var varchar $foodTruckMenuUrl
	 **/
	 private $foodTruckMenuUrl;
	/**
	 * name of foodTruck.
	 * @var varchar $foodTruckName
	 **/
	 private $foodTruckName;
	/**
	 * phone number for FoodTruck.
	 * @var string $foodTruckPhoneNumber
	 **/
	 private $foodTruckPhoneNumber;

	/**
	 * constructor for this foodTruck
	 *
	 * @param string|Uuid $newFoodTruckId id of this foodTruck or null if a new truck
	 * @param string|Uuid $newFoodTruckProfileId id of the Profile for the tood truck
	 * @param varchar $newFoodTruckDescription varchar containing description
	 * @param varchar $newFoodTruckImageUrl varchar for foodTruck image url
	 * @param varchar $newFoodTruckMenuUrl varchar for foodTruck menu url
	 * @param varchar $newFoodTruckName varchar for foodTruck name
	 * @param string $newFoodTruckPhoneNumber string for truck phone number
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newFoodTruckId, $newFoodTruckProfileId, $newFoodTruckDescription = null, $newFoodTruckImageUrl, $newFoodTruckMenuUrl = null, $newFoodTruckName, string $newFoodTruckPhoneNumber = null) {
		try {
			$this->setFoodTruckId($newFoodTruckId);
			$this->setFoodTruckProfileId($newFoodTruckProfileId);
			$this->setFoodTruckDescription($newFoodTruckDescription);
			$this->setFoodTruckImageUrl($newFoodTruckImageUrl);
			$this->setFoodTruckMenuUrl($newFoodTruckMenuUrl);
			$this->setFoodTruckName($newFoodTruckName);
			$this->setFoodTruckPhoneNumber($newFoodTruckPhoneNumber);
		}
		//determine exception thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	*getter method for foodTruckId
	* @return Uuid value of foodTruckId
	**/
	public function getFoodTruckId(): Uuid {
		return($this->foodTruckId);
	}

	/**
	 * mutator method for foodTruckId
	 *
	 * @param Uuid|string $newFoodTruckId new value of foodTruck id
	 * @throws \RangeException if $newFoodTruckId is not positive
	 * @throws \TypeError if $newFoodTruckId is not a uuid or string
	 **/
	public function setFoodTruckId($newFoodTruckId) : void {
		try {
			$uuid = self::validateUuid($newFoodTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		}

		//convert and store foodTruck id
		$this->foodTruckId = $uuid;
	}

	/**
	 *getter method for foodTruckProfileId
	 * @return Uuid value of foodTruckProfileId
	 **/
	public function getFoodTruckProfileId(): Uuid{
		return($this->foodTruckProfileId);
	}

	/**
	 * mutator method for foodTruckProfileId
	 *
	 * @param Uuid|string $newFoodTruckProfileId new value of foodTruck profile id
	 * @throws \RangeException if $newFoodTruckProfileId is not positive
	 * @throws \TypeError if $newFoodTruckProfileId is not a uuid or string
	 **/
	public function setFoodTruckProfileId($newFoodTruckProfileId) : void {
		try {
			$uuid = self::validateUuid($newFoodTruckProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store food truck profile id
		$this->foodTruckProfileId = $uuid;
	}

	/**
	 *getter method for foodTruckDescription
	 * @return string value of foodTruckDescription
	 **/
	public function getFoodTruckDescription() : string {
		return($this->foodTruckDescription);
	}

	/**
	 * mutator method for food truck description
	 *
	 * @param string $newFoodTruckDescription new value of food truck description
	 * @throws \InvalidArgumentException if $newFoodTruckDescription is not a string or insecure
	 * @throws \RangeException if $newFoodTruckDescription is > 256 characters
	 * @throws \TypeError if $newFoodTruckDescription is not a string
	 **/
	public function setFoodTruckDescription(string $newFoodTruckDescription) : void {
		//verify description is secure
		$newFoodTruckDescription = trim($newFoodTruckDescription);
		$newFoodTruckDescription = filter_var($newFoodTruckDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newFoodTruckDescription) === true) {
			throw(new \InvalidArgumentException("description is empty or insecure"));
		}

		//verify description will fit in database
		if(strlen($newFoodTruckDescription) >= 256) {
			throw(new \RangeException("description is too long"));
		}

		//store description
		$this->foodTruckDescription = $newFoodTruckDescription;
	}

	/**
	 *getter method for foodTruckImageUrl
	 * @return string value of foodTruckImageUrl
	 **/
	public function getFoodTruckImageUrl() : string {
		return($this->foodTruckImageUrl);
	}

	/**
	 * mutator method for food truck image url
	 *
	 * @param string $newFoodTruckImageUrl new value of food truck image url
	 * @throws \InvalidArgumentException if $newFoodTruckImageUrl is not a string or insecure
	 * @throws \RangeException if $newFoodTruckImageUrl is > 255 characters
	 * @throws \TypeError if $newFoodTruckImageUrl is not a string
	 **/
	public function setFoodTruckImageUrl(string $newFoodTruckImageUrl) : void {
		//verify image url is secure
		$newFoodTruckImageUrl = trim($newFoodTruckImageUrl);
		$newFoodTruckImageUrl = filter_var($newFoodTruckImageUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newFoodTruckImageUrl) === true) {
			throw(new \InvalidArgumentException("image url is empty or insecure"));
		}

		//verify image url will fit in database
		if(strlen($newFoodTruckImageUrl) >= 255) {
			throw(new \RangeException("image url is too long"));
		}

		//store image url
		$this->foodTruckImageUrl = $newFoodTruckImageUrl;
	}

	/**
	 *getter method for foodTruckMenuUrl
	 * @return string value of foodTruckMenuUrl
	 **/
	public function getFoodTruckMenuUrl() : string {
		return($this->foodTruckMenuUrl);
	}

	/**
	 * mutator method for food truck menu url
	 *
	 * @param string $newFoodTruckMenuUrl new value of food truck Menu url
	 * @throws \InvalidArgumentException if $newFoodTruckMenuUrl is not a string or insecure
	 * @throws \RangeException if $newFoodTruckMenuUrl is > 255 characters
	 * @throws \TypeError if $newFoodTruckMenuUrl is not a string
	 **/
	public function setFoodTruckMenuUrl(string $newFoodTruckMenuUrl) : void {
		//verify image url is secure
		$newFoodTruckMenuUrl = trim($newFoodTruckMenuUrl);
		$newFoodTruckMenuUrl = filter_var($newFoodTruckMenuUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newFoodTruckMenuUrl) === true) {
			throw(new \InvalidArgumentException("menu url is empty or insecure"));
		}

		//verify menu url will fit in database
		if(strlen($newFoodTruckMenuUrl) >= 255) {
			throw(new \RangeException("menu url is too long"));
		}

		//store menu url
		$this->foodTruckMenuUrl = $newFoodTruckMenuUrl;
	}

	/**
	 *getter method for foodTruckName
	 * @return string value of foodTruckName
	 **/
	public function getFoodTruckName() : string {
		return($this->foodTruckName);
	}

	/**
	 * mutator method for food truck Name
	 *
	 * @param string $newFoodTruckName new value of food truck Name
	 * @throws \InvalidArgumentException if $newFoodTruckName is not a string or insecure
	 * @throws \RangeException if $newFoodTruckName is > 128 characters
	 * @throws \TypeError if $newFoodTruckName is not a string
	 **/
	public function setFoodTruckName(string $newFoodTruckName) : void {
		//verify Name is secure
		$newFoodTruckName = trim($newFoodTruckName);
		$newFoodTruckName = filter_var($newFoodTruckName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newFoodTruckName) === true) {
			throw(new \InvalidArgumentException("food truck name is empty or insecure"));
		}

		//verify Name will fit in database
		if(strlen($newFoodTruckName) >= 128) {
			throw(new \RangeException("food truck name is too long"));
		}

		//store Name
		$this->foodTruckName = $newFoodTruckName;
	}

	/**
	 *getter method for foodTruckPhoneNumber
	 * @return string value of foodTruckPhoneNumber
	 **/
	public function getFoodTruckPhoneNumber() : string {
		return($this->foodTruckPhoneNumber);
	}

	/**
	 * mutator method for food truck PhoneNumber
	 *
	 * @param string $newFoodTruckPhoneNumber new value of food truck PhoneNumber
	 * @throws \InvalidArgumentException if $newFoodTruckPhoneNumber is not a string or insecure
	 * @throws \RangeException if $newFoodTruckPhoneNumber is > 16 characters
	 * @throws \TypeError if $newFoodTruckPhoneNumber is not a string
	 **/
	public function setFoodTruckPhoneNumber(string $newFoodTruckPhoneNumber) : void {
		//verify PhoneNumber is secure
		$newFoodTruckPhoneNumber = trim($newFoodTruckPhoneNumber);
		$newFoodTruckPhoneNumber = filter_var($newFoodTruckPhoneNumber, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newFoodTruckPhoneNumber) === true) {
			throw(new \InvalidArgumentException("food truck phone number is empty or insecure"));
		}

		//verify PhoneNumber will fit in database
		if(strlen($newFoodTruckPhoneNumber) >= 16) {
			throw(new \RangeException("food truck phone number is too long"));
		}

		//store PhoneNumber
		$this->foodTruckPhoneNumber = $newFoodTruckPhoneNumber;
	}
}

/**
 * inserts this foodTruck into mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function insert(\PDO $pdo) : void {

	//create query template
	$query = "INSERT INTO foodTruck(foodTruckId, foodTruckProfileId, foodTruckDescription, foodTruckImageUrl, foodTruckMenuUrl, foodTruckName, foodTruckPhoneNumber)";
	$statement = $pdo->prepare($query);

	//bind the member variables to the placeholders in the template
	$parameters = ["foodTruckId" => $this->foodTruckId->getBytes(), "foodTruckProfileId" => $this->foodTruckProfileId->getBytes(), "foodTruckDescription" => $this->foodTruckDescription, "foodTruckImageUrl" => $this->foodTruckImageUrl, "foodTruckMenuUrl" => $this->foodTruckMenuUrl, "foodTruckName" => $this->foodTruckName, "foodTruckPhoneNumber" => $this->foodTruckPhoneNumber];
	$statement->execute($parameters);
}

/**
 * deletes this foodTruck from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo) : void {

	// create query template
	$query = "DELETE FROM foodTruck WHERE foodTruckId = :foodTruckId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the placeholder in the template
	$parameters = ["foodTruckId" => $this->foodTruckId->getBytes()];
	$statement->execute($parameters);
}