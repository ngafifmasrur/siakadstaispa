$(function(e) {

	$('#datatables').DataTable();

	var table = $('#input-datatable').DataTable();
	$('button').click( function() {
		var data = table.$('input, select').serialize();
		alert(
			"The following data would have been submitted to the server: \n\n"+
			data.substr( 0, 120 )+'...'
		);
		return false;
	});
	
	 $('#vertical-scrollable-datatable').DataTable( {
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
	
	//file export datatable
	var table = $('#fileexport-datatable').DataTable( {
		lengthChange: false,
		buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
	} );
	table.buttons().container()
		.appendTo( '#fileexport-datatable_wrapper .col-md-6:eq(0)' );
} );