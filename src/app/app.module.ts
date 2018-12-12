// import angular dependencies
import {NgModule} from "@angular/core";
import {HttpClientModule} from "@angular/common/http";
import {BrowserModule} from "@angular/platform-browser";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {NguiMapModule} from '@ngui/map';
import {JwtModule} from "@auth0/angular-jwt";
import {CookieService} from "ngx-cookie-service";
import {FileSelectDirective} from "ng2-file-upload";
import {NgbCollapse} from "@ng-bootstrap/ng-bootstrap";


const moduleDeclarations = [AppComponent];

const JwtHelper = JwtModule.forRoot({
	config: {
		tokenGetter: () => {
			return localStorage.getItem("jwt-token");
		},
		skipWhenExpired: true,
		whitelistedDomains: ["localhost:7272", "https:bootcamp-coders.cnm.edu/"],
		headerName: "X-JWT-TOKEN",
		authScheme: ""
	}
});

@NgModule({
	imports:      [
		BrowserModule,
		HttpClientModule,
		routing,
		FormsModule,
		ReactiveFormsModule,
		NguiMapModule.forRoot({apiUrl: 'https://maps.google.com/maps/api/js?key=AIzaSyCzkPjQz_zGaHXvnmEYO5u_g8LsKP7IxTA'}),
		JwtHelper],
	declarations: [...moduleDeclarations, ...allAppComponents, FileSelectDirective, NgbCollapse],
	bootstrap:    [AppComponent],
	providers:    [...appRoutingProviders, CookieService],
})
export class AppModule {}