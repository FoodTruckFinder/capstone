import {RouterModule, Routes} from "@angular/router";
import {APP_BASE_HREF} from "@angular/common";
import {HomeViewComponent} from "./home-view/home-view.component";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {SignUpService} from "./shared/services/sign.up.service";
import {SignUpComponent} from "./sign-up/sign-up.component";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/sign.in.service";
import {SignInComponent} from "./shared/components/sign-in-modal.component";

export const allAppComponents = [HomeViewComponent, SignUpComponent, SignInComponent];

export const routes: Routes = [
	{path: "", component: HomeViewComponent}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
	SessionService,
	SignUpService,
	SignInService
];

export const routing = RouterModule.forRoot(routes);