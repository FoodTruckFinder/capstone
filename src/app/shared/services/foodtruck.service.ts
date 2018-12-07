import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs";
import {FoodTruck} from "../interfaces/foodtruck";
import {Status} from "../interfaces/status";

@Injectable()
export class FoodTruckService {
	constructor(protected http: HttpClient) {}

	// define an API endpoint
	private foodtruckUrl = "api/foodtruck";

	// reach out to the foodtruck API and create the foodtruck
	createFoodTruck(foodtruck: FoodTruck) : Observable<Status> {
		return(this.http.post<Status>(this.foodtruckUrl, foodtruck));
	}

	// reach out to the foodtruck API and edit the foodtruck
	editFoodTruck(foodtruck: FoodTruck) : Observable<Status> {
		return(this.http.put<Status>(this.foodtruckUrl, foodtruck));
	}

	// reach out to the foodtruck API and grab a FoodTruck object by it's Id
	getFoodTruckByFoodTruckId(foodTruckId: string) : Observable<FoodTruck> {
		return(this.http.get<FoodTruck>(this.foodtruckUrl + foodTruckId));
	}

	// reach out to the foodtruck API and grab a FoodTruck object by it's FoodTruck Profile Id
	getFoodTruckByFoodtruckProfileId(foodTruckProfileId: string) : Observable<FoodTruck> {
		return(this.http.get<FoodTruck>(this.foodtruckUrl + foodTruckProfileId));
	}

	// reach out to the foodtruck API and grab a FoodTruck object by it's Name
	getFoodTruckByFoodtruckName(foodTruckName: string) : Observable<FoodTruck> {
		return(this.http.get<FoodTruck>(this.foodtruckUrl + foodTruckName));
	}

	// reach out to the foodtruck API and grab a FoodTruck object by it's FoodTruck Profile Id
	getAllFoodTrucks() : Observable<FoodTruck[]> {
		return(this.http.get<FoodTruck[]>(this.foodtruckUrl));
	}


}

