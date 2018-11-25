<?php

require_once dirname(__3__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use FoodTruckFinder\Capstone\Favorite;
use FoodTruckFinder\Capstone\FoodTruck;
