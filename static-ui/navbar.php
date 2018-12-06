<?php require_once ("head-utils.php");?>

<?php require_once ("sign-in-modal.php");?>

		<header>
			<nav class="navbar navbar-expand-lg navbar-light border-bottom border-secondary shadow-sm bg-light fixed-top p-0" id="navigation-bar" >
				<button class="navbar-toggler navbar-toggler-right navbar-dark" type="button" data-toggle="collapse"
						  data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
						  aria-label="Toggle Navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<a class="navbar-brand text-secondary pl-3" href="#"></a>
				<img src="../epic/505FTF-icon-v1.png" alt="logo" class="nav-logo" width="100">

		<!-- <span href="home-view.php" class="navbar-brand text-center ml-3 name">FoodTruck Finder</span>  -->

					<div id="navigation-bar" class="collapse navbar-collapse">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a href="sign-up.php" class="nav-link">Sign up</a>
							</li>
							<li class="nav-item">
								<!-- link trigger modal -->
							</li>
							<li class="nav-item">
								<!-- link trigger modal -->
								<signIn></signIn>
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
