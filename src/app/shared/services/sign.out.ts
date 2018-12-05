import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs/internal/Observable";

@Injectable()
export class SignOutService {

	constructor(protected http: HttpClient) {

	}

	private signOutUrl = "api/sign-out";

	getSignOut(): Observable<Status> {
		return(this.http.get<Status>(this.signOutUrl));
	}
}