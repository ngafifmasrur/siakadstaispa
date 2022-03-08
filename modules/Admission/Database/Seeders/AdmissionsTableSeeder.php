<?php

namespace Modules\Admission\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AdmissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $inst_id = 1;
        $open_period = 1;
        $now = now();

        $permissions = [];
        foreach ([
            'verify' => 'Verifikasi pendaftar',
            'test' => 'Menguji/mengetes pendaftar',
            'validate' => 'Memvalidasi data pendaftar',
            'accept-payment' => 'Menerima pembayaran',
            'give-agreement' => 'Memberikan surat perjanjian',
            'give-room' => 'Memberikan nomor kamar',
            'registrate-registrants' => 'Mendaftarkan pendaftar',
            'manage-registrants' => 'Mengelola data pendaftar',
            'manage-test-dates' => 'Mengelola tanggal tes',
            'manage-test-sessions' => 'Mengelola sesi tes',
            'manage-payments' => 'Mengelola pembayaran beserta itemnya',
            'manage-admission' => 'Mengelola sistem pendaftaran',
        ] as $k => $v) {
            $permissions[] = [
                'name' => $k,
                'display_name' => $v,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('admission_permissions')->insert($permissions);

        $period = DB::table('inst_periods')->orderByDesc('id')->get()->first();

        $admissions[] = [
            'period_id' => $period->id,
            'name' => 'REGULER PUTRA',
            'generation' => $period->id,
            'open' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $admissions[] = [
            'period_id' => $period->id,
            'name' => 'REGULER PUTRI',
            'generation' => $period->id,
            'open' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('admissions')->insert($admissions);

        $committees = [];
        foreach ([
            'Steering Committee',
            'Ketua',
            'Perwakilan MA',
            'Bendahara',
            'Sekretaris',
            'Pendaftaran & Verifikasi',
            'Tes Tulis Arab',
            'Tes Lisan',
            'Psikotes',
            'Validasi Data',
            'Perjanjian',
            'Pembayaran',
            'Foto',
            'Kamar',
            'Murafiq',
            'Sarana & Prasarana',
            'Konsumsi',
            'Tes Online Luar jawa',
            'IT Support',
        ] as $value) {
            foreach ($admissions as $k => $v) {
                $committees[] = [
                    'admission_id' => ($k + 1),
                    'name' => $value,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('admission_committees')->insert($committees);

        $committee_permissions = [];
        foreach ($permissions as $k => $v) {
            $committee_permissions[] = [
                'committee_id' => 2,
                'permission_id' => ($k + 1),
            ];
        }
        DB::table('admission_committee_permissions')->insert($committee_permissions);

        $availableForms = [1, 0, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1];
        $forms = [];
        for ($i=0; $i < count($availableForms); $i++) { 
            foreach ($admissions as $k => $v) {
                $forms[] = [
                    'admission_id' => ($k + 1),
                    'key' => $i,
                    'required' => $availableForms[$i],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('admission_forms')->insert($forms);

        $reqsGeneral = [];
        foreach ($admissions as $k => $v) {
            foreach ([
                'Memiliki komitmen kuat menempuh pendidikan di lingkungan pesantren',
                'Sanggup tinggal di asrama pesantren',
                'Sanggup mentaati kode etik mahasiswa MASPA',
                'Menandatangani surat perjanjian mahasiswa MASPA'
            ] as $value) {
                $reqsGeneral[] = [
                    'admission_id' => ($k + 1),
                    'name' => $value
                ];
            }
        }
        DB::table('admission_reqs_general')->insert($reqsGeneral);

        $reqsSpecial = [];
        foreach ($admissions as $k => $v) {
            foreach ([
                'Mampu membaca al-Qur\'an dengan fasih dan kaedah yang baik',
                'Hafal al-Qur\'an surah al-Ghasiyyah s/d an-Nas',
                'Scan KTP/Identitas orang tua atau wali yang masih berlaku (dijadikan 1 file)',
                'Scan Kartu Keluarga (KK)',
                'Scan Akta kelahiran',
                'Scan raport semester ganjil kelas 4 dan 5 untuk pendaftaran MTs, kelas 7 dan 8 untuk pendaftaran MA',
                'Pas foto fisik berwarna ukuran 3x4 dan 2x2 (masing-masing 2 lembar)',
                'Pas foto digital berwarna rasio 3:4 berbaju seragam putih berlatarbelakang warna merah (Putra: bersongkok hitam, Putri: berjilbab putih)',
                'Scan ijazah Sekolah/Madrasah jenjang sebelumnya yang berlegalisir 2 lembar',
                'Scan SKHUN Sekolah/Madrasah jenjang sebelumnya yang berlegalisir 2 lembar',
                'Scan Surat keterangan sehat dari dokter',
                'Scan Surat keterangan kelakuan baik (SKKB)',
                'Scan Kartu atau surat keterangan NISN (Nomor Induk Siswa Nasional)',
                'Scan Surat keterangan NPSN (Nomor Pokok Sekolah Nasional)'
            ] as $value) {
                $reqsSpecial[] = [
                    'admission_id' => ($k + 1),
                    'name' => $value
                ];
            }
        }
        DB::table('admission_reqs_special')->insert($reqsSpecial);

        $files = [];
        foreach ($admissions as $k => $v) {
            foreach ([
                ['Kartu Keluarga (KK)', null, '1'],
                ['Akta kelahiran', null, '1'],
                ['Raport semester ganjil kelas 7', null, '1'],
                ['Raport semester ganjil kelas 8', null, '1'],
                ['Ijazah Sekolah/Madrasah jenjang sebelumnya', 'Wajib diunggah jika pengumuman kelulusan dari sekolah/madrasah asal sudah keluar atau berkas sudah terbit', 0],
                ['SKHUN Sekolah/Madrasah jenjang sebelumnya', 'Wajib diunggah jika pengumuman kelulusan dari sekolah/madrasah asal sudah keluar atau berkas sudah terbit', 0],
                ['Surat keterangan sehat dari dokter', null, 0],
                ['Surat keterangan kelakuan baik (SKKB)', 'Wajib diunggah apabila pendaftar adalah BUKAN lulusan MTs Sunan Pandanaran', 0],
                ['Kartu atau surat keterangan NISN (Nomor Induk Siswa Nasional)', null, '1'],
                ['Surat keterangan NPSN (Nomor Pokok Sekolah Nasional)', 'Jika ada', 0],
            ] as $v) {
                $files[] = [
                    'admission_id' => ($k + 1),
                    'name' => $v[0],
                    'description' => $v[1],
                    'required' => $v[2],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('admission_files')->insert($files);

        $sessions = [];
        foreach ($admissions as $k => $v) {
            foreach ([
                ['SESI 1', '08:00:00', '10:00:00'],
                ['SESI 2', '09:00:00', '11:00:00'],
                ['SESI 3', '10:00:00', '12:00:00'],
            ] as $v) {
                $sessions[] = [
                    'admission_id' => ($k + 1),
                    'name' => $v[0],
                    'start_time' => $v[1],
                    'end_time' => $v[2],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        DB::table('admission_sessions')->insert($sessions);

        $dates = ['2019-12-22', '2019-12-23', '2019-12-24', '2019-12-25', '2019-12-28', '2019-12-29', '2019-12-30', '2019-12-31', '2020-01-01', '2020-01-04', '2020-01-05', '2020-01-06', '2020-01-07', '2020-01-08', '2020-01-11', '2020-01-12', '2020-01-13', '2020-01-14', '2020-01-15', '2020-01-18', '2020-01-19', '2020-01-20', '2020-01-21', '2020-01-22', '2020-01-25', '2020-01-26', '2020-01-27', '2020-01-28', '2020-01-29', '2020-02-01', '2020-02-02', '2020-02-03', '2020-02-04', '2020-02-05', '2020-02-08', '2020-02-09', '2020-02-10', '2020-02-11', '2020-02-12', '2020-02-15', '2020-02-16', '2020-02-17', '2020-02-18', '2020-02-19', '2020-02-22', '2020-02-23', '2020-02-24', '2020-02-25', '2020-02-26'];
        $test_dates = [];
        foreach ($admissions as $k => $v) {
            foreach ($dates as $v) {
                $test_dates[] = [
                    'admission_id' => ($k + 1),
                    'date' => $v,
                ];
            }
        }
        DB::table('admission_test_dates')->insert($test_dates);
    }
}
