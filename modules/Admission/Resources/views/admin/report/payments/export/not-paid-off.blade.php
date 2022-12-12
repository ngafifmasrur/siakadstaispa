<table>
    <thead>
        <caption> Laporan pembayaran belum lunas diunduh pada {{ date('Y-m-d H:i:s') }} </caption>
        <tr>
            <th>No</th>
            <th>Jalur pendaftaran</th>
            <th>No pendaftaran</th>
            <th>Nama calon mahasiswa</th>
            <th>Tempat lahir</th>
            <th>Tanggal lahir</th>
            <th>Jenis kelamin</th>
            <th>No telp</th>
            <th>Alamat email</th>
            <th>Jenis pembayaran</th>
            <th>Harus bayar</th>
            <th>Sudah bayar</th>
            <th>Belum bayar</th>
            <th>Total transaksi</th>
            <th>Terakhir transaksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($registrants as $registrant)
            @php
                $user = $registrant->user;
                $admission = $registrant->admission;
                $must = $registrant->payment->items->sum('amount');
                $sum = $registrant->transactions->sum('amount');
                $last = ($registrant->transactions)
                            ? $registrant->transactions->sortByDesc('payed_at')->first()->payed_at ?? ''
                            : '';
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $admission->full_name }}</td>
                <td>{{ $registrant->kd }}</td>
                <td>{{ $user->profile->name }}</td>
                <td>{{ $user->profile->pob }}</td>
                <td>{{ isset($user->profile->dob) ? $user->profile->dob->format('d/m/Y') : '' }}</td>
                <td>{{ $user->profile->sex_name }}</td>
                <td style='mso-number-format:"@"'>{{ $user->nomor_hp ??  '-', }}</td>
                <td>{{ $user->email->address ?? '-' }}</td>
                <td>{{ $registrant->payment->name }}</td>
                <td>{{ $must }}</td>
                <td>{{ $sum }}</td>
                <td>{{ $must - $sum }}</td>
                <td>{{ count($registrant->transactions) }}</td>
                <td>{{ $last }}</td>
            </tr>
        @endforeach
    </tbody>
</table>