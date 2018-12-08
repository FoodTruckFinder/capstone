import { Component, OnInit } from '@angular/core';
import { FoodTruckService} from "../shared/services/foodtruck.service";
import {FoodTruck} from "../shared/interfaces/foodtruck";
import {Status} from "../shared/interfaces/status";
import {ActivatedRoute} from "@angular/router";

@Component({
  template: require("./foodtruck.cards.component.html"),
	selector: "foodTruckCards"
})
export class FoodTruckCardsComponent implements OnInit {
	foodtrucks: FoodTruck[];
	status: Status = {status: null, message: null, type: null};

	constructor(private foodTruckService: FoodTruckService, private route: ActivatedRoute) {
	}

	ngOnInit() {
		this.foodTruckService.getAllFoodTrucks().subscribe(foodtrucks => {this.foodtrucks = foodtrucks});

	}
}

