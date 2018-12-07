import {Component, ViewChild} from "@angular/core";
import {SignIn} from "../interfaces/sign.in";
import {SignInService} from "../services/sign.in.service";
import {Router} from "@angular/router";
import {Status} from "../interfaces/status";
import {FormGroup} from "@angular/forms";


@Component ({
	template: require("./sign-in-modal.component.html"),
	selector: "sign-in"
})

export class SignInComponent {
	@ViewChild("signInForm")

	signInForm: FormGroup;
	signin: SignIn = {profileEmail: null, profilePassword: null};
	status: Status = {status: null, type: null, message: null};

	constructor(
		private SignInService: SignInService,
		private router: Router,
	)	{}



	signIn(): void {
		localStorage.removeItem("jwt-token");
		this.SignInService.postSignIn(this.signin).subscribe(status => {
			this.status = status;

			console.log(status.status);

			if(this.status.status === 200) {
				this.router.navigate(["/profile"]);

			} else {
				alert("Email or password is incorrect. Please try again.")
			}
		});
	}
}