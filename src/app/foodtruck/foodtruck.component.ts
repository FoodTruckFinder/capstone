import {Component, OnInit} from '@angular/core';
import {FoodTruckService} from "../shared/services/foodtruck.service";
import {FoodTruck} from "../shared/interfaces/foodtruck";
import {Status} from "../shared/interfaces/status";
import {ActivatedRoute} from "@angular/router";

@Component({
	template: require("./foodtruck.component.html"),
	selector: "foodTruck"
})

export class FoodTruckComponent implements OnInit {

	foodtruck: FoodTruck = {
		foodTruckId: null,
		foodTruckProfileId: null,
		foodTruckDescription: null,
		foodTruckImageUrl: null,
		foodTruckMenuUrl: null,
		foodTruckName: null,
		foodTruckPhoneNumber: null
	};
	status: Status = {status: null, message: null, type: null};

	constructor(private foodTruckService: FoodTruckService, private route: ActivatedRoute) {
	}



	ngOnInit(): void {

		// grab the foodTruck name from the url
		let foodTruckName : string = "?foodTruckName=" + this.route.snapshot.params["name"];

		// use the foodTruck name to  grab a foodTruck from the server
		this.foodTruckService.getFoodTruckByFoodTruckName(foodTruckName).subscribe(foodtruck => this.foodtruck = foodtruck)
	}

}