$(function(e) {
	
	//sample datatable	
	$('#example-2').DataTable();
	
	//Details display datatable
	$('#example-1').DataTable( {
		responsive: {
			details: {
				display: $.fn.dataTable.Responsive.display.modal( {
					header: function ( row ) {
						var data = row.data();
						return 'Details for '+data[0]+' '+data[1];
					}
				} ),
				renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
					tableClass: 'table'
				} )
			}
		}
	} );
	
	//form-input-datatable
	var table = $('#form-input-datatable').DataTable({
        columnDefs: [{
            orderable: false,
            targets: [1,2,3, 4, 5]
        }]
    });
    $('button').click( function() {
        var data = table.$('input, select').serialize();
        alert(
            "The following data would have been submitted to the server: \n\n"+
            data.substr( 0, 120 )+'...'
        );
        return false;
    } );
	
	//Select2
	$('.select2').select2({
		minimumResultsForSearch: Infinity
	});
	$('table').on('draw.dt', function() {
		$('.select2').select2({
			minimumResultsForSearch: Infinity
		});
	});
   
   
} );