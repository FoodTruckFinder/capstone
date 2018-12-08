<?php require_once("head-utils.php"); ?>

<?php require_once("sign-in-modal.php"); ?>

<header>
	<nav class="navbar navbar-expand-lg navbar-dark border-bottom bg-light fixed-top p-0"
		  id="navigation-bar">
		<button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
				  data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
				  aria-label="Toggle Navigation">
			<span class="navbar-toggler-icon"></span>
			<span class="icon-bar top-bar"></span>
			<span class="icon-bar middle-bar"></span>Ω
			<span class="icon-bar bottom-bar"></span>
		</button>
		<a class="navbar-brand text-secondary pl-3" href="#">
			<!--todo replace our logo with FTF-logo-small.png-->
			<img src="../epic/505FTF-icon-v1.png" alt="logo" class="nav-logo" width="100">
		</a>

		<!-- <span href="home-view.php" class="navbar-brand text-center ml-3 name">FoodTruck Finder</span>  -->

		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="sign-up.php">Sign up</a>
				</li>
				<li class="nav-item">
					<!-- link trigger modal -->
					<!--<sign-in></sign-in>-->
					<a class="nav-link" href="#" data-target="#sign-in-modal" data-toggle="modal">Sign In</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="food-truck.php">FoodTruck Profiles</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="about.php">About Us</a>
				</li>
			</ul>
		</div>
	</nav>
	</div>
</header>
