import {HttpClient, HttpParams} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/internal/Observable";
import {Profile} from "../interfaces/profile";

@Injectable()
export class ProfileService {
	constructor(protected http: HttpClient) {}

	// define an API endpoint
	private profileUrl = "api/profile";

	// reach out to the profile API and edit the profile in question
	editProfile(profile: Profile) : Observable<Status> {
		return(this.http.put<Status>(this.profileUrl , profile));
	}

	// call to the Profile API and get a Profile object by its id
	getProfileByProfileId(id: string) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl + id));
	}

	// call to the Profile API and get a Profile object by its email
	getProfileByProfileEmail(profileEmail: string) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl, {params: new HttpParams().set("profileEmail", profileEmail)}));
	}
}