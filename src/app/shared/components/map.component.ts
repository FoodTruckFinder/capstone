import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Status} from "../classes/status";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";
import "rxjs/add/operator/switchMap";
import 'rxjs/add/observable/of';
import {LocationService } from "../services/location.service";
import {Location } from "../interfaces/location";
import {Point} from "../classes/point";


@Component({
	template: require("./map.component.html"),
	selector: "map"
})

export class MapComponent implements OnInit {

	// empty array of lat/long points

	location:  = new Location(null, null, null, null, null, null);
	locations: Location[] = [];
	data: Observable<Array<Location[]>>;
	point: any;

	constructor(
		protected locationService : LocationService) {}

	ngOnInit() : void {
		this.listLocations();
	}

	listLocations() : any {
		//todo locationObserver does not currenty exist according to PHPStorm
		this.locationService.locationObserver
			.subscribe(locations => this.locations = locations);
	}

	clicked({target: marker} : any, location : Location) {
		this.location = marker;
		marker.nguiMapComponent.openInfoWindow('foodtruck-details', marker);
	}
	hideMarkerInfo() {
		this.point.display = !this.point.display;
	}

	displayLocation(location: Location) {
		this.location = location;
	}
}