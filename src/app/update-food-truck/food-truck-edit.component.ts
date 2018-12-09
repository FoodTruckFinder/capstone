import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {FoodTruck} from "../shared/interfaces/foodtruck";
import {FoodTruckService} from "../shared/services/foodtruck.service";
import {Status} from "../shared/interfaces/status";
import 'rxjs/add/observable/from';
import {ActivatedRoute, Router} from "@angular/router";

@Component({
	template: require("./food-truck-edit.template.html"),
	selector: "food-truck-edit"
})

export class UpdateFoodTruckComponent implements OnInit {
	foodTruckForm: FormGroup;
	submitted: boolean = false;
	status: Status = null;
	foodTruck: FoodTruck = {foodTruckId: null, foodTruckProfileId: null, foodTruckDescription: null, foodTruckImageUrl: null, foodTruckMenuUrl: null, foodTruckName: null, foodTruckPhoneNumber: null};
	foodTruckId = this.route.snapshot.params["foodTruckId"];
	success: boolean = false;

	constructor(protected foodTruckService: FoodTruckService,
					private formBuilder: FormBuilder,
					protected route: ActivatedRoute,
					protected router: Router) {
		this.foodTruckForm = this.formBuilder.group({
			foodTruckName: ["", [Validators.maxLength(128), Validators.required]],
			foodTruckDescription: ["", [Validators.maxLength(256), Validators.required]],
			foodTruckPhoneNumber: ["", [Validators.maxLength(16), Validators.required]],
			foodTruckImageUrl: ["", [Validators.maxLength(255), Validators.required]],
			foodTruckMenuUrl: ["", [Validators.maxLength(255), Validators.required]]
		});
	}

	ngOnInit(){
		this.applyFormChanges();
		this.loadFoodTruckValues();
	}

	applyFormChanges(): void {
		this.foodTruckForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.foodTruck[field] = values[field];
			}
		});
	}

	loadFoodTruckValues() {
		this.foodTruckService.getFoodTruckByFoodTruckId(this.foodTruckId).subscribe(foodTruck => {
			this.foodTruck = foodTruck;
			this.foodTruckForm.patchValue(foodTruck);
		});
	}

	editFoodTruck() {
		this.foodTruckService.editFoodTruck(this.foodTruck).subscribe(status => {
			this.status = status;
		});
		this.foodTruckForm.reset();
		if(this.status.status === 200) {
			this.success = true;
			// this.router.navigate(["foodTruck/:foodTruckId"]);
		}
	}
}

