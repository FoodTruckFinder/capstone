import {Component} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {FoodTruck} from "../shared/interfaces/foodtruck";
import {FoodTruckService} from "../shared/services/foodtruck.service";
import {AuthService} from "../shared/services/auth.service";
import {Status} from "../shared/interfaces/status";
import {FileUploader} from 'ng2-file-upload';
import {Cookie} from 'ng2-cookies';
import {Observable} from 'rxjs';
import 'rxjs/add/observable/from';
import {ActivatedRoute, Router} from "@angular/router";

@Component({
	selector: "food-truck-post",
	template: require("./food-truck-create.template.html"),
	/*directives: [FILE_UPLOAD_DIRECTIVES, NgClass, NgStyle, CORE_DIRECTIVES, FORM_DIRECTIVES]*/
})
export class FoodTruckCreateComponent {
	foodTruckForm: FormGroup;
	submitted: boolean = false;
	status: Status = null;
	foodTruck: FoodTruck;

	foodTruckId = this.route.snapshot.params["foodTruckId"];
	success: boolean = false;
	imageUploaded: boolean = false;


	public uploader: FileUploader = new FileUploader(
		{
			itemAlias: 'foodTruck',
			url: './api/image/',
			headers: [
				{name: 'X-JWT-TOKEN', value: window.localStorage.getItem('jwt-token')},
				{name: 'X-XSRF-TOKEN', value: Cookie.get('XSRF-TOKEN')}
			],
			additionalParameter: {}
		}
	);

	cloudinarySecureUrl: string;
	cloudinaryPublicObservable: Observable<string> = new Observable<string>();

	constructor(protected authService: AuthService,
					protected foodTruckService: FoodTruckService,
					protected fb: FormBuilder,
					protected route: ActivatedRoute,
					protected router: Router) {
		this.foodTruckForm = this.fb.group({
			foodTruckName: ["", [Validators.required, Validators.maxLength(128)]],
			foodTruckPhoneNumber: ["", [Validators.maxLength(16)]],
			foodTruckDescription: ["", [Validators.maxLength(256)]],
		});
	}

	uploadImage(): void {
		this.uploader.uploadAll();
		this.cloudinaryPublicObservable.subscribe(cloudinarySecureUrl => this.cloudinarySecureUrl = cloudinarySecureUrl);
		this.uploader.onSuccessItem = (item: any, response: string, status: number, headers: any) => {
			let reply = JSON.parse(response);
			this.cloudinarySecureUrl = reply.data;
			this.cloudinaryPublicObservable = Observable.from(this.cloudinarySecureUrl);
			if (this.cloudinarySecureUrl) {
				this.imageUploaded = true;
			}
		};
	}

	getFoodTruckFromInput(): void {
		if (this.cloudinarySecureUrl) {
			this.foodTruck = {
				foodTruckId: null,
				foodTruckProfileId: null,
				//toDo below line might be messed up
				foodTruckPhoneNumber: this.foodTruckForm.value.phonenumber,
				foodTruckDescription: this.foodTruckForm.value.description,
				foodTruckImageUrl: this.cloudinarySecureUrl,
				foodTruckMenuUrl: this.cloudinarySecureUrl
			};
		}
	}

	postFoodTruck(): void {
		if (this.cloudinarySecureUrl) {
			this.submitted = true;
			this.getFoodTruckFromInput();
			if(this.foodTruck) {
				this.foodTruckService.createFoodTruck(this.foodTruck).subscribe(status => {
					this.status = status;
					if(this.status.status === 200) {
						this.foodTruckForm.reset();
					}
				});
			}
		}
	}
}