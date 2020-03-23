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
          <div class="text-right mt-3 mr-4">
          <!-- Button trigger modal -->
          <a href="<?php echo base_url();?>request/request_item" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Request Item
          </a>
          </div>
          <div class="card-body">
          <table class="table-sm table table-bordered" id="item_table">
          <thead>
            <tr>
              <th>Requesting Office</th>
              <th>Status</th>
							<th>Request Date</th>
							<th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($requests)){ ?>
              <?php foreach($requests as $key => $request){ ?> 
							<?php 
								$text_color= '';
								if($request['status'] == 'Pending'){
									$text_color = 'text-danger';
								}	else if($request['status'] == 'Approved'){
									$text_color = 'text-primary'; 
								}else{
									$text_color = 'text-success'; 
								}
							?>
                <tr> 
                  <td><?php echo $request['requesting_office'];?></td>
                  <td class="font-weight-bold <?php echo $text_color; ?>"><?php echo $request['status'];?></td>
                  <td><?php echo date('F m, Y h:i a', strtotime($request['request_date']));?></td> 
                  <td>
									<ul class="nav navbar-right panel_toolbox"> 
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-cog"></i></a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"">
													<a href="<?php echo base_url().'request/released_info/'. $request['request_id'] ?>" class="dropdown-item text-success" title="Release Items"><i class="fa fa-arrow-right"></i> Release</a>
                          <a href="<?php echo base_url().'request/view_item/'. $request['request_id'] ?>" class="dropdown-item text-primary"   title="View Request"><i class="fa fa-eye"></i> View</a>
                          <a href="<?php echo base_url().'request/edit_request_item/'. $request['request_id'] ?>" class="dropdown-item text-warning" title="Edit Request"><i class="fa fa-edit"></i> Edit</a>
                          <a href="<?php echo base_url().'request/delete_request/'.$request['request_id'];?>" onclick="return confirm('Are you sure you want to delete this user?')"  class="dropdown-item text-danger"   title="Delete Request"><i class="fa fa-trash"></i> Delete</a>
                           
                        </div>
                    </li> 
                    </li>
                  </ul> 
									</td>
                </tr>
            <?php } } ?>
          </tbody>
        </table>
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
