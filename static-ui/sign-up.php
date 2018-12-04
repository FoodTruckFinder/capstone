<!-- toDO put in require_once for head_utils and other files as needed later-->


<body>
	<main>
		<div class="container text-center">
			<h1>Sign Up for Food  Truck Finder</h1>
		</div>

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

					<!--toDo add code that marks this sign up as being from a customer-->

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
							<input class="btn" type="submit" value="Sign Up as Food Truck Owner">
						</div>
					</form>

					<!--toDo add code that marks this sign up as being from an owner, not a customer-->

				</ng-template>
			</ngb-tab>

		</ngb-tabset>

		</main>
	</body>