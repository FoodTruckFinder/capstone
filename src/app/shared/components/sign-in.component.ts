import {Component, OnInit} from "@angular/core";
import { Router } from "@angular/router";
import {Status} from "../interfaces/status";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CookieService} from "ngx-cookie-service";
import {SessionService} from "../services/session.service";
import {SignIn} from "../interfaces/sign.in";
import {SignInService} from "../services/sign.in.service";

@Component({
	template: require("./sign-in.component.html"),
	selector: "sign-in"
})

export class SignInComponent implements OnInit {
	public isCollapsed = true;
	signInForm: FormGroup;
	status: Status = {status: null, message:null, type: null};

	constructor(
		private cookieService: CookieService,
		private sessionService: SessionService,
		private formBuilder: FormBuilder,
		private router: Router,
		private signInService: SignInService
	){}
	   //private router: Router (need to add)


	ngOnInit() {
		this.signInForm = this.formBuilder.group({
			profileEmail: ["", [Validators.required, Validators.email, Validators.minLength(2), Validators.maxLength(128), ]],
			profilePassword: ["", [Validators.required, Validators.minLength(8),Validators.maxLength(97)]]
		});
	}

	signIn() : void {
		let signIn: SignIn = {profileEmail: this.signInForm.value.profileEmail, profilePassword: this.signInForm.value.profilePassword};

		this.signInService.postSignIn(signIn)
			.subscribe(status => {
			this.status = status;
			if(status.status === 200) {
				this.sessionService.setSession();
				this.signInForm.reset();
				this.router.navigate([""]);
				location.reload();
				alert("Sign-in successful");

			} else {
				alert("Incorrect Email or Password. Try Again.")
			}
		});
	}

	signOut() :void {
		this.signInService.signOut();
	}
}