<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
	<?php $this->load->view('template/meta.php');  ?>
	<?php $this->load->view('template/css.php');  ?>
	<style>
		input.released_input {
			text-align: center;
			border-radius: 0 !important;
			border-left: none;
			border-right: none;
			border-top: none;
			border-bottom: 2px solid black;
		}

		input.released_input:focus {
			box-shadow: inset 0 0 0 black;
			;
		}

	</style>


	<style media="print">
		@page {
			size: auto;
			margin: 0;
		}

	</style>
</head>

<body>
	<?php $this->load->view('template/sidebar-left');  ?>
	<!-- Right Panel -->
	<div id="right-panel" class="right-panel">
		<?php $this->load->view('template/header');  ?>
		<div class="breadcrumbs">
			<div class="breadcrumbs-inner">
				<div class="row m-0">
					<div class="col-sm-4">
						<div class="page-header float-left">
							<div class="page-title">
								<h1><?php echo $page_title; ?></h1>
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="page-header float-right">
							<div class="page-title">
								<ol class="breadcrumb text-right">
									<li><a href="inventory">Dashboard</a></li>
									<li><a href="#"><?php echo $page_title; ?></a></li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content">
			<!-- Animated -->
			<div class="animated fadeIn">
				<?php echo $this->session->flashdata('message');?>
				<!-- /#event-modal -->
				<div class="card text-left">
					<div class="card-body">
						<div class="row justify-content-center">
							<div class="col-10">
								<div class="row mb-4 mt-3">
									<div class="col-4 text-right pr-0">
										<img src="<?php echo base_url() ?>images/is_icon.png" alt="Logo" width="80" height="80">
									</div>
									<div class="col-4 mt-3">
										<div class="text-center pl-0">
											<h5>Office of the City Mayor</h5>
											<h5 class="font-weight-bold" style="color:darkblue;">SUPPLIES REQUEST SLIP</h5>
											<h5>Oroquieta City</h5>
										</div>
									</div>
									<div class="col-3"></div>
								</div>
								<table class="table table-borderless table-sm table-responsive">
									<tr>
										<td scope="row">Requesting Office:</td>
										<td class="font-weight-bold text-capitalize"><?php echo $request['requesting_office'] ?></td>
									</tr>
									<tr>
										<td scope="row">Request Date:</td>
										<td class="font-weight-bold text-capitalize"><?php echo date('F d, Y h:i:s A', strtotime($request['request_date']))?></td>
									</tr>
								</table>
								<hr>
								<table class="table table-bordered table-striped table-sm mb-5">
									<thead style="background-color: #bdbebf;" class="text-center">
										<tr>
											<th>No.</th>
											<th>Particular/Item</th>
											<th>Unit</th>
											<th>Quantity</th>
										</tr>
									</thead>
									<tbody class="text-center">
										<?php if(!empty($request_items)){ 
                    $i = 1;  ?>
										<?php foreach($request_items as $key => $request_item){ ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $request_item['desc'].' '.$request_item['size'];?></td>
											<td><?php echo $request_item['unit'];?></td>
											<td><?php echo $request_item['r_quantity']?></td>
										</tr>
										<?php $i++; } } ?>
									</tbody>
								</table>
								<div class="row justify-content-end mt-5">
									<div class="col-6 text-right">
										<button type="button" onclick="jQuery('.card-body').print()" class="btn btn-outline-primary no-print"> <i class="fa fa-print" aria-hidden="true"></i> Print</button>
									</div>
								</div>
							</div> 
						</div> 
					</div>
				</div>
				<!-- /#add-category -->
			</div>
			<!-- .animated -->
		</div>
		<!-- /.content -->
		<div class="clearfix"></div>
		<!-- Footer -->
		<?php $this->load->view('template/footer'); ?>
		<!-- /.site-footer -->
	</div>
	<!-- /#right-panel -->

	<?php $this->load->view('template/js.php');  ?>

</body>

</html>
