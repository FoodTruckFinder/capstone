import {Injectable} from "@angular/core";
import{Status} from "../interfaces/status";
import {Favorite} from "../interfaces/favorite"
import {Observable} from "rxjs/internal/Observable";
import {HttpClient, HttpParams} from "@angular/common/http";
import {FoodTruck} from "../interfaces/foodtruck";

@Injectable ()
export class FavoriteService {

	constructor(protected http : HttpClient ) {}

	private  favoriteUrl = 'api/favorite/';

	//call to the favorite API to add a favorite

	createFavorite(favorite: Favorite) : Observable<Status> {
			return(this.http.post<Status>(this.favoriteUrl, favorite));
	}
	//call to the favorite API and edit the favorite
	editFavorite(favorite: Favorite) : Observable<Status> {
		return(this.http.put<Status>(this.favoriteUrl + favorite.favoriteProfileId, favorite));
	}
	//call to the favorite API and delete the favorite in question
	deleteFavorite(favoriteProfileId: string) : Observable<Status> {
		return(this.http.delete<Status>(this.favoriteUrl + favoriteProfileId));
	}

	// call to the favorite API and get an array of favorites based off the users profile id
	getFavoriteByFavoriteProfileId(favoriteProfileId: string) : Observable<Favorite[]> {
		return(this.http.get<Favorite[]>(this.favoriteUrl, {params: new HttpParams().set("favoriteProfileId", favoriteProfileId)}));
	}

}