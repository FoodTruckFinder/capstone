<?php require_once ("head-utils.php");?>

<?php require_once ("sign-in-modal.php");?>

		<header>
			<div class="container-fluid p-0 black">
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
</php>
