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
					<form class="form-horizontal" action="<?php echo base_url().'delivery/submit_edit_delivery_item/'.$delivery['delivery_no'];?>" method="POST">
						<div class="card-body">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Item Description</th>
										<th>Size</th>
										<th>Units</th>
										<th>Stock/Limit</th>
										<th>Quantity</th>
										<th>Category</th>
										<th class="text-center p-0 m-0"> 
                      <table class="table-borderless">
                        <tr>
                          <td><button type="button" class="btn btn-primary btn-sm add_row" id="1"><i class="fas fa-plus"></i></button></td>
                          <td><button type="button" class="btn btn-success btn-sm add_row" id="2"><i class="fas fa-plus"></i> New Item</button></td>
                        </tr>
                      </table> 
                    </th>

									</tr>
								</thead>
								<tbody id="delivery_table">
									<?php 
                  $count = 1;
                  foreach($delivery_items as $dev_items){
                    echo '
                      <tr id="row_id_'.$count.'">
                        <td class="count">'.$count.'</td>
                        <td><input class="form-control" name="item[]" type="hidden" value='.$dev_items['item_no'].'><input class="form-control item" name="description[]" type="text" value='.$dev_items['description'].'></td>';
                    echo '<td><input class="form-control size" name="size[]" type="text" value='.$dev_items['size'].'></td>
						<td><input class="form-control unit" name="unit[]" type="text" value='.$dev_items['unit'].'></td>
						<td>
							<input type="number" class="stock_quantity form-control" name="limit_quantity[]" value='.$dev_items['limit_quantity'].'>
						</td>
						<td><input min="1" type="number" class="form-control" name="quantity[]" value='.$dev_items['qty'].'></td>';

                    echo  '<td>
                          <select  data-row="row_id_'.$count.'"  class="form-control cat" name="category_id[]">
                            <option value="">Choose Category</option>
                    ';
                        foreach($category as $key => $ctgry){
                          $selected = $ctgry['category_id'] == $dev_items['category_id'] ? 'selected' : ''; 
                          echo '
                            <option value="'.$ctgry['category_id'].'" '.$selected.'>'.$ctgry['category'].'</option>';
                        }
                    echo '  
                            <option value="null">No Category</option>
                          </select>
                        </td>
                        <td>
                          <button type="button" name="remove_row" id="'.$count.'" class="btn btn-sm btn-danger btn-xs remove_row">
                            <i class="fas fa-minus"></i>
                          </button>
                        </td> 
                      </tr>
                    ';
                    $count++;
                  }
                  ?> 
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

		var count = parseInt('<?php echo $count; ?>')-1;
		$(document).on('click', 'button.add_row', function () {
      var btn = $(this).attr('id');
			count += 1;
      var html_code = '';

      if(btn == '1'){

        html_code += '<tr id="row_id_' + count + '">';
        html_code += "<td>" + count + "</td>";

        html_code += `<td>
                        <select data-row="row_id_` + count + `" class="form-control item" name="item[]" required="">
                          <option value="">Choose Item</option>
                        <?php if(!empty($items)){ 
                            foreach($items as $key => $item){
                        ?>
                            <option data-item-unit="<?php echo $item['unit']; ?>" data-stock-quantity="<?php echo $item['quantity']; ?>" data-item-size="<?php echo $item['size']; ?>"  value="<?php echo $item['item_no']?>"><?php echo $item['description'] . ' ' . $item['size']?></option>
                          <?php } } ?>
                        </select>
                      </td>`;
        html_code += '<td><input type="hidden" name="description[]"><input readonly class="form-control size" name="size[]" type="text"></td>';
        html_code += '<td><input readonly class="form-control unit" name="unit[]" type="text"></td>';
        html_code += '<td><input type="text" class="stock_quantity form-control" name="limit_quantity[]" readonly></td>';
        html_code += '<td><input min="1" type="number" class="form-control" name="quantity[]" required="" placeholder="Quantity"> </td>';
        html_code += `<td>
                        <select  data-row="row_id_` + count + `" name="category_id[]" class="form-control category">
                          <option value="">Choose Category</option>
                        <?php if(!empty($category)){ 
                            foreach($category as $key => $ctgry){
                        ?>
                          <option value="<?php echo $ctgry['category_id']?>"><?php echo $ctgry['category']?></option>
                        <?php } } ?>
                          <option value="null">No Category</option>
                        </select>
                      </td>`;
        html_code += '<td><button type="button" name="remove_row" id="' + count + '" class="btn btn-sm btn-danger btn-xs remove_row"><i class="fas fa-minus"></i></button></td></tr>';
      
      }else{

        html_code += '<tr id="row_id_' + count + '">';
        html_code += "<td>" + count + "</td>";

        html_code += '<td><input type="text" name="item[]" class="form-control" placeholder="Enter Item"><input type="hidden" name="description[]"></td>';
        html_code += '<td><input type="text" name="size[]" class="form-control" placeholder="Enter Size"></td>';
        html_code += '<td><input type="text" name="unit[]" class="form-control" placeholder="Enter Units"></td>';
        html_code += '<td><input type="number" name="limit_quantity[]" class="form-control" placeholder="Enter Limits"></td>';
        html_code += '<td><input type="number" name="quantity[]" class="form-control" placeholder="Enter Quantity"></td>';
        html_code += `<td>
                        <select  data-row="row_id_` + count + `"  name="category_id[]" class="form-control category ">
                          <option value="">Choose Category</option>
                        <?php if(!empty($category)){ 
                            foreach($category as $key => $ctgry){
                        ?>
                          <option value="<?php echo $ctgry['category_id']?>"><?php echo $ctgry['category']?></option>
                        <?php } } ?>
                          <option value="null">No Category</option>
                        </select>
                      </td>`;
        html_code += '<td><button type="button" name="remove_row" id="' + count + '" class="btn btn-sm btn-danger btn-xs remove_row"><i class="fas fa-minus"></i></button></td></tr>';
      }
		

			$("#delivery_table").append(html_code);

    });
  
		$(document).on('click', 'button.remove_row', function () {
			var id = $(this).attr('id');
			$('#row_id_' + id).remove();
			count -= 1;
		});

		$(document).on('change', 'select.item', function () {
			var stock_qty = $(this).find(':selected').data('stock-quantity');
			var unit      = $(this).find(':selected').data('item-unit');
			var size      = $(this).find(':selected').data('item-size');
			var row       = $(this).data('row');
			$('tr#' + row + '>td>input.stock_quantity').val(stock_qty)
			$('tr#' + row + '>td>input.unit').val(unit)
			$('tr#' + row + '>td>input.size').val(size) 
		});
	</script>
</body>

</html>
