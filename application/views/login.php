<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo $page_title; ?></title>
	<!-- plugins:css -->

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/vendor.bundle.base.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/plugin/fontawesome/css/fontawesome-all.css">
	<!-- endinject -->
	<!-- plugin css for this page -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/majestic-style.css">
	<!-- endinject -->
	<link rel="shortcut icon" href='<?php echo base_url()?>images/is_icon.png'>
</head>

<body>
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
				<div class="row flex-grow">
					<div class="col-lg-6 d-flex align-items-center justify-content-center">
						<div class="auth-form-transparent text-left p-3">
							<div class="mb-3" >
								<img src="<?php echo base_url() ?>images/is_main.png" alt="" width="310" height="40";>
							</div>
							<h4>Welcome back!</h4>
							<h6 class="font-weight-light">Happy to see you again!</h6>
							<form class="pt-3" action="<?php echo base_url();?>login_submit" method="POST">
								<?php echo $this->session->flashdata('message'); ?>
								<div class="form-group">
									<label for="exampleInputEmail">Username</label>
									<div class="input-group">
										<div class="input-group-prepend bg-transparent">
											<span class="input-group-text bg-transparent border-right-0">
												<i class="fas fa-user text-primary"></i>
											</span>
										</div>
										<input type="text" name="username" value="<?php echo $this->session->flashdata('username'); ?>" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="Username">
									</div>
								</div>
								<div class="form-group">
									<label for="exampleInputPassword">Password</label>
									<div class="input-group">
										<div class="input-group-prepend bg-transparent">
											<span class="input-group-text bg-transparent border-right-0">
												<i class="fas fa-lock text-primary"></i>
											</span>
										</div>
										<input type="password" name="password" value="<?php echo $this->session->flashdata('password'); ?>" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Password">
									</div>
								</div>
								<div class="my-3">
									<button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">LOGIN</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-lg-6 login-half-bg d-flex flex-row  ">
						<!-- <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2018  All rights reserved.</p> -->
					</div>
				</div>
			</div>
			<!-- content-wrapper ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>
	<!-- container-scroller -->
	<!-- plugins:js -->
	<script src="<?php  echo base_url() ?>assets/js/vendor.bundle.base.js"></script>
	<!-- endinject -->
	<!-- inject:js -->
	<script src="<?php  echo base_url() ?>assets/js/js/off-canvas.js"></script>
	<script src="<?php  echo base_url() ?>assets/js/js/hoverable-collapse.js"></script>
	<script src="<?php  echo base_url() ?>assets/js/js/template.js"></script>
	<!-- endinject -->
</body>

</html>
