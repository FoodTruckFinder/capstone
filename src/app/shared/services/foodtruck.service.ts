import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Observable} from "rxjs";
import {FoodTruck} from "../interfaces/foodtruck";
import {Location} from "../interfaces/location";
import {Status} from "../interfaces/status";
import {BehaviorSubject} from "rxjs";
import {FoodTruckLocations} from "../interfaces/foodtrucklocations";


@Injectable()
export class FoodTruckService {
	protected foodTruckSubject : BehaviorSubject<FoodTruck[]> = new BehaviorSubject<FoodTruck[]>([]);
	public foodTruckObserver : Observable<FoodTruck[]> = this.foodTruckSubject.asObservable();
	constructor(protected http: HttpClient) {
		this.getAllActiveFoodTrucks().subscribe(foodTruckLocations => this.foodTruckSubject.next(foodTruckLocations));
	}

	// define an API endpoint
	private foodtruckUrl = "api/foodTruck/";

	// reach out to the foodtruck API and grab a FoodTruck object by it's Id
	getFoodTruckByFoodTruckId(id: string) : Observable<FoodTruck> {
		return(this.http.get<FoodTruck>(this.foodtruckUrl + id));
	}

	// reach out to the foodtruck API and create the foodtruck
	createFoodTruck(foodtruck: FoodTruck) : Observable<Status> {
		return(this.http.post<Status>(this.foodtruckUrl, foodtruck));
	}

	// reach out to the foodtruck API and edit the foodtruck
	editFoodTruck(foodtruck: FoodTruck) : Observable<Status> {
		return(this.http.put<Status>(this.foodtruckUrl, foodtruck));
	}



	// reach out to the foodtruck API and grab a FoodTruck object by it's FoodTruck Profile Id
	getFoodTruckByFoodTruckProfileId(foodTruckProfileId: string) : Observable<FoodTruck> {
		return(this.http.get<FoodTruck>(this.foodtruckUrl + foodTruckProfileId));
	}

	// reach out to the foodtruck API and grab a FoodTruck object by it's Name
	getFoodTruckByFoodTruckName(foodTruckName: string) : Observable<FoodTruck> {
		return(this.http.get<FoodTruck>(this.foodtruckUrl + foodTruckName));
	}

	// reach out to the foodtruck API and grab a FoodTruck object by it's FoodTruck Profile Id
	getAllFoodTrucks() : Observable<FoodTruck[]> {
		return(this.http.get<FoodTruck[]>(this.foodtruckUrl));
	}
	getAllActiveFoodTrucks() : Observable<any> {
		return(this.http.get<FoodTruckLocations[]>(this.foodtruckUrl));
	}


}

