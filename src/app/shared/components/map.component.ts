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
		foodTruckName: null,
		foodTruckPhoneNumber: null,
		foodTruckImageUrl: null
	};

	foodTruck: FoodTruck = new class implements FoodTruck {
		foodTruckDescription: string;
		foodTruckId: string;
		foodTruckImageUrl: string;
		foodTruckMenuUrl: string;
		foodTruckName: string;
		foodTruckPhoneNumber: string;
		foodTruckProfileId: string;
	};

	//may not need lines 36-38
	data: Observable<Array<FoodTruck[]>>;

	foodTrucks: FoodTruck[] = [];

	foodTruckLocations: FoodTruckLocations[] = [];


	status: Status = {status: null, message: null, type: null};

	constructor(protected foodTruckService: FoodTruckService, private route: ActivatedRoute) {}


	ngOnInit() : void {
		this.foodTruckService.getAllActiveFoodTrucks().subscribe(foodTruckLocations => {this.foodTruckLocations = foodTruckLocations});
			}


	clicked({target: marker} : any, foodTruck : FoodTruck) {
		this.marker.foodTruckName = this.foodTruckService.getFoodTruckByFoodTruckName("Soo Bak");

		marker.nguiMapComponent.openInfoWindow('foodtruck-deetz', marker)
	}

	hideMarkerInfo() {
		this.marker.display = !this.marker.display;
	}

	displayFoodTruck(foodTruck: FoodTruck) {
//		this.foodTruck = foodTruck;
	}



}