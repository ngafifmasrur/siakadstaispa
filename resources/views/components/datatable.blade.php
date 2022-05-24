<div class="datatable table-responsive" style="overflow-x: auto !important;">
    <table class="table table-bordered table-hover" id="{{ isset($id) ? $id : 'dataTables' }}" width="100%" cellspacing="0">
        <thead>
            <tr>
                @foreach($table as $row)
                    <th class="text-center" @if (!empty($row['width']))  width="{{ $row['width'] }}" @endif>{!! ($row['title'] !== 'checkbox') ? $row['title'] : '<input type="checkbox" name="select_all" id="select_all">' !!}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

        </tbody>
        
    </table>
</div>

@push('js')
        
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
            paging: @if(isset($paging)) {{$paging}} @else true @endif,
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

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
</script>

@endpush