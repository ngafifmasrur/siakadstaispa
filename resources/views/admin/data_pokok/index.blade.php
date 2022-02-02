@extends('layouts.app')
@section('title', $title)

@section('content')
<x-header>
    {{ $title }}
</x-header>

<x-card-table>
    <x-slot name="title">Data {{ $title }}</x-slot>

    @if (! empty($data))
    <x-table>
        <x-slot name="thead">
            @if (! empty($data[0]))
                @php
                    $i = 0;
                @endphp
                @foreach ($data[0] as $key => $val)
                    @if ($i == 0)
                    <th width="5%">No.</th>
                    @else
                    <th>{{ str_replace('_', ' ', $key) }}</th>
                    @endif
                    @php
                        $i++;
                    @endphp
                @endforeach
            @endif
        </x-slot>

        @foreach ($data as $index => $item)
            <tr>
            @php
                $j = 0;
            @endphp
            @foreach ($item as $key => $val)
                @if ($j == 0)
                <td>{{ $index+1 }}</td>
                @else
                <td>{{ $val }}</td>
                @endif

                @php
                    $j++;
                @endphp
            @endforeach
            </tr>
        @endforeach
    </x-table>
    @else
    <p>Data tidak tersedia</p>
    @endif

</x-card-table>
@endsection

@push('js')
<script>
    $('.table').DataTable();
</script>
@endpush