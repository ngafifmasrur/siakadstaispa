<table>
    <thead>
        <caption>
            Laporan pembayaran calon mahasiswa diunduh pada {{ date('Y-m-d H:i:s') }}<br>
            Difilter antara {{ $date['from'] }} sampai {{ $date['to'] }}
        </caption>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Jalur pendaftaran</th>
            <th colspan="5">Informasi calon mahasiswa</th>
            <th colspan="7">Informasi transaksi</th>
        </tr>
        <tr>
            <th>No pendaftaran</th>
            <th>Nama calon mahasiswa</th>
            <th>Tempat lahir</th>
            <th>Tanggal lahir</th>
            <th>Jenis kelamin</th>
            <th>Nomor kwitansi</th>
            <th>Pembayar</th>
            <th>Jenis transaksi</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Petugas</th>
            <th>Waktu transaksi</th>
            <th>Tanggal input</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
            @php
                $user = $payment->registrant->user;
                $admission = $payment->registrant->admission;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $admission->full_name }})</td>
                <td>{{ $payment->registrant->kd }}</td>
                <td>{{ $user->profile->name }}</td>
                <td>{{ $user->profile->pob }}</td>
                <td>{{ isset($user->profile->dob) ? $user->profile->dob->format('d/m/Y') : '' }}</td>
                <td>{{ $user->profile->sex_name }}</td>
                <td>{{ $payment->kd }}</td>
                <td>{{ $payment->payer }}</td>
                <td>{{ $payment->cash ? 'TUNAI' : 'NON-TUNAI' }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->description }}</td>
                <td>{{ $payment->committee->member->profile->name }}</td>
                <td>{{ $payment->payed_at }}</td>
                <td>{{ $payment->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>