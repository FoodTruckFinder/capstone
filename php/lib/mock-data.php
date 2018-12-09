<?php
namespace FoodTruckFinder\Capstone;

require_once(dirname(__DIR__) . "/classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once("uuid.php");
// grab the uuid generator
require_once( "uuid.php");

//connect to the database
$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort22/fooddelivery");
$pdo = $secrets->getPdoObject();

/*
//begin fake profiles
$password = "fucking work";

$hash = password_hash($password, PASSWORD_ARGON2I);

$profile = new Profile(generateUuidV4(),null, "IAMSAM@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM2@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM3@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM4@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM5@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM6@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM7@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM8@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM9@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM0@gmail.com", "password", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM10@gmail.com", "password", 1,"William");
$profile->insert($pdo);
*/
//begin fake foodtrucks

//begin fake locations

$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.079144,-106.646242, null);
$location->insert($pdo);


$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.098716,-106.672275, null);
$location->insert($pdo);
$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.204097,-106.601356, null);
$location->insert($pdo);
$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.104368,-106.574661, null);
$location->insert($pdo);
$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.301295,-106.554704, null);
$location->insert($pdo);


