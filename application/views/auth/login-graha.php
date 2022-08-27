<html>

<head>
	<title>Graha Bangunan | LOGIN</title>
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/mycss.css">
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/bootstrap.css">
	<link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
	<link href="<?= base_url('assets/img/logo.png'); ?>" rel="icon">

</head>

<body>
	<div class="signin">
		<div class="back-img">
			<div class="sign-in-text">
				<h2 class="active">Graha</h2>
				<h2 class="nonactive">Bangunan</h2>
			</div>
			<!--/.sign-in-text-->
			<div class="layer">
			</div>
			<!--/.layer-->
			<!-- <p class="point">&#9650;</p> -->
		</div>
		<!--/.back-img-->

		<?= $this->session->flashdata('message'); ?>
		<div class="form-section">
            <form class="user" method="post" action="<?= base_url('auth'); ?>">
				<!--Email-->
				<label class="mdl-textfield__label" for="sample3">Username</label>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-group">
					<input class="form-control" type="text" id="email" name="email" placeholder="Username">
				
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
				<!--Password-->
				<label class="mdl-textfield__label" for="sample3">Password</label>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-group">
					<input class="form-control" type="password" id="password" name="password" placeholder="Password">
				
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
				<br />
				<!--CheckBox-->
				<button class="btn btn-primary btn-lg">
					Sign In
				</button>
			</form>
		<!--/.form-section-->

		<!--/button-->
	</div>
	<!--/.signin-->
</body>

</html>