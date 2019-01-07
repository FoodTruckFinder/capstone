import {Component, OnInit} from "@angular/core";
import {PostLocation} from "../../shared/interfaces/postlocation";
import {LocationService} from "../services/location.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../../shared/interfaces/status";
import { Router } from "@angular/router";

@Component({
	template: require("./postLocation.component.html"),
	selector: "postlocation"

})

export class PostLocationComponent implements OnInit {

	public isCollapsed = true;

	postLocationForm: FormGroup;

	status: Status = {status:null, message:null, type:null};

	constructor(private locationService: LocationService, private formBuilder: FormBuilder, private router: Router) {}

	ngOnInit() {

		this.postLocationForm = this.formBuilder.group({

			locationFoodTruckId: ["", [Validators.required]],
			locationEndTime: [""],
			locationLatitude: ["", [Validators.required]],
			locationLongitude: ["", [Validators.required]],
			locationStartTime: [""],

		});
	}


	postLocation() : void {
		let postLocation: PostLocation = {locationFoodTruckId: this.postLocationForm.value.locationFoodTruckId, locationEndTime: this.postLocationForm.value.locationEndTime, locationLatitude: this.postLocationForm.value.locationLatitude, locationLongitude: this.postLocationForm.value.locationLongitude, locationStartTime: this.postLocationForm.value.locationStartTime};

		this.locationService.createLocation(postLocation).subscribe(status => {
			this.status = status;
			if(status.status === 200) {
				this.postLocationForm.reset();
				this.router.navigate([""]);
				location.reload();
				alert("Location successfully posted! Go to the main page to see your foodtruck marker live!");

			}
		})
	}
}

