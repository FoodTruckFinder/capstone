import {Component, OnInit} from "@angular/core";
import {FoodTruckService} from "../services/foodtruck.service";
import {FoodTruck} from "../interfaces/foodtruck";
import {Status} from "../interfaces/status";
import {ActivatedRoute} from "@angular/router";
import {FoodTruckLocations} from "../interfaces/foodtrucklocations";
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

	foodTruckLocations: FoodTruckLocations[] = [];

	foodTruckLocation: Array[Object];


	constructor(protected foodTruckService: FoodTruckService, private route: ActivatedRoute) {}


	ngOnInit() : void {
		this.foodTruckService.getAllActiveFoodTrucks().subscribe(foodTruckLocations => {this.foodTruckLocations = foodTruckLocations});
			}

	clicked({target: marker} :any, foodTruckLocation : FoodTruckLocation) {
		this.foodtruck = marker;
		marker.nguiMapComponent.openInfoWindow('foodtruck-deetz', marker)
	}




	hideMarkerInfo() {
		this.marker.display = !this.marker.display;
	}
//making state variable for this
	displayFoodTruck(foodTruckLocation : FoodTruckLocation) {
		this.foodtruck = foodtruck;
	}

}