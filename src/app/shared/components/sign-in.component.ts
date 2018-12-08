import {Component, OnInit} from "@angular/core";
import {SignIn} from "../interfaces/sign.in";
import {SignInService} from "../services/sign.in.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../interfaces/status";

@Component({
	template: require("./sign-in.component.html"),
	selector: "signin"
})

export class SignInComponent implements OnInit {
	signInForm: FormGroup;
	status: Status = {status: null, message:null, type: null};

	constructor(private signInService: SignInService, private formBuilder: FormBuilder) {}

	ngOnInit() {
		this.signInForm = this.formBuilder.group({
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
			profilePassword: ["", [Validators.maxLength(97), Validators.required]]
		});
	}

	signIn() : void {
		let signIn: SignIn = {profileEmail: this.signInForm.value.profileEmail, profilePassword: this.signInForm.value.profilePassword};

		this.signInService.postSignIn(signIn).subscribe(status => {
			this.status = status;
			if(status.status === 200) {

			} else {
				alert("Incorrect Email or Password. Try Again.")
			}
		})
	}
}