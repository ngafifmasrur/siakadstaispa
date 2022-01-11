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
            pageLength: 25,
            responsive: false,
            @if(isset($buttons)) 
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            @endif
            @if(isset($searching)) 
              @if($searching==false) 
              searching: false,
              paging:   false,
              @endif
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