import {Component, OnInit} from "@angular/core";
import {FoodTruck} from "../shared/interfaces/foodtruck";
import {FoodTruckService} from "../shared/services/foodtruck.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../shared/interfaces/status";

@Component({
	template: require("./food-truck-create.component.html"),
	selector: "foodtruck"
	
})

export class FoodTruckCreateComponent implements OnInit {
	foodTruckForm: FormGroup;
	status: Status = {status:null, message:null, type:null};

	constructor(private foodTruckService: FoodTruckService, private formBuilder: FormBuilder) {}

	ngOnInit() {

		this.foodTruckForm = this.formBuilder.group({
			foodTruckName: ["", [Validators.maxLength(128), Validators.required]],
			foodTruckDescription: ["", [Validators.maxLength(256), Validators.required]],
			foodTruckPhoneNumber: ["", [Validators.maxLength(16), Validators.required]],
			foodTruckImageUrl: ["", [Validators.maxLength(255), Validators.required]],
			foodTruckMenuUrl: ["", [Validators.maxLength(255), Validators.required]],
		});
	}

	createFoodTruck() : void {
		let foodTruck: FoodTruck = {foodTruckName: this.foodTruckForm.value.foodTruckName, foodTruckDescription: this.foodTruckForm.value.foodTruckDescription, foodTruckPhoneNumber: this.foodTruckForm.value.foodTruckPhoneNumber, foodTruckImageUrl: this.foodTruckForm.value.foodTruckImageUrl, foodTruckMenuUrl: this.foodTruckForm.value.foodTruckMenuUrl};

		this.foodTruckForm.postFoodTruck(foodTruck).subscribe(status => {
			this.status = status;
			if(status.status === 200) {

			}
		})
	}
}