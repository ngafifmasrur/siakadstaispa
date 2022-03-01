<table>
    <thead>
        <caption> Laporan pendaftaran calon mahasiswa baru diunduh pada {{ date('Y-m-d H:i:s') }} </caption>
        <tr>
            <th colspan="{{ 10 }}">Data calon mahasiswa baru</th>
            <th colspan="14">Data pendaftaran</th>
            <th colspan="5">Alamat</th>
            <th colspan="{{ $files->count() }}">Berkas pendaftaran</th>
        </tr>
        <tr>
            <th>User ID</th>
            <th>No</th>
            <th>Nama lengkap</th>
            <th>Tempat lahir</th>
            <th>Tanggal lahir</th>
            <th>Jenis kelamin</th>
            <th>NIK</th>
            <th>No KK</th>
            <th>No Telp</th>
            <th>Alamat email</th>
            <th>Jalur pendaftaran</th>
            <th>No pendaftaran</th>
            <th>Tanggal tes</th>
            <th>Sesi tes</th>
            <th>Mendaftar</th>
            <th>Terverifikasi</th>
            <th>Lulus tes</th>
            <th>Validasi</th>
            <th>Perjanjian</th>
            <th>Lunas pembayaran</th>
            <th>Kamar</th>
            <th>Ranjang</th>
            <th>Status saat ini</th>
            <th>Minat 1</th>
            <th>Minat 2</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Kabupaten</th>
            <th>Provinsi</th>
            <th>Kode Pos</th>
            @foreach($files as $file)
                <th>{{ $file->name }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($registrants as $registrant)
            @php
                $user = $registrant->user;
                $admission = $registrant->admission;
            @endphp
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->profile->full_name }}</td>
                <td>{{ $user->profile->pob }}</td>
                <td>{{ isset($user->profile->dob) ? $user->profile->dob->format('d/m/Y') : '' }}</td>
                <td>{{ $user->profile->sex_name }}</td>
                <td style='mso-number-format:"@"'>{{ $user->profile->nik }}</td>
                <td style='mso-number-format:"@"'>{{ $user->profile->nokk }}</td>
                <td style='mso-number-format:"@"'>{{ $user->phone->number }}</td>
                <td>{{ $user->email->address ?? '-' }}</td>
                <td>{{ $admission->full_name }}</td>
                <td>{{ $registrant->kd }}</td>
                <td>{{ $registrant->test_at ? $registrant->test_at->format('d-m-Y') : '' }}</td>
                <td>{{ $registrant->session ? ($registrant->session->name.' '.$registrant->session->range) : '' }}</td>
                <td>{{ $registrant->created_at }}</td>
                <td>{{ $registrant->verified_at }}</td>
                <td>{{ $registrant->tested_at }}</td>
                <td>{{ $registrant->validated_at }}</td>
                <td>{{ $registrant->agreement_at }}</td>
                <td>{{ $registrant->paid_off_at }}</td>
                <td>{{ $registrant->room->name ?? '' }}</td>
                <td>{{ $registrant->bed }}</td>
                <td>{{ $registrant->step_status }}</td>
                <td>{{ $registrant->major1_name ?? '-' }}</td>
                <td>{{ $registrant->major2_name ?? '-' }}</td>
                <td>{{ $user->address->village ?? '-' }}</td>
                <td>{{ $user->address->district->name ?? '-' }}</td>
                <td>{{ $user->address->district->regency->name ?? '-' }}</td>
                <td>{{ $user->address->district->regency->province->name ?? '-' }}</td>
                <td>{{ $user->address->postal ?? '-' }}</td>
                @foreach($files as $file)
                    <td>{{ $registrant->files ? ($registrant->files->firstWhere('id', $file->id) ? 'OK' : '-') : '-' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>