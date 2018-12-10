import {Component, OnInit} from "@angular/core";
import {FoodTruckService} from "../services/foodtruck.service";
import {FoodTruck} from "../interfaces/foodtruck";
import {Location} from "../interfaces/location";
import {Status} from "../interfaces/status";
import {ActivatedRoute} from "@angular/router";
import {FoodTruckLocations} from "../interfaces/foodtrucklocations";
import {Observable} from "rxjs";


@Component({
	template: require("./map.component.html"),
	selector: "map"
})


export class MapComponent implements OnInit {

	foodTruckLocations: FoodTruckLocations[] = [];

	status: Status = {status: null, message: null, type: null};

	constructor(protected foodTruckService: FoodTruckService, private route: ActivatedRoute) {}


	ngOnInit() : void {
		this.foodTruckService.getAllActiveFoodTrucks().subscribe(foodTruckLocations => {this.foodTruckLocations = foodTruckLocations});

			}




}