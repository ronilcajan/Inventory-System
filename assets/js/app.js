jQuery(document).ready(function ($) {
	// DataTable
	$('#category_table').DataTable();
	$('#item_table').DataTable({    
		'dom'    : 'Blfrtip',
		scrollX: true,
		scrollY: 600,
		buttons: [{
				extend: "copy",
        text: '<i class="fa fa-copy"></i>',
				className: "btn btn-primary  ",
        exportOptions: {
					'columns': '0,1,2,3,4,5'
        },
			},
			{
				extend: "csv",
				className: "btn btn-primary  ",
        exportOptions: {
					'columns': '0,1,2,3,4,5'
        },
			},
      {
          extend: "excelHtml5",
          className: " ",
          exportOptions: {
            'columns': '0,1,2,3,4,5'
          },
      },
			{
        extend: "pdfHtml5",
        text: '<i class="fa fa-file-pdf"></i>',
        className: "btn btn-primary  ",
        exportOptions: {
					'columns': '0,1,2,3,4,5'
        },
        download: 'open'
			},
			{
				extend: "print",
        text: '<i class="fa fa-print"></i>',
				className: "btn btn-primary  ",
        exportOptions: {
					'columns': '0,1,2,3,4,5'
        },
			},
		],
		responsive: true
	});
	$('#release_table').DataTable();

	$(document).on('click', 'a.edit-category', function () {
		var id = $(this).attr('id');

		$.ajax({
			type: "method",
			url: "category/select_category/" + id,
			dataType: "json",
			success: function (data) {
				$('input[name="category_id"]').val(data.category_id);
				$('input[name="category"]').val(data.category);
			},
			error: function (xhr) {
				console.info(xhr.responseText)
			}
		});
	});

	$(document).on('change', 'select.category', function (event) {
		event.preventDefault();
		var id = $(this).val();
		var row = $(this).data('row');
		$.ajax({
			type: "method",
			url: "../item/get_item_by_category/" + id,
			dataType: "json",
			success: function (data) {
				console.info(data)
				$('tr#' + row + '>td>select.item').html(data)
			},
			error: function (xhr) {
				console.info(xhr.responseText)
			}
		});

	})



	var pathName = window.location.pathname.split("/");

	// material
	function unseen_notif(url = '?unseen_notif=check_quantity') {
		$.ajax({
			url: "request/get_notification/" + url,
			method: "POST",
			dataType: "json",
			beforeSend: function (jqXHR, settings) {
				if (pathName.length == 3 || pathName.length == 4) {
					this.url = this.url
				} else {
					this.url = '../../' + this.url;
				}
			},
			success: function (data) {
				$('.notif-list').html(data.notification);
				if (data.unseen_notification > 0) {
					$('.count-quantity').text(data.unseen_notification);
				} else {
					$('.count-quantity').text(0)
				}
			},
			error: function (xhr, status, error) {}
		});
	}

	unseen_notif();

	$(document).on('click', '.notification-toggle', function () {
		unseen_notif();
	});

	setInterval(function () {
		unseen_notif();
	}, 1000);


});
