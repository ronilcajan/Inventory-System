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
					<form class="form-horizontal" action="<?php echo base_url() . 'request/update_request_item/' . $request['request_id'] ?>" method="POST">
						<div class="card-body">
							<div class="row">
								<div class="col-8">
									<div class="row form-group">
										<div class="col-md-4"><label class="form-control-label">Requesting Office:</label></div>
										<div class="col-md-7 ">
											<input type="text" class="form-control" required="" name="req_office" placeholder="Enter office name" value="<?php echo $request['requesting_office'];?>">
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
										<th>Quantity</th>
										<th class="text-center"><button type="button" class="btn btn-primary btn-sm" id="add_row"><i class="fas fa-plus"></i></button></th>
									</tr>
								</thead>
								<tbody id="request_table">
                  <?php 
                  $count = 1;
                  foreach($request_items as $request_item){
                    echo '
                      <tr id="row_id_'.$count.'">
                        <td>'.$count.'</td>
                        <td>
                          <select  data-row="row_id_'.$count.'"  class="form-control cat">
                            <option value="">Choose Category</option>
                    ';
                        foreach($category as $key => $ctgry){
                          $selected = $ctgry['category_id'] == $request_item['category_id'] ? 'selected' : ''; 
                          echo '
                            <option value="'.$ctgry['category_id'].'" '.$selected.'>'.$ctgry['category'].'</option>';
                        }
                    echo '  
                            <option value="null">No Category</option>
                          </select>
                        </td>
                        <td>
                          <select class="form-control item" name="item[]" required="">
                            <option value="">Choose Item</option>
                    ';
                        foreach($items as $key => $item){
                          $selected = $item['item_no'] == $request_item['item_no'] ? 'selected' : ''; 
                          echo '
                            <option value="'.$item['item_no'].'" '.$selected.'>'.$item['description'].'</option>';
                        }
                    echo '
                          </select>
                        </td>
                        <td>
                          <input type="number" value="'.$request_item['r_quantity'] .'" class="form-control" name="quantity[]" required="" placeholder="Enter quantity">
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
			html_code += `<td><select class="form-control item" name="item[]" required="">
                      <option value="">Choose Item</option>
                      <?php if(!empty($items)){ 
                          foreach($items as $key => $item){
                      ?>
                      <option value="<?php echo $item['item_no']?>"><?php echo $item['description']?></option>
                        <?php } } ?>
                    </select></td>`;
			html_code += '<td><input required="" type="number" name="quantity[]" placeholder="Enter quantity" min="0" class="form-control form-control-sm input-sm buy_price"></td>';
			html_code += '<td><button type="button" name="remove_row" id="' + count + '" class="btn btn-sm btn-danger btn-xs remove_row"><i class="fas fa-minus"></i></button></td></tr>';
			$("#request_table").append(html_code);

		});

		$(document).on('click', 'button.remove_row', function () {
			var id = $(this).attr('id');
			$('#row_id_' + id).remove();
			count -= 1;
    });
    
    
    $(document).on('change', 'select.cat', function(event){
      event.preventDefault(); 
      var id = $(this).val();
      var row = $(this).data('row'); 
      $.ajax({
        type: "method",
        url: "../../../item/get_item_by_category/" + id, 
        dataType: "json",
        success: function (data) {
          console.info(data)
          $('tr#' + row + '>td>select.item').html(data) 
        },
        error: function(xhr){
          console.info(xhr.responseText)
        }
      });

    })

	</script>
</body>

</html>
