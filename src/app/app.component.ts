import {Component, enableProdMode} from "@angular/core";
import {SessionService} from "./shared/services/session.service";
import {Status} from "./shared/interfaces/status";
enableProdMode();

@Component({
	selector: "food-truck-finder",
	template: require("./app.component.html"),
})

export class AppComponent {

	status : Status = {status: null, type: null, message: null};

	constructor(private sessionService : SessionService) {
		this.sessionService.setSession().subscribe(status => this.status = status)
	}
}