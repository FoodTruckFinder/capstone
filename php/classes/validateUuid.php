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
	}
}