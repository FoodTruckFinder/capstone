-- The statement below sets the collation of the database to utf8
ALTER DATABASE foodtruckfinder CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS foodTruck;
DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS social;
DROP TABLE IF EXISTS location;

CREATE TABLE profile (

	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) NOT NULL,
	profileHash VARCHAR(97) NOT NULL,
	profileIsOwner TINYINT NOT NULL,
	profileName VARCHAR(32) NOT NULL,

	UNIQUE(profileName),
	UNIQUE(profileEmail),
	PRIMARY KEY(profileId)

	);

CREATE TABLE foodTruck (

	foodTruckId BINARY (16) NOT NULL,
	foodTruckProfileId BINARY (16) NOT NULL,
	foodTruckDescription VARCHAR (32) NULL,
	foodTruckImageUrl VARCHAR (255) NOT NULL,
	foodTruckMenuUrl VARCHAR (255) NULL,
	foodTruckName VARCHAR (32) NOT NULL,
	foodTruckPhoneNumber STRING (16) NULL,

	UNIQUE(foodTruckName),
	UNIQUE(foodTruckProfileId),
	INDEX (foodTruckProfileId),
	FOREIGN KEY(foodTruckProfileId) REFERENCES Profile(ProfileId),
	PRIMARY KEY(foodTruckId)

);

CREATE TABLE favorite (

	favoriteProfileId BINARY(16) NOT NULL,
	favoriteFoodTruckId BINARY(16) NOT NULL,
	favoriteAddDate DATETIME NOT NULL,
	INDEX(favoriteProfileId),

	PRIMARY KEY(favoriteProfileId, favoriteFoodTruckId),
	FOREIGN KEY(favoriteProfileId) REFERENCES Profile(profileId),
	FOREIGN KEY(favoriteFoodTruckId) REFERENCES foodTruck(foodTruckId),

);

CREATE TABLE social (

	socialId BINARY(16) NOT NULL,
	socialFoodTruckId BINARY(16) NOT NULL,
	socialUrrl VARCHAR(255) NOT NULL,
	INDEX(socialFoodTruckId),
	PRIMARY KEY(socialId),
	FOREIGN KEY (socialFoodTruckId) REFERENCES foodTruck(foodTruckId)

);

CREATE TABLE location (

	locationId BINARY(16) NOT NULL,
	locationFoodtruckId BINARY(16) NOT NULL,
	locationEnd DATETIME(6) NOT NULL,
	locationLatitude DECIMAl(9,6) NOT NULL,
	locationLongitude DECIMAl(9,6) NOT NULL,
	locationStart DATETIME(6) NOT NULL,

	UNIQUE(locationId),
	UNIQUE(locationFoodtruckId),
	FOREIGN KEY(locationFoodtruckId) REFERENCES FoodTruck(foodTruckId)

);