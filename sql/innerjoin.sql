ALTER DATABASE fooddelivery CHARACTER SET utf8 COLLATE utf8_unicode_ci;

SELECT
foodTruckId,
foodTruckProfileId,
foodTruckDescription,
foodTruckImageUrl,
foodTruckMenuUrl,
foodTruckName,
foodTruckPhoneNumber,
locationId,
locationFoodTruckId,
locationEndTime,
locationLatitude,
locationLongitude,
locationStartTime
FROM
foodTruck
INNER JOIN location on foodTruck.foodTruckId = location.locationFoodTruckId WHERE NOW() BETWEEN location.locationStartTime AND location.locationEndTime