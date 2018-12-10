import {Component, OnInit} from "@angular/core";
import {FoodTruckService} from "../services/foodtruck.service";
import {FoodTruck} from "../interfaces/foodtruck";
import {Status} from "../interfaces/status";
import {ActivatedRoute} from "@angular/router";
import {FoodTruckLocations} from "../interfaces/foodtrucklocations";



@Component({
	template: require("./map.component.html"),
	selector: "map"
})


export class MapComponent implements OnInit {
	marker = {
		display: true,
		foodTruckName: null,
		foodTruckPhoneNumber: null
	};


	foodTruckLocations: FoodTruckLocations[] = [];


	status: Status = {status: null, message: null, type: null};

	constructor(protected foodTruckService: FoodTruckService, private route: ActivatedRoute) {}


	ngOnInit() : void {
		this.foodTruckService.getAllActiveFoodTrucks().subscribe(foodTruckLocations => {this.foodTruckLocations = foodTruckLocations});
			}


	clicked({target: marker} : any, foodTruck : FoodTruck) {

	}

	hideMarkerInfo() {
		this.marker.display = !this.marker.display;
	}

	displayFoodTruck(foodTruck: FoodTruck) {
//		this.foodTruck = foodTruck;
	}



}