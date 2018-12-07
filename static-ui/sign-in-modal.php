<?php require_once("head-utils.php"); ?>
<?php require_once("navbar.php"); ?>

<main>
	<!-- Modal -->
	<body class="modal-open">
	<div class="modal fade" id="sign-in" tabindex="-1" role="dialog" aria-labelledby="sign-in-modal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row ml-auto"
					<h5 class="modal-title pl-3" id="signIn">Sign In</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-control-lg" id="sign-in-form" action="" method="post">
						<div class="info">
							<input class="form-control" id="email" type="email" name="email" placeholder=" Email"/>
							<input class="form-control" id="password" type="text" name="password" placeholder=" Password">
						</div>
					</form>
					<div class="modal-footer">
						<input class="btn" type="submit" value="Sign In!">
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
</main>