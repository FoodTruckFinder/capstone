import {Component} from "@angular/core";
import {SignInService} from "../services/sign.in.service";
//import {CookieService} from "ngx-cookie-service";
// import {Status} from "../classes/status";
import {Router} from "@angular/router";
// do we need sign out import as well?


@Component({
	template: require("./main-nav.component.html"),
	selector: "mainNav"
})

export class MainNavComponent {

	constructor(
		private signInService: SignInService,
//		private cookieService: CookieService,
		private router: Router
	) {}

	signOut() : void {
		this.signInService.signOut();

//			.subscribe(status => {
//				this.status = status;
//				if(status.status === 200) {

					//delete cookies and jwt
//					this.cookieService.deleteAll();
					localStorage.clear();

					//send user back home, refresh page
					this.router.navigate([""]);
					location.reload();
					console.log("goodbye");
				}
//			});
}