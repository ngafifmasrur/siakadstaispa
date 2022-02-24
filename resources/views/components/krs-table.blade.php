@push('css')
<link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
@endpush



<div class="table-responsive">
    <table id="{{ isset($id) ? $id : 'dataTables' }}" class="table table-striped table-bordered text-nowrap w-100">
        <thead>
            <tr>
                @foreach($table as $row)
                    <th class="text-center" @if (!empty($row['width']))  width="{{ $row['width'] }}" @endif>{!! $row['title'] !!}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot align="right">
            <th colspan="7" class="font-weight-bold text-center"></th>
            <th class="font-weight-bold text-center"></th>
            <th class="font-weight-bold text-center"></th>
        </tfoot>
    </table>
</div>

@push('js')
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

<script>
        let @if(isset($id)) {{$id}} @else table @endif = $(`{{ isset($id) ? '#'.$id : '#dataTables' }}`).DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            @if(isset($searching)) 
              searching: false,
              ordering: false,
              bInfo: false,
            @endif
            ajax: "{{ $route }}",
            ajax: {
                url: "{{ $route }}{!! isset($query) ? $query : '' !!}",
                data: function (d) {
                    @if(isset($filter))
                        @foreach($filter as $row)
                            @if ($row['value'] && is_string($row['value']))
                                d.{!! $row['data'] !!} = {!! $row['value'] !!};
                            @endif
                        @endforeach
                    @endif
                }
            },
            columns: [
                @foreach($table as $row)
                    {
                        data: '{{$row["data"]}}',
                        
                        @if(isset($row['name']))
                            name: '{{$row["name"]}}',
                        @endif

                        @if(isset($row['type']))
                            type: '{{$row["type"]}}',
                        @endif

                        @if(isset($row['classname']))
                            className: '{{$row["classname"]}}',
                        @endif

                        @if(isset($row['render']))
                        render: {
                            _: `{!! $row['render']["display"] !!}`,
                            sort: `{!! $row['render']["sort"] !!}`
                        },
                        @endif
                        
                        orderable: @if(isset($row['orderable'])) {{$row['orderable']}} @else true @endif,
                        searchable: @if(isset($row['searchable'])) {{$row['searchable']}} @else true @endif
                    },
                @endforeach
            ],
            footerCallback: function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var total_sks = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
                    
                // Update footer by showing the total with the reference of the column index 
                $( api.column( 1 ).footer() ).html('Total');
                $( api.column( 7 ).footer() ).html(total_sks);
                $( api.column( 8 ).footer() ).html('-');
            },

            responsive: false,
            @if(isset($buttons)) 
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            @endif

            @if(isset($drawCallback))
                drawCallback: {!! $drawCallback !!},
            @endif

            language: {
                @if(isset($searchPlaceholder))
                    searchPlaceholder: "{{$searchPlaceholder}}",
                @endif
            },
            
        });
</script>

@endpush