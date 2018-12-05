import {HttpClient, HttpParams} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/internal/Observable";
import {Profile} from "../interfaces/profile";

@Injectable()
export class SignUpServices {
	constructor(protected http: HttpClient) {
	}
	private signUpUrl = "api/sign-up/";

	createProfile(signUp: SignUp) : Observable<Status> {
		return(this.http.post<Status>(this.signUpUrl, signUp));
	}
}
