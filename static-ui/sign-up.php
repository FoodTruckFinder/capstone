<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
	</head>
	<body>
		<main>
			<ngb-tabset>
				<ngb-tab title="Customer Sign Up">
					<ng-template ngbTabContent>

						<!--insert form-->

					</ng-template>
				</ngb-tab>
				<ngb-tab>
					<ng-template ngbTabTitle><b>Food Truck Owner Signup</b></ng-template>
					<ng-template ngbTabContent>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.

						<!--insert form-->

					</ng-template>
				</ngb-tab>
			</ngb-tabset>
			<div class="container text-center">
				<h1>Sign Up for Food  Truck Finder</h1>
				<form class="form-control-lg" id="form" action="" method="post">
					<div class="info">
						<input class="form-control" id="name" type="text" name="name" placeholder=" User Name"/>
						<input class="form-control" id="email" type="email" name="email" placeholder=" Email"/>
						<input class="form-control" id="password" type="text" name="password" placeholder=" Password">
						<input class="form-control" id="password-confirm" type="text" name="password-confirm" placeholder=" Re-enter Password">
						<input class="btn" type="submit" value="Sign Up">
					</div>
				</form>
			</div>
		</main>
	</body>
</html>