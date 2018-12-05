
import {HttpClient, HttpParams} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/internal/Observable";
import {FoodTruck} from "../interfaces/foodtruck";
import {Location} from"../interfaces/location";

@Injectable()
export class LocationService {
	constructor(protected http: HttpClient) {
	}

	// define an API endpoint
	private locationUrl = "api/location/";

	//reach out to the location  API and delete the location in question
	deleteLocation(id: string): Observable<Status> {
		return (this.http.delete<Status>(this.locationUrl + id));
	}

	// call to the Location API and get a Location object by its id
	getLocation(id: string): Observable<Location> {
		return (this.http.get<Location>(this.locationUrl + id));
	}

	// call to the Location API and get a Location object by its email address
	getLocationByFoodTruckId(foodTruckId: string): Observable<Location> {
		return (this.http.get<Location>(this.locationUrl, {params: new HttpParams().set("FoodTruckId", foodTruckId)}));
	}

}