import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {HttpClientModule} from "@angular/common/http";

import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import { NguiMapModule } from '@ngui/map';
import {ReactiveFormsModule} from "@angular/forms";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [
		BrowserModule,
		HttpClientModule,
		routing,
		NgbModule,
		ReactiveFormsModule,
		NguiMapModule.forRoot({apiUrl: 'https://maps.google.com/maps/api/js?key=AIzaSyCzkPjQz_zGaHXvnmEYO5u_g8LsKP7IxTA'}
	],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [...appRoutingProviders],
})
export class AppModule {}