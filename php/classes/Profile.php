<?php

namespace FoodTruckFinder\Capstone;

require_once "autoload.php";
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Profile implements \JsonSerializable {

	use ValidateUuid;

	/**
	 * id for this profile; this is a primary key
	 * @var Uuid $profileId
	 */
	private $profileId;
	/**
	 * activation token for this profile
	 * @var string $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * the email associated with this profile
	 * @var string $profileEmail
	 */
	private $profileEmail;
	/**
	 * the hashed password of this profile
	 * @var string $profileHash
	 */
	private $profileHash;
	/**
	 * the boolean to check if profile is a truck owner
	 * @var integer $profileIsOwner
	 */
	private $profileIsOwner;
	/**
	 * the profile name provided by the user
	 * @var string $profileName
	 */
	private $profileName;

	/**
	 * constructor for this profile
	 *
	 * @param Uuid | string $newProfileId id of this profile or null if new profile
	 * @param string $newProfileActivationToken activation token of this profile or null if new profile
	 * @param string $newProfileEmail email of this profile or null if new profile
	 * @param string $newProfileHash hashed password of this profile or null if new profile
	 * @param $newProfileIsOwner boolean assigning truck owner status of this profile or null if new profile
	 * @param string $newProfileName name of the profile or null if new profile
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */

	public function __construct($newProfileId, ?string $newProfileActivationToken, string $newProfileEmail, string $newProfileHash, int $newProfileIsOwner, string $newProfileName) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileIsOwner($newProfileIsOwner);
			$this->setProfileName($newProfileName);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new	$exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of the profile id
	 */
	public function getProfileId() : Uuid {
		return $this->profileId;
	}
	/**
	 * mutator method for profile id
	 *
	 * @param Uuid | string $newProfileId new value of the profile id
	 *@throws \RangeException if $newProfileId is not positive
	 *@throws \TypeError if $newProfileId violates type hints
	 */
	public function setProfileId($newProfileId) : void {
		// verify the id is a valid uuid
		try {
			$uuid = self::validateUuid($newProfileId);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new	$exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the uuid
		$this->profileId = $uuid;
	}

	/**
	 * accessor method for profile activation token
	 *
	 * @return string of profile activation token
	 */
	public function getProfileActivationToken(): string {
		return $this->profileActivationToken;
	}
	/**
	 * mutator method for profile activation token
	 *
	 * @param string $newProfileActivationToken new value of the profile activation hash
	 * @throws \InvalidArgumentException if $newProfileActivationToken is not a valid data type
	 * @throws \RangeException if $newProfileActivationToken is longer than 32 characters
	 */
	public function setProfileActivationToken(string $newProfileActivationToken): void {
		// verify the string is 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw (new \RangeException("string is not 32 characters"));
		}
		// verify the string is hexadecimal
		if(ctype_xdigit($newProfileActivationToken) !== true) {
			throw (new \InvalidArgumentException("String is not hexadecimal"));
		}
		// store the string
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return	string of the profile email
	 */
	public function getProfileEmail(): string {
		return $this->profileEmail;

	}
	/**
	 * mutator method for profile email
	 *
	 * @param string $newProfileEmail new value of the profile email
	 * @throws \InvalidArgumentException if $newProfileEmail is empty
	 * @throws \RangeException if profile email is longer than 128 characters
	 * @throws \Exception if profile email is not well-formed
	 */
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the profile email is not empty
		if(empty($newProfileEmail) === true) {
			throw (new \InvalidArgumentException("email field is empty"));
		}
		// verify email address is not too long
		if(strlen($newProfileEmail) > 128) {
			throw (new \RangeException("email address is too long"));
		}
		// trim whitespace from email
		$newProfileEmail = trim($newProfileEmail);
		// verify if email is well formed
		if(filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL) === true) {
			throw (new \Exception("email in not valid format"));
		}
		// store the string
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string of profile hash
	 */
	public function getProfileHash(): string {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash
	 *
	 * @param string $newProfileHash new value of the profile hash
	 * @throws \InvalidArgumentException if $newProfileHash is empty
	 * @throws \RangeException if profile hash is longer than 97 characters
	 * @throws \Exception if profile hash is not hexadecimal
	 */
	public function setProfileHash(string $newProfileHash): void {
		// verify if the profile hash is not empty
		if(empty($newProfileHash) === true) {
			throw (new \InvalidArgumentException("profile hash is empty"));
		}
		//enforce the hash is really an Argon hash
		$profileHashInfo = password_get_info($newProfileHash);
		if($profileHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("profile hash is not a valid hash"));
		}

		// verify the hash is not too long
		if(strlen($newProfileHash) !== 97) {
			throw (new \RangeException("hash must be 97 characters!"));
		}
		// store the string
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for the boolean profile is owner
	 *
	 * @return int of profile is owner boolean
	 */
	public function getProfileIsOwner(): int {
		return $this->profileIsOwner;
	}
	/**
	 * mutator method for the boolean profile is owner
	 *
	 * @param integer $newProfileIsOwner new value of the boolean profile is owner
	 * @throws \InvalidArgumentException if $newProfileIsOwner is empty
	 * @throws \RangeException if integer is longer than 1 character
	 * @throws \Exception if integer is not 1 or 0
	 */
	public function setProfileIsOwner(int $newProfileIsOwner): void {

		// check profile is owner is either 1 or 0
		if($newProfileIsOwner !== 0 && $newProfileIsOwner !== 1) {
			throw (new \InvalidArgumentException("boolean is not 1 or 0"));
		}
		// store the integer
		$this->profileIsOwner = $newProfileIsOwner;
	}

	/**
	 *accessor method for profile name
	 *
	 * @return string of profile name
	 */
	public function getProfileName(): string {
		return $this->profileName;
	}
	/**
	 * mutator method for the profile name
	 *
	 * @param string $newProfileName new profile name
	 * @throws \InvalidArgumentException if $newProfile is empty
	 * @throws \RangeException if string is too long
	 */
	public function setProfileName(string $newProfileName): void {

		// check if string is too long
		if(strlen($newProfileName) > 32) {
			throw (new \RangeException("profile is too long"));
		}
		// sanitize string
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING);
		// check if string is empty
		if(empty($newProfileName) === true) {
			throw (new \InvalidArgumentException("profile name is empty"));
		}
		// store the string
		$this->profileName = $newProfileName;
	}


	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError id $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {


		// create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileName) VALUES (:profileId, :profileActivationToken, :profileEmail, :profileHash, :profileIsOwner, :profileName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileIsOwner" => $this->profileIsOwner, "profileName" => $this->profileName];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Profile form mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM profile WHERE profileId LIKE :profileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileEmail = :profileEmail, profileHash = :profileHash, profileIsOwner = :profileIsOwner, profileName = :profileName WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash,  "profileIsOwner" => $this->profileIsOwner, "profileName" => $this->profileName];
		$statement->execute($parameters);
	}

	/**
	 * get Profile by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid $profileId profile id to search for
	 * @return Profile|null return Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileId(\PDO $pdo, uuid $profileId): ?Profile {
		// sanitize the profileId before searching
		try {
			$profileId = self::validateUuid($profileId);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileName FROM profile WHERE profileId LIKE :profileId";
		$statement = $pdo->prepare($query);
		//bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);

		//grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row ["profileIsOwner"], $row["profileName"]);
			}
		} catch (\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}


	/**
	 * get Profile by profile activation token
	 *
	 * @param |PDO $pdo PDO connection object
	 * @param string $profileActivationToken profile activation token to search for
	 * @return Profile|null return Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken): Profile {
		// make sure activation toke is in the right format and that it is a string of hexadecimal
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileName FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);

		//grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row ["profileIsOwner"], $row["profileName"]);
			}
		} catch (\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * get Profile by profile email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileEmail profile email to search for
	 * @return Profile|null return Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail): Profile {
		// verify the profile email is not empty
		if(empty($profileEmail) === true) {
			throw (new \PDOException("email field is empty"));
		}
		// trim profile email sanitize
		$profileEmail = trim($profileEmail);
		// verify if email is well formed
		if(filter_var($profileEmail, FILTER_VALIDATE_EMAIL) === false) {
			throw (new \TypeError("email in not valid format"));
		}
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileName FROM profile WHERE profileEmail LIKE :profileEmail";
		$statement = $pdo->prepare($query);
		// bind the profile email to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);

		//grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row ["profileIsOwner"], $row["profileName"]);
			}
		} catch (\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
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