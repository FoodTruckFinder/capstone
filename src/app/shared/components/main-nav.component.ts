import {Component} from "@angular/core";
import {SignInService} from "../services/sign.in.service";
import {CookieService} from "ngx-cookie-service";
// import {Status} from "../../interfaces/status";
import {Router} from "@angular/router";
import {AuthService} from "../services/auth.service";

@Component({
	template: require("./main-nav.component.html"),
	selector: "mainNav"
})

export class MainNavComponent {

	constructor(
		private authService: AuthService,
		private signInService: SignInService,
		private cookieService: CookieService,
		private router: Router
	) {}

	isAuthenticated(): boolean {
		return(this.authService.isAuthenticated());
	}

	signOut() : void {
		this.signInService.signOut()
		// should this be getSignOut?

			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {

					//delete cookies and jwt
					this.cookieService.deleteAll();
					localStorage.clear();

					//send user back to home view, refresh page
					this.router.navigate(["signed-out"]);
					location.reload();
					console.log("goodbye");
				}
//			});
}