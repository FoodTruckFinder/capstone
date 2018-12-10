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

$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
var_dump(strlen($hash));

$profile = new Profile(generateUuidV4(),null, "IAMSAM@gmail.com", "$hash", 1,"William");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM2@gmail.com", "$hash", 1,"Bob");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM3@gmail.com", "$hash", 1,"Joe");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM4@gmail.com", "$hash", 1,"Jill");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM5@gmail.com", "$hash", 1,"Sara");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM6@gmail.com", "$hash", 1,"Cat");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM7@gmail.com", "$hash", 1,"David");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM8@gmail.com", "$hash", 1,"Bernina");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM9@gmail.com", "$hash", 1,"Rae");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM0@gmail.com", "$hash", 1,"Jack");
$profile->insert($pdo);

$profile = new Profile(generateUuidV4(),null, "IAMSAM10@gmail.com", "$hash", 1,"Chamisa");
$profile->insert($pdo);


//begin fake foodtrucks



$foodtruck = new FoodTruck(generateUuidV4(),"7c87fb70-91a4-4014-b6f6-2e216e26e09d", "FoodTruck1", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","Supper Truck","505-555-5555" );
$foodtruck->insert($pdo);

$foodtruck = new FoodTruck(generateUuidV4(),"d6794e24-ee51-45f9-82ea-db05ee6f6ec2", "FoodTruck2", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","Oni Noodles","505-555-5555");
$foodtruck->insert($pdo);

$foodtruck = new FoodTruck(generateUuidV4(),"d33dbe86-24c0-4ab8-95fd-c01d14fcb735", "FoodTruck3", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","Nomad BBQ","505-555-5555");
$foodtruck->insert($pdo);

$foodtruck = new FoodTruck(generateUuidV4(),"bb5169b3-7f4b-4b3e-975e-5223cacd05a9", "FoodTruck4", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","ABQ BBQ on Wheels","505-555-5555");
$foodtruck->insert($pdo);


$foodtruck = new FoodTruck(generateUuidV4(),"7c87fb70-91a4-4014-b6f6-2e216e26e09d", "FoodTruck5", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","Grilled Cheez eXpress","505-555-5555");
$foodtruck->insert($pdo);

$foodtruck = new FoodTruck(generateUuidV4(),"a8e72b51-abff-48da-a763-089c086be673", "FoodTruck6", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","El Paisa","Chamisa");
$foodtruck->insert($pdo);

$foodtruck = new FoodTruck(generateUuidV4(),"a90148b5-2c7e-4f61-8a42-cda261c828bd", "FoodTruck7", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","Meals on Wheels","Chamisa");
$foodtruck->insert($pdo);

$foodtruck = new FoodTruck(generateUuidV4(),"f506c838-971f-4353-b6c5-2bac7cdf667a", "FoodTruck8", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","Su Bak","Chamisa");
$foodtruck->insert($pdo);

$foodtruck = new FoodTruck(generateUuidV4(),"ef85dd98-1a4f-4d3c-87d3-fadd660fdc28", "FoodTruck9", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","Deep Fried PBJ ","Chamisa");
$foodtruck->insert($pdo);

$foodtruck = new FoodTruck(generateUuidV4(),"33d415f-be51-40c6-8290-863718cd95a7", "FoodTruck10", "https://static.wixstatic.com/media/2462fd_0d26898bbf88def0a5de05dee979da49.jpg/v1/fill/w_960,h_608,al_c,q_90/2462fd_0d26898bbf88def0a5de05dee979da49.webp", "https://www.ilovesupper.com/menu","Kerus","Chamisa");
$foodtruck->insert($pdo);

*/

$location = new Location(generateUuidV4(),"0632e2c4-0493-4bbf-9121-565c5881cf23", null, 35.0928,-106.6467, null);
$location->insert($pdo);


$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.130449,-106.530022, null);
$location->insert($pdo);

$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.216457,-106.698214, null);
$location->insert($pdo);

$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.104368,-106.574661, null);
$location->insert($pdo);

$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.118007, -106.614151, null);
$location->insert($pdo);

$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null,  35.106097, -106.650892, null);
$location->insert($pdo);

$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.102533, -106.647781, null);
$location->insert($pdo);

$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.079654, -106.606705, null);
$location->insert($pdo);

$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.086723, -106.594554, null);
$location->insert($pdo);

$location = new Location(generateUuidV4(),"25c39272-92dc-47a8-a056-ab976be96c4f", null, 35.080986, -106.650044, null);
$location->insert($pdo);

