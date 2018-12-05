<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<!-- CSS Files -->
		<link rel="stylesheet" type="text/css" href="index.css" media="screen">
		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:500|Nunito" rel="stylesheet">
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"  crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<!-- jQuery Form, Additional Methods, Validate -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
		<!-- Google reCAPTCHA -->
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<!-- Your JavaScript Form Validator -->
		<script src="js/form-validate.js"></script>
		<title>Food Truck Navbar</title>
	</head>
	<section>

		<!-- <?php require_once ("head-utils.php");?> <?php require_once ("sign-in-modal.php");?> -->

		<header>
			<div class="container-fluid">
				<nav class="navbar navbar-expand-xl navbar-expand-lg navbar-togglable fixed-top navbar-dark">
					<img src="../epic/505FTF-icon-v1.png" alt="foodTruckLogo" class="foodTruckLogo" width="150">
					<button class="navbar-toggler navbar-toggler-right navbar-dark" type="button" data-toggle="collapse"
							  data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
							  aria-label="Toggle Navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarCollapse">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a href="sign-up.php" class="nav-link">Sign up</a>
							</li>
							<li class="nav-item">
								<!-- link trigger modal -->
								<signIn></signIn>
							</li>
							<li class="nav-item">
								<a href="update-profile.php" class="nav-link">Update Profile</a>
							</li>
							<li class="nav-item">
								<a href="edit-create-food-truck.php" class="nav-link">Update FoodTruck</a>
							</li>
							<li class="nav-item">
								<a href="home-view.php" class="nav-link">Sign out</a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
</html>
