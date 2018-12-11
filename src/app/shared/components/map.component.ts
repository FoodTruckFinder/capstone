import {Component, OnInit} from "@angular/core";
import {FoodTruckService} from "../services/foodtruck.service";
import {FoodTruck} from "../interfaces/foodtruck";
import {Status} from "../interfaces/status";
import {Location} from "../interfaces/location";
import {ActivatedRoute} from "@angular/router";
import {FoodTruckLocation} from "../interfaces/foodtrucklocations";
import {Observable} from "rxjs";


@Component({
	template: require("./map.component.html"),
	selector: "map"
})


export class MapComponent implements OnInit {

	marker = {
		display: true,
		locationLatitude: null,
		locationLongitude: null,
	};






	status: Status = {status: null, message: null, type: null};

	foodTruck : FoodTruck = {foodTruckId: null, foodTruckProfileId: null, foodTruckDescription: null, foodTruckImageUrl: null, foodTruckMenuUrl: null, foodTruckName: null, foodTruckPhoneNumber: null};

	location : Location = {locationId: null, locationFoodTruckId: null, locationEndTime: null, locationLatitude: null, locationLongitude: null, locationStartTime: null};

	foodTruckLocations: FoodTruckLocation[] = [];


	constructor(protected foodTruckService: FoodTruckService, private route: ActivatedRoute) {}


	ngOnInit() : void {
		this.foodTruckService.getAllActiveFoodTrucks().subscribe(foodTruckLocations => {this.foodTruckLocations = foodTruckLocations});
			}

	clicked({target: marker} :any, foodTruckLocation : FoodTruckLocation) {
		this.foodTruck = foodTruckLocation.foodTruck;
		this.location = foodTruckLocation.location;
		marker.nguiMapComponent.openInfoWindow('foodtruck-deetz', marker)
	}




	hideMarkerInfo() {
		this.marker.display = !this.marker.display;
	}

}