<?php require_once("head-utils.php"); ?>

<?php require_once("navbar.php"); ?>

<main class="Home">
	<div class="container-fluid p-5">
		<div class="container-fluid p-2" id="map">
			<div class="row">
				<div class="col-12 col-md-3 card">
					<div class="card-block">
						<h4 class="card-title">Find Food Truck Finder!</h4></div>
					<form id="form" action="">
						<p>
							<input id="distance" type="number" name="distance" placeholder="miles from you"/>
						</p>
						<p>
							<input id="type" type="text" name="type" placeholder="type of art"/>
						</p>
						<input class="btn" type="submit" value="Search">
					</form>
					<ul class="list-group list-group-flush">
						<li class="list-group-item"><a href="#" class="card-link">FoodTruck One</a></li>
						<li class="list-group-item"><a href="#" class="card-link">FoodTruck Two</a></li>
						<li class="list-group-item"><a href="#" class="card-link">FoodTruck Three</a></li>
						<li class="list-group-item"><a href="#" class="card-link">FoodTruck Three</a></li>
						<li class="list-group-item"><a href="#" class="card-link">FoodTruck Four</a></li>
					</ul>
				</div>
				<div class="col-12 col-md-8 p-3">
					<img class="img-fluid" src="../src/img/abqMapPlaceholder.png" alt="map">
				</div>
			</div>
		</div>
		<div class="container-fluid p-2">
			<h1>Featured Art</h1>
			<div class="row">
				<div class="container-fluid col-12 col-sm-6 col-md-3 p-2">
					<div class="card">
						<img class="card-img-top" src="../src/img.foodTruckPlaceholder.jpg" alt="Card image cap">
						<div class="card-block">
							<h4 class="card-title">Card title</h4>
						</div>
					</div>
				</div>
				<div class="container-fluid col-12 col-sm-6 col-md-3 p-2">
					<div class="card">
						<img class="card-img-top" src="../src/img.foodTruckPlaceholder.jpg" alt="Card image cap">
						<div class="card-block">
							<h4 class="card-title">Card title</h4>
						</div>
					</div>
				</div>
				<div class="container-fluid col-12 col-sm-6 col-md-3 p-2">
					<div class=" card">
						<img class="card-img-top" src="../src/img.foodTruckPlaceholder.jpg" alt="Card image cap">
						<div class="card-block">
							<h4 class="card-title">Card title</h4>
						</div>
					</div>
				</div>
				<div class="container col-12 col-sm-6 col-md-3 p-2">
					<div class="card">
						<img class="card-img-top" src="../src/img.foodTruckPlaceholder.jpg" alt="Card image cap">
						<div class="card-block">
							<h4 class="card-title">Card title</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>