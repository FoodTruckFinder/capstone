-- The statement below sets the collation of the database to utf8
ALTER DATABASE fooddelivery CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS social;
DROP TABLE IF EXISTS location;
DROP TABLE IF EXISTS foodTruck;
DROP TABLE IF EXISTS profile;


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
	foodTruckDescription VARCHAR (256) NULL,
	foodTruckImageUrl VARCHAR (255) NOT NULL,
	foodTruckMenuUrl VARCHAR (255) NULL,
	foodTruckName VARCHAR (128) NOT NULL,
	foodTruckPhoneNumber VARCHAR (16) NULL,

	UNIQUE(foodTruckName),
	UNIQUE(foodTruckProfileId),
	INDEX (foodTruckProfileId),
	FOREIGN KEY(foodTruckProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(foodTruckId)

);

CREATE TABLE favorite (

	favoriteProfileId BINARY(16) NOT NULL,
	favoriteFoodTruckId BINARY(16) NOT NULL,
	favoriteAddDate DATETIME NOT NULL,
	INDEX(favoriteProfileId),
	INDEX(favoriteFoodTruckId),
	PRIMARY KEY(favoriteProfileId, favoriteFoodTruckId),
	FOREIGN KEY(favoriteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(favoriteFoodTruckId) REFERENCES foodTruck(foodTruckId)

);

CREATE TABLE social (

	socialId BINARY(16) NOT NULL,
	socialFoodTruckId BINARY(16) NOT NULL,
	socialUrl VARCHAR(255) NOT NULL,
	INDEX(socialFoodTruckId),
	PRIMARY KEY(socialId),
	FOREIGN KEY (socialFoodTruckId) REFERENCES foodTruck(foodTruckId)

);

CREATE TABLE location (

	locationId BINARY(16) NOT NULL,
	locationFoodtruckId BINARY(16) NOT NULL,
	locationEndTime DATETIME(6) NOT NULL,
	locationLatitude DECIMAl(9,6) NOT NULL,
	locationLongitude DECIMAl(9,6) NOT NULL,
	locationStartTime DATETIME(6) NOT NULL,

	INDEX(locationFoodTruckId),
	FOREIGN KEY(locationFoodtruckId) REFERENCES foodTruck(foodTruckId),
	PRIMARY KEY (locationId)
);