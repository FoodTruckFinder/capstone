import {RouterModule, Routes} from "@angular/router";
import {AuthGuardService as AuthGuard} from "./shared/services/auth-guard-service";

import {AuthService} from "./shared/services/auth.service";
import {AuthGuardService} from "./shared/services/auth-guard-service";

import {APP_BASE_HREF} from "@angular/common";
import {HomeViewComponent} from "./home-view/home-view.component";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {SignUpService} from "./shared/services/sign.up.service";
import {SignUpComponent} from "./sign-up/sign-up.component";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/sign.in.service";
import {SignInComponent} from "./shared/components/sign-in.component";
import {FoodTruckCardsComponent} from "./foodtruck/foodtruck.cards.component";
import {FoodTruckService} from "./shared/services/foodtruck.service";
import {FoodTruckCreateComponent} from "./update-food-truck/food-truck-create.component";
import {FoodTruckComponent} from "./foodtruck/foodtruck.component";
import {CookieService} from "ngx-cookie-service";


export const allAppComponents = [HomeViewComponent, SignUpComponent, SignInComponent, FoodTruckCardsComponent, FoodTruckCreateComponent, FoodTruckComponent];

export const routes: Routes = [
	{path: "foodTruck/:name", component: FoodTruckComponent},
	{path: "foodTrucks", component: FoodTruckCardsComponent},
	{path: "create-food-truck", component: FoodTruckCreateComponent},
	{path: "", component: HomeViewComponent}
];

const providers: any[] = [
	{provide:APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
	// Services is a way to connect to data: your own or external service (others' data). We only have one for this project. Typically one service per API. AJAX services.
];
const services: any[] = [AuthService, CookieService, FoodTruckService, SignInService, SignUpService, SessionService, AuthGuard];


export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);