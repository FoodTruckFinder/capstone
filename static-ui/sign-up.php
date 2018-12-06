<?php require_once ("head-utils.php");?>

<?php require_once("navbar.php");?>

<main>
	<div class="col-6 offset-3 text-center mt-4 pt-4">
		<h1 class="header mt-4">Sign Up for <span class="text-warning">505</span> <span class="text-danger">FoodTruck Finder!</span></h1>
		<hr>
		<form id="sign-up-form" class="form-control-lg px-3"  action="" method="post">

			<div class="form-group">
				<p class="text-left py-2">Name: <span class="text-danger">*</span></p>
				<input class="form-control" id="name" type="text" name="profileName" placeholder=" User Name"/>
				<p class="text-left py-2">Email: <span class="text-danger">*</span></p>
				<input class="form-control" id="email" type="email" name="profileEmail" placeholder=" Email"/>
				<p class="text-left py-2">Password: <span class="text-danger">*</span></p>
				<input class="form-control" id="password" type="text" name="password" placeholder=" Password"/>
				<p class="text-left py-2">Password Confirm: <span class="text-danger">*</span></p>
				<input class="form-control py-2" id="password-confirm" type="text" name="password-confirm" placeholder=" Re-enter Password"/>
				<!--	<span class="text-left py-3">Are you a FoodTruck Owner? Click the button below for info on how to Sign up!</span>
					<input class="form-control text-left" id="isOwner" type="checkbox" name="isOwner" placeholder="Are you a Foodtruck Owner?"/> -->
				<br>
				<div class="list-group">
					<a class="p-2 btn-warning rounded font-weight-bold text-danger" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"> Foodtruck Owner? Click Here to Learn How to Register!</a>
					<div class="row">
						<div class="col">
							<div class="collapse multi-collapse" id="multiCollapseExample1">
								<div class="mt-4 card card-body text-left font-weight-bold bg-warning">
									<input class="form-control" id="business#" type="text" name="password" placeholder="Owner Name"/><input class="form-control" id="business#" type="text" name="password" placeholder="FoodTruck Name"/><input class="form-control" id="business#" type="text" name="password" placeholder="Phone #"/><input class="form-control" id="business#" type="text" name="business#" placeholder="Email"/>
									<span><span class="text-danger">Thank you</span> for your interest in registering as a Foodtruck vendor! We value your <span class="text-danger">business</span> and want to connect you with more <span class="text-danger">hungry customers!</span> Please fill out the form below and email a photo of your business license to <span class="text-danger">505FoodTruckFinder@gmail.com</span>! We will be in touch within 3-5 business days!</span>
								</div>
							</div>
						</div>
						<input class="btn-warning rounded font-weight-bold mt-4" type="submit" value="Sign Up!">
					</div>
				</div>
		</form>

<!--
		@import url("https://fonts.googleapis.com/css?family=Bungee|Fira+Sans");

		.header, span {
		font-family: 'Bungee', cursive;
		color: black;
		}
		p {
		font-family: 'Fira Sans', sans-serif;

		}

		span:nth-of-type(1n)
		{
		font-family: 'Bungee', cursive;
		}


		a {
		font-family: 'Bungee', cursive;
		font-size: 10pt;
		padding-right: 5px;
		padding-left: 5px;
		box-shadow: 5px 5px 5px black;

		}
		input:nth-of-type(n) {
		font-family: 'Bungee', cursive;
		}

		div:nth-of-type(6n) {
		font-family: 'Bungee', cursive;
		}

		end styling for the sign-up page
-->

</main>

