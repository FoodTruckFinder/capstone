
<?php require_once("navbar.php"); ?>
<!--bootstrap CSS-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<!--Bootstrap JS-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!--Google Script-->
<script src="https://apis.google.com/js/platform.js" async defer></script>

<!--font awesome-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<!--custom JavaScript-->



<title>505 Food Truck Finder</title>
<main>
	<div class="col-6 offset-3 text-center">
		<h1 class="header mt-4">Sign in </h1>
		<form id="sign-in-form" class="form-control-lg px-3"  action="" method="post">
			<hr>
			<div class="form-group">
				<p class="text-left pt-2">Name: <span class="text-danger">*</span></p>
				<input class="form-control" id="name" type="text" name="profileName" placeholder="Name"/>
				<p class="text-left pt-2">Email: <span class="text-danger">*</span></p>
				<input class="form-control" id="email" type="email" name="profileEmail" placeholder=" Email"/>
				<p class="text-left pt-2">Password: <span class="text-danger">*</span></p>
				<input class="form-control" id="password" type="text" name="password" placeholder=" Password"/>
				<br>
				<a class="btn-warning rounded font-weight-bold text-danger" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"> Foodtruck Owner? Click Here to Learn How to Register!</a>
				<div class="row">
					<div class="col">
						<div class="collapse multi-collapse" id="multiCollapseExample1">
							<div class=" mt-4 card card-body text-left font-weight-bold bg-warning"><span><span class="text-danger">Thank you</span> for your interest in registering as a Foodtruck vendor! We value your <span class="text-danger">business</span> and want to connect you with more <span class="text-danger">hungry customers!</span> Please fill out the form below and email a photo of your business license to <span class="text-danger">505FoodTruckFinder@gmail.com</span>! We will be in touch within 3-5 business days!</span>
							</div>
						</div>
					</div>
					<input class="btn-warning mt-4 rounded font-weight-bold" type="submit" value="Sign in">
				</div>
		</form>
	</div>


</main>



