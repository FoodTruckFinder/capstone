import { Component, OnInit } from '@angular/core';
import { FoodTruckService} from "../shared/services/foodtruck.service";
import {FoodTruck} from "../shared/interfaces/foodtruck";
import {Status} from "../shared/interfaces/status";

@Component({
  template: require("./foodtruck.component.html"),
	selector: "foodTruck"
})
export class FoodTruckComponent implements OnInit {
	foodtrucks: FoodTruck[];
	status: Status = {status: null, message: null, type: null};

	constructor(private foodTruckService: FoodTruckService) {
	}

	ngOnInit() {
		this.foodTruckService.getAllFoodTrucks().subscribe(foodtrucks => {this.foodtrucks = foodtrucks});

	}
}

