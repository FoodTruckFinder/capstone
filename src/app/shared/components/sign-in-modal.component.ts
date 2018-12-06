import {Component, ViewChild} from "@angular/core";

import {Router} from "@angular/router";
import {Status} from "../interfaces/status";
import {SignIn} from "../interfaces/sign.in";
import {SignInServices} from "../services/sign.in.services";
import {CookieService} from "ng2-cookies";

declare var $: any;

@Component({
	template: require("./sign.in.component.html"),
	selector: "signin"
})

export class SignInComponent {
	@ViewChild("signInForm") signInForm: any;

	signin: SignIn = {profileEmail: null, profilePassword: null};
	status: Status = {status: null, type: null, message};

	constructor(private SignInServices: SignInServices, private router: Router, private cookieService: CookieService) {

	}

	signIn(): void {
		localStorage.removeItem("jwt-token");
		this.SignInServices.postSignIn(this.signin).subscribe(status => {
			this.status = status;

			if(this.status.status === 200) {
				this.router.navigate(["/landing-page"]);

			} else {
				alert("Email or password is incorrect. Try again.")
			}
		});

	}

}