import { Component } from '@angular/core';

@Component({
	selector: 'main-map',
	template: `		
    <ngui-map center="Albuquerque, New Mexico"
      (mapClick)="onClick($event)"
      [fullscreenControl]="true"
      [fullscreenControlOptions]="{position: 'TOP_RIGHT'}"></ngui-map>
    <ngui-map center="Albuquerque, New Mexico"
      [geoFallbackCenter]="[35.08, -106.64]"></ngui-map>

    `
})
export class AppComponent {

	onClick(event) {
		if (event instanceof MouseEvent)  {
			return false;
		}
		console.log('map is clicked', event, event.target);
	}
}