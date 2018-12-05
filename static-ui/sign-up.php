<!-- toDO put in require_once for head_utils and other files as needed later-->
<link rel="stylesheet" type="text/css" href="css/style.css">

<body>
	<main>
		<div class="container text-center">
			<h1>Sign Up for Food  Truck Finder</h1>
		</div>

		<!--toDo put in code below that makes the customer sign-up appear if they clicked "sign up as customer" on modal popup on first time using app-->
		<ngb-tabset>
			<ngb-tab title="Customer Sign Up">
				<ng-template ngbTabContent>

					<form class="form-control-lg" id="form" action="" method="post">
						<div class="info">
							<input class="form-control" id="name" type="text" name="name" placeholder=" Name"/>
							<input class="form-control" id="email" type="email" name="email" placeholder=" Email Address"/>
							<input class="form-control" id="password" type="text" name="password" placeholder=" Password">
							<input class="form-control" id="password-confirm" type="text" name="password-confirm" placeholder=" Re-enter Password">
							<input class="btn" type="submit" value="Sign Up as Customer">
						</div>
					</form>

					<!--toDo add code that makes code below appear if they chose to sign up as food truck owner-->

				</ng-template>
			</ngb-tab>
			<ngb-tab>
				<ng-template ngbTabTitle><b>Food Truck Owner Signup</b></ng-template>
				<ng-template ngbTabContent>

					<form class="form-control-lg" id="form" action="" method="post">
						<div class="info">
							<input class="form-control" id="name" type="text" name="name" placeholder=" Name"/>
							<input class="form-control" id="email" type="email" name="email" placeholder=" Email Address"/>
							<input class="form-control" id="password" type="text" name="password" placeholder=" Password">
							<input class="form-control" id="password-confirm" type="text" name="password-confirm" placeholder=" Re-enter Password">
							<input class="btn" type="submit" value="Next">
						</div>
					</form>

					<!--toDo add code that makes the owner sign-up go to the next form (food truck edit/create)-->

				</ng-template>
			</ngb-tab>

		</ngb-tabset>

		</main>
	</body>