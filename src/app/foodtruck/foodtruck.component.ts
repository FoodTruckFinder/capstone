import { Component, OnInit } from '@angular/core';
import { FoodTruckService} from "../shared/services/foodtruck.service";
import {FoodTruck} from "../shared/interfaces/foodtruck";
import {Status} from "../shared/interfaces/status";
import {ActivatedRoute} from "@angular/router";

@Component({
  template: require("./foodtruck.component.html"),
	selector: "foodTruck"
})
export class FoodTruckComponent implements OnInit {
	foodtrucks: FoodTruck[];
	foodtruck: FoodTruck = {foodTruckId: null, foodTruckProfileId: null, foodTruckDescription: null, foodTruckImageUrl: null, foodTruckMenuUrl: null, foodTruckName: null, foodTruckPhoneNumber: null};
	status: Status = {status: null, message: null, type: null};

	constructor(private foodTruckService: FoodTruckService, private route: ActivatedRoute) {
	}

	ngOnInit() {
		this.foodTruckService.getAllFoodTrucks().subscribe(foodtrucks => {this.foodtrucks = foodtrucks});

	}

	getFoodTruckByFoodTruckName() : void {
		// grab foodTruckName form the Url
		let foodTruckName : string = (this.route.snapshot.params["name"]);

		// use the misquote service to grab a misquote from the server
		this.foodTruckService.getFoodTruckByFoodTruckName(foodTruckName).subscribe(foodtruck => this.foodtruck = foodtruck)
	}
}

