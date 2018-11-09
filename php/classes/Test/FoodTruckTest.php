<?php

namespace Edu\Cnm\FoodTruckFinder\Test;

use Edu\Cnm\FoodTruckFinder\{profile, foodTruck};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the FoodTruck class
 *
 * This is a complete PHPUnit test of the FoodTruck class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see FoodTruck
 * @author Greg Klein <gklein@cnm.edu>
 **/

 class FoodTruckTest extends DataDesignTest {
	 /**
	  * Profile that created the FoodTruck; this is for foreign key relations
	  * @var Profile profile
	  **/
	  protected $profile = null;

	 /**
	  * valid profile hash to create the profile object to own the test
	  * @var $VALID_HASH
	  */
	  protected $VALID_PROFILE_HASH;

	 /**
	  * content of the food truck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION
	  **/
	  protected $VALID_FOODTRUCKDESCRIPTION = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION2
	  **/
	  protected $VALID_FOODTRUCKDESCRIPTION2 = "PHPUnit test still passing";

	 /**
	  * content of the food truck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION
	  **/
	 protected $VALID_FOODTRUCKIMAGEURL = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION2
	  **/
	 protected $VALID_FOODTRUCKIMAGEURL2 = "PHPUnit test still passing";

	 /**
	  * content of the food truck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION
	  **/
	 protected $VALID_FOODTRUCKMENUURL = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION2
	  **/
	 protected $VALID_FOODTRUCKMENUURL2 = "PHPUnit test still passing";

	 /**
	  * content of the food truck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION
	  **/
	 protected $VALID_FOODTRUCKNAME = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION2
	  **/
	 protected $VALID_FOODTRUCKNAME2 = "PHPUnit test still passing";

	 /**
	  * content of the food truck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION
	  **/
	 protected $VALID_FOODTRUCKPHONENUMBER = "PHPUnit test still passing";

	 /**
	  * content of the updated foodTruck description
	  * @var string $VALID_FOODTRUCKDESCRIPTION2
	  **/
	 protected $VALID_FOODTRUCKPHONENUMBER2 = "PHPUnit test still passing";
 }

/**
 * test inserting a valid FoodTruck and verify the actual mySQL data matches
 **/
