@php
    
    $categorized = $payment->items->groupBy(function($query) {
        return $query->category->name ?? 'Lainnya';
    });

    $num = 1;
    $sums = [];

@endphp

<table border="1">
    <thead>
        <caption>
            Rekap pembayaran per item per calon mahasiswa diunduh pada {{ date('Y-m-d H:i:s') }}<br>
            Difilter antara {{ $date['from'] }} sampai {{ $date['to'] }}
        </caption>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Jalur pendaftaran</th>
            <th rowspan="2">Jenis pembayaran</th>
            <th colspan="5">Informasi calon mahasiswa</th>
            <th colspan="4">Informasi transaksi</th>
            @foreach($categorized as $cat => $items)
                <th colspan="{{ count($items) }}">{{ $cat }}</th>
                <th rowspan="2">Jumlah</th>
            @endforeach
            <th rowspan="2">Total</th>
            <th rowspan="2">Catatan</th>
        </tr>
        <tr>
            <th>No pendaftaran</th>
            <th>Nama calon mahasiswa</th>
            <th>Tempat lahir</th>
            <th>Tanggal lahir</th>
            <th>Jenis kelamin</th>
            <th>Metode pembayaran</th>
            <th>Pembayar</th>
            <th>Tanggal transaksi</th>
            <th>Tanggal input</th>
            @foreach($categorized as $cat => $items)
                @foreach($items as $item)
                    <th>{{ $item->name }}</th>
                @endforeach
            @endforeach
        </tr>
        <tr>
            @for($i = 0; $i < 12; $i++)
                <th><small>{{ $num++ }}</small></th>
            @endfor
            @foreach($categorized as $cat => $items)
                @foreach($items as $item)
                    <th><small>{{ $num++ }}</small></th>
                @endforeach
                <th><small>{{ $num++ }}</small></th>
            @endforeach
            <th><small>{{ $num++ }}</small></th>
            <th><small>{{ $num++ }}</small></th>
        </tr>
    </thead>
    <tbody>
        @foreach($payment->transactions as $transaction)
            @php
                $total = 0;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaction->registrant->admission->full_name }}</td>
                <td>{{ $transaction->registrant->payment->name }}</td>
                <td>{{ $transaction->registrant->kd }}</td>
                <td>{{ $transaction->registrant->user->profile->full_name }}</td>
                <td>{{ $transaction->registrant->user->profile->pob }}</td>
                <td>{{ $transaction->registrant->user->profile->dob ? $transaction->registrant->user->profile->dob->format('d/m/Y') : '' }}</td>
                <td>{{ $transaction->registrant->user->profile->sex_name }}</td>
                <td>{{ $transaction->cash_name }}</td>
                <td>{{ $transaction->payer }}</td>
                <td>{{ $transaction->payed_at }}</td>
                <td>{{ $transaction->created_at }}</td>
                @foreach($categorized as $cat => $items)
                    @php
                        $sum = 0;
                    @endphp
                    @foreach($items as $item)
                        @php
                            $value = $transaction->value[$item->id] ?? 0;
                            $sums[0][$item->id][] = $value;
                            $sum += $value;
                        @endphp
                        <td>{{ $value }}</td>
                    @endforeach
                    @php
                        $total += $sum;
                        $sums[1][$cat][] = $sum;
                    @endphp
                    <td>{{ $sum }}</td>
                @endforeach
                @php
                    $sums[2][] = $total;
                @endphp
                <td>{{ $total }}</td>
                <td>{{ $transaction->description }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="12"><strong>JUMLAH</strong></td>
            @foreach($categorized as $cat => $items)
                @foreach($items as $item)
                    <td><strong>{{ array_sum($sums[0][$item->id] ?? [0]) }}</strong></td>
                @endforeach
                <td><strong>{{ array_sum($sums[1][$cat] ?? [0]) }}</strong></td>
            @endforeach
            <td><strong>{{ array_sum($sums[2] ?? [0]) }}</strong></td>
        </tr>
    </tbody>
</table>
