import {Component, OnInit} from "@angular/core";
import {SignUp} from "../shared/interfaces/sign.up";
import {SignUpService} from "../shared/services/sign.up.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../shared/interfaces/status";

@Component({
	template: require("./sign-up.component.html")
})

export class SignUpComponent implements OnInit {
	signUpForm: FormGroup;
	status: Status = {status:null, message:null, type:null};

	constructor(private signUpService: SignUpService, private formBuilder: FormBuilder) {}

	ngOnInit() {

		this.signUpForm = this.formBuilder.group({
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
			profilePassword: ["", [Validators.maxLength(97), Validators.required]],
			profilePasswordConfirm: ["", [Validators.maxLength(97), Validators.required]],
			profileName: ["", [Validators.maxLength(32), Validators.required]]
		});

	}


	createSignUp() : void {
		let signUp: SignUp = {profileEmail: this.signUpForm.value.signUpEmail, profilePassword: this.signUpForm.value.signUpPassword, profilePasswordConfirm: this.signUpForm.value.signUpPasswordConfirm, profileName: this.signUpForm.value.signUpName};

		this.signUpService.createProfile(signUp).subscribe(status => {
			this.status = status;
			if(status.status === 200) {

			}
		})
	}
}