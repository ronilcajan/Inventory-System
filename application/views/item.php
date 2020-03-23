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
          <a href="<?php echo base_url();?>add_item" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Add Item
          </a>
          </div>
          <div class="card-body">
          <table class="table table-bordered" id="item_table">
          <thead>
            <tr>
							<th>Description</th>
							<th>Size</th>
              <th>Quantity</th>
              <th>Unit</th>
							<th>Limit Quantity</th>
							<th>Category</th>
							<th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($items)){ ?>
              <?php foreach($items as $key => $itm){ ?> 
                <tr>
									<td><?php echo $itm['description'];?></td>
									<td><?php echo $itm['size'];?></td>
                  <td><?php echo $itm['quantity'];?></td>
									<td><?php echo $itm['unit'];?></td>
									<td><?php echo $itm['limit_quantity'];?></td>
									<td><?php if(empty($itm['category'])){ echo 'No category';}else{ echo $itm['category'];}?></td>
                  <td>
                    <a href="<?php echo base_url().'item/edit_item/'. $itm['item_no'] ?>" class="text-info edit-category"><i class="fa fa-edit"></i></a> |  
                    <a href="<?php echo base_url().'item/delete_item/'.$itm['item_no'];?>" onclick="return confirm('Are you sure you want to delete this item?')" class="text-danger"><i class="fa fa-trash"></i></a>
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
