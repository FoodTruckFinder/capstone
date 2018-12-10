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

	status: Status = {status: null, message: null, type: null};

	constructor(protected foodTruckService: FoodTruckService, private route: ActivatedRoute) {}

	ngOnInit() : void {
		this.listActiveFoodTrucks();
		this.getAllActiveFoodTrucks().subscribe(
			res => {
				let datas = dat["data"];
				let data = data[0];
				console.log(data["foodTruck"]);
			});
	}

	getAllActiveFoodTrucks() : Observable<any> {
		return this.http.get(this.url).map(res => res.json());
	}

		listActiveFoodTrucks(): any {
			this.foodTruckService.foodTruckObserver.subscribe(foodTruckLocations => this.foodTruckLocations = foodTruckLocations)
		}


}