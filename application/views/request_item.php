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
				<div class="card">
					<form class="form-horizontal" action="<?php echo base_url();?>request/submit_item_request" method="POST">
						<div class="card-body">
							<div class="row">
								<div class="col-8">
									<div class="row form-group">
										<div class="col-md-4"><label class="form-control-label">Requesting Office:</label></div>
										<div class="col-md-7 ">
											<input type="text" class="form-control" required="" name="req_office" placeholder="Enter office name">
										</div>
									</div>
								</div>
							</div>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Category</th>
										<th>Item Description</th>
										<th>Available Stock</th>
										<th>Quantity</th>
										<th class="text-center"><button type="button" class="btn btn-primary btn-sm" id="add_row"><i class="fas fa-plus"></i></button></th>
									</tr>
								</thead>
								<tbody id="request_table">
									<tr id="row_id_1">
										<td>1</td>
										<td>
											<select  data-row="row_id_1"  class="form-control category">
												<option value="">Choose Category</option>
												<?php if(!empty($category)){ 
                          foreach($category as $key => $ctgry){
                      ?>
												<option value="<?php echo $ctgry['category_id']?>"><?php echo $ctgry['category']?></option>
												<?php } } ?>
												<option value="null">No Category</option>
											</select>
										</td>
										<td>
											<select data-row="row_id_1"  class="form-control item" name="item[]" required="">
												<option value="">Choose Item</option>
												<?php if(!empty($items)){ 
                          foreach($items as $key => $item){
                      ?>
												<option data-item-unit="<?php echo $item['unit']; ?>" data-stock-quantity="<?php echo $item['quantity']; ?>" value="<?php echo $item['item_no']?>"><?php echo $item['description'] . ' ' . $item['size']?></option>
												<?php } } ?>
											</select>
										</td>
										
										<td>
											<input type="text" class="stock_quantity form-control" readonly>
										</td>
										<td><input min="1" type="number" class="form-control" name="quantity[]" required="" placeholder="Enter quantity"> </td>
									</tr>
								</tbody>
							</table>
							<div class="text-right">
								<button class="btn btn-secondary">Reset</button>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</div>

					</form>
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
	<script>
		var count = 1;
		$(document).on('click', 'button#add_row', function () {
			count += 1;
			var html_code = '';
			html_code += '<tr id="row_id_' + count + '">';
			html_code += "<td>" + count + "</td>";
			html_code += `<td><select  data-row="row_id_`+count+`"  class="form-control category ">
                      <option>Choose Category</option>
                      <?php if(!empty($category)){ 
                          foreach($category as $key => $ctgry){
                      ?>
                      <option value="<?php echo $ctgry['category_id']?>"><?php echo $ctgry['category']?></option>
                      <?php } } ?>
											<option value="null">No Category</option>
                      </td>`;
			html_code += `<td><select data-row="row_id_`+count+`" class="form-control item" name="item[]" required="">
                      <option value="">Choose Item</option>
                      <?php if(!empty($items)){ 
                          foreach($items as $key => $item){
                      ?>
                      <option data-item-unit="<?php echo $item['unit']; ?>" data-stock-quantity="<?php echo $item['quantity']; ?>"  value="<?php echo $item['item_no']?>"><?php echo $item['description'] . ' ' . $item['size']?></option>
                        <?php } } ?>
										</select></td>`;
			html_code += '<td><input type="text" class="stock_quantity form-control" readonly></td>';
			html_code += '<td><input required="" type="number" name="quantity[]" placeholder="Enter quantity" min="0" class="form-control form-control-sm input-sm buy_price"></td>';
			html_code += '<td><button type="button" name="remove_row" id="' + count + '" class="btn btn-sm btn-danger btn-xs remove_row"><i class="fas fa-minus"></i></button></td></tr>';
			$("#request_table").append(html_code);

		});

		$(document).on('click', 'button.remove_row', function () {
			var id = $(this).attr('id');
			$('#row_id_' + id).remove();
			count -= 1;
		});

		$(document).on('change', 'select.item', function () {
			var stock_qty = $(this).find(':selected').data('stock-quantity');
			var  unit = $(this).find(':selected').data('item-unit');
      var row = $(this).data('row'); 
			// console.info(stock_qty);
			$('tr#' + row + '>td>input.stock_quantity').val(stock_qty + " " + unit)  
			$('tr#' + row + '>td>input[name="quantity[]"]').attr('max', stock_qty); 
		});
		

	</script>
</body>

</html>
