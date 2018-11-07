<?php

namespace Edu/Cnm/FoodTruckFinder;
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * Trait to validate a uuid
 *
 * This trait will validate a uuid in any of the following three formats:
 *
 * 1. human readable string (36 bytes)
 * 2. binary string (16 bytes)
 * 3. Ramsey\Uuid|Uuid object
 */

trait ValidateUuid {
	/**
	 * validates a uuid irrespective of format
	 *
	 * @param string | Uuid $newUuid uuid to validate
	 * @return Uuid objext with validate uuid
	 * @throws \InvalidArgumentException if $newUuid is not a valid uuid
	 * @throws \RangeException if $newUuid is not a valid uuid v4
	 */
	private static function validateUuid($newUuid) : Uuid {
		// verify a string Uuid
		if(gettype($newUuid) === "string") {
			// 16 characters is binary data from mySQL - convert to string and fall to next if block
			if(strlen($newUuid) === 16) {
				$newUuid = bin2hex($newUuid);
				$newUuid = substr($newUuid, 0, 8) . "-" . substr($newUuid, 8, 4) . "-" . substr($newUuid,12,4) . "-" . substr($newUuid,16,4) . "-" . substr($newUuid,20,12);
			}
			// 36 characters is human readable uuid
		}
	}
}