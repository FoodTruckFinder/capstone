import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {FoodTruck} from "../shared/interfaces/foodtruck";
import {FoodTruckService} from "../shared/services/foodtruck.service";
import {Status} from "../shared/interfaces/status";
import {FileUploader} from 'ng2-file-upload';
import {Cookie} from 'ng2-cookies';
import {Observable} from 'rxjs';
import 'rxjs/add/observable/from';
import {ActivatedRoute, Router} from "@angular/router";

@Component({
	selector: "food-truck-create",
	template: require("./food-truck-create.template.html")
})

//took out on the onInit because Lost Paws only uses it in the edit ts
export class FoodTruckCreateComponent  {/*
	foodTruckForm: FormGroup;
	submitted: boolean = false;
	status: Status = {status: null, message: null, type: null};

	foodTruckId = this.route.snapshot.params["foodTruckId"];
	success: boolean = false;
	imageUploaded: boolean = false;

	public uploader: FileUploader = new FileUploader({
		//todo not sure what itemAlias is or how it should be named
		itemAlias: 'foodtruck',
		url: './api/image/',
		headers: [
			{name: 'X-JWT-TOKEN', value: window.localStorage.getItem('jwt-token')},
			{name: 'X-XSRF-TOKEN', value: Cookie.get('XSRF-TOKEN')}
		],
		additionalParameter: {}
	});

	cloudinarySecureUrl: string;
	//cloudinarySecureUrl2: string;
	cloudinaryPublicObservable: Observable<string> = new Observable<string>();


	constructor(protected foodTruckService: FoodTruckService,
					protected formBuilder: FormBuilder,
					protected route: ActivatedRoute,
					protected router: Router) {
		this.foodTruckForm = this.formBuilder.group({
			foodTruckName: ["", [Validators.maxLength(128), Validators.required]],
			foodTruckDescription: ["", [Validators.maxLength(256), Validators.required]],
			foodTruckPhoneNumber: ["", [Validators.maxLength(16), Validators.required]],
			foodTruckMenuUrl: ["", [Validators.maxLength(255), Validators.required]],
		});
}

uploadImage(): void {
	this.uploader.uploadAll();
	this.cloudinaryPublicObservable.subscribe(cloudinarySecureUrl => this.cloudinarySecureUrl = cloudinarySecureUrl);
	this.uploader.onSuccessItem = (item: any, response: string, status: number, headers: any) => {
		let reply = JSON.parse(response);
		this.cloudinarySecureUrl = reply.data;
		this.cloudinaryPublicObservable = Observable.from(this.cloudinarySecureUrl);
		if(this.cloudinarySecureUrl) {
			this.imageUploaded = true;
		}
	};
}

createFoodTruck(): FoodTruck {
	if(this.cloudinarySecureUrl) {
		return {
			foodTruckId: null,
			foodTruckProfileId: null,
			foodTruckDescription: this.foodTruckForm.value.foodTruckDescription,
			foodTruckImageUrl: this.cloudinarySecureUrl,
			foodTruckPhoneNumber: this.foodTruckForm.value.foodTruckPhoneNumber,
			foodTruckName: this.foodTruckForm.value.foodTruckName,
			foodTruckMenuUrl: this.foodTruckForm.value.foodTruckMenuUrl
		};


	}
}

postFoodTruck(): void {
	if(this.cloudinarySecureUrl) {
		this.submitted = true;

		this.createFoodTruck();
		let foodTruck : FoodTruck = this.createFoodTruck();
		if(foodTruck) {
			this.foodTruckService.createFoodTruck(foodTruck).subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.foodTruckForm.reset();
				}
			});
		}
	}
}
*/
}
