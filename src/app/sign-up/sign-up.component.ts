import {Component, OnInit} from "@angular/core";
import {SignUp} from "../shared/interfaces/sign.up";
import {SignUpService} from "../shared/services/sign.up.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../shared/interfaces/status";
import { Router } from "@angular/router";

@Component({
	template: require("./sign-up.component.html"),
	selector: "signup"

})

export class SignUpComponent implements OnInit {
	public isCollapsed = true;
	signUpForm: FormGroup;
	status: Status = {status:null, message:null, type:null};

	constructor(private signUpService: SignUpService, private formBuilder: FormBuilder, private router: Router,) {}

	ngOnInit() {

		this.signUpForm = this.formBuilder.group({
			profileEmail: ["", [Validators.required, Validators.maxLength(128), Validators.minLength(2), Validators.email]],
			profilePassword: ["", [Validators.required, Validators.minLength(8), Validators.maxLength(97) ]],
			profilePasswordConfirm: ["", [Validators.required, Validators.minLength(8), Validators.maxLength(97)]],
			profileName: ["", [Validators.required, Validators.maxLength(10), Validators.minLength(2)]]
		});

	}


	createSignUp() : void {
		let signUp: SignUp = {profileEmail: this.signUpForm.value.profileEmail, profilePassword: this.signUpForm.value.profilePassword, profilePasswordConfirm: this.signUpForm.value.profilePasswordConfirm, profileName: this.signUpForm.value.profileName};

		this.signUpService.createProfile(signUp).subscribe(status => {
			this.status = status;
			if(status.status === 200) {
				this.signUpForm.reset();
				this.router.navigate([""]);
				location.reload();
				alert("Sign-in successful! Please verify your email address to activate your account");

			}
		})
	}
}

