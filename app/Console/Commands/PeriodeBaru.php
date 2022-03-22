<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PeriodeBaru extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'periode:baru {tahun}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat periode baru';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $inst_id = 1;
        $open_period = 1;
        $now = now();
        $tahun = $this->argument('tahun');
        $tahun_after = $tahun+1;
        Model::unguard();

        DB::beginTransaction();
        try {

            // Check Tahun Periode
            $period = DB::table('inst_periods')->where('year', $tahun)->first();
            $last_period = DB::table('inst_periods')->orderByDesc('id')->get()->first()->id;
            if(!isset($period)) {
                $new_period[] = [
                    'id' => $last_period+1,
                    'inst_id' => $inst_id,
                    'name' => $tahun.'-'.$tahun_after,
                    'year' => $tahun,
                ];
                $period = DB::table('inst_periods')->insert($new_period);
            }

            $periode = DB::table('inst_periods')->where('year', $tahun)->first();


            $admission = DB::table('admissions')->where('period_id', $periode->id)->first();
            
            if(!isset($admission)) {
                $admissions[] = [
                    'period_id' => $periode->id,
                    'name' => 'PMB',
                    'generation' => $periode->id,
                    'open' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
        
                DB::table('admissions')->insert($admissions);
            }
            // Create New Admission
            $admissions = DB::table('admissions')->where('period_id', $periode->id)->first();

            
            // Create Committees
            $committees = [];
            foreach ([
                'Programmer',
                'Panitia',
                'Div. Pembayaran'
            ] as $value) {
                    $committees[] = [
                        'admission_id' => $admissions->id,
                        'name' => $value,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
            }
            DB::table('admission_committees')->insert($committees);
            $committeess = DB::table('admission_committees')->where('admission_id', $admissions->id)->get();

            $panitia = DB::table('admission_committee_members')->where('kd', 'PAN-01')->update([
                'committee_id' => $committeess->where('name', 'Panitia')->first()->id
            ]);
            $programmer = DB::table('admission_committee_members')->where('kd', 'PRG-01')->update([
                'committee_id' => $committeess->where('name', 'Programmer')->first()->id
            ]);
            $pembayaran = DB::table('admission_committee_members')->where('kd', 'PB-01')->update([
                'committee_id' => $committeess->where('name', 'Div. Pembayaran')->first()->id
            ]);

            $permissions = DB::table('admission_permissions')->get();
            $committee_permissions = [];

            foreach ($committeess as $value) {
                foreach ($permissions as $k => $v) {
                    $committee_permissions[] = [
                        'committee_id' => $value->id,
                        'permission_id' => ($k + 1),
                    ];
                }
            }

            DB::table('admission_committee_permissions')->insert($committee_permissions);

            $availableForms = [
                [
                    'key'        => 0,
                    'keterangan' => 'Profile',
                    'required'   => 1
                ],
                [
                    'key'        => 1,
                    'keterangan' => 'Alamat e-mail',
                    'required'   => 1
                ],                
                [
                    'key'        => 2,
                    'keterangan' => 'Nomor HP',
                    'required'   => 0
                ],                
                [
                    'key'        => 3,
                    'keterangan' => 'Alamat asal',
                    'required'   => 1
                ],                
                [
                    'key'        => 4,
                    'keterangan' => 'Data ayah',
                    'required'   => 1
                ],                
                [
                    'key'        => 5,
                    'keterangan' => 'Data ibu',
                    'required'   => 1
                ],                
                // [
                //     'key'        => 6,
                //     'keterangan' => 'Data wali',
                //     'required'   => 1
                // ],                
                // [
                //     'key'        => 7,
                //     'keterangan' => 'Riwayat pendidikan',
                //     'required'   => 0
                // ],              
                // [
                //     'key'        => 8,
                //     'keterangan' => 'Riwayat organisasi',
                //     'required'   => 0
                // ],                
                // [
                //     'key'        => 9,
                //     'keterangan' => 'Data Prestasi',
                //     'required'   => 0
                // ],                
                [
                    'key'        => 10,
                    'keterangan' => 'Pemilihan program studi',
                    'required'   => 1
                ],
                [        
                    'key'        => 11,
                    'keterangan' => 'Berkas pendaftaran',
                    'required'   => 1
                ],
                [        
                    'key'        => 12,
                    'keterangan' => 'Pemilihan tanggal kedatangan',
                    'required'   => 1
                ]
            ];
            $forms = [];
            foreach($availableForms as $item) {
                $forms[] = [
                    'admission_id' => $admissions->id,
                    'key' => $item['key'],
                    'required' => $item['required'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('admission_forms')->insert($forms);

            $reqsGeneral = [];
                foreach ([
                    'Memiliki komitmen kuat menempuh pendidikan di lingkungan pesantren',
                    'Sanggup tinggal di asrama pesantren',
                    'Sanggup mentaati kode etik mahasiswa STAI Sunan Paandanaran',
                    'Menandatangani surat perjanjian mahasiswa STAI Sunan Paandanaran',
                    'Lulus pada jenjang pendidikan MA/SMA/SKM/sederajat'
                ] as $value) {
                    $reqsGeneral[] = [
                        'admission_id' => $admissions->id,
                        'name' => $value
                    ];
                }
            
            DB::table('admission_reqs_general')->insert($reqsGeneral);

            $reqsSpecial = [];
                foreach ([
                    'Mampu membaca al-Qur\'an dengan fasih dan kaedah yang baik',
                    'Hafal al-Qur\'an surah al-Ghasiyyah s/d an-Nas',
                    'Membayar biaya pendaftaran',
                    'Pas foto fisik berwarna ukuran 3x4 dan 2x2 (masing-masing 2 lembar)',
                    'Pas foto digital berwarna rasio 3:4 berbaju seragam putih berlatarbelakang warna merah (Putra: bersongkok hitam, Putri: berjilbab putih)',
                ] as $value) {
                    $reqsSpecial[] = [
                        'admission_id' => $admissions->id,
                        'name' => $value
                    ];
                }
            
            DB::table('admission_reqs_special')->insert($reqsSpecial);

            $files = [];
                foreach ([
                    ['Kartu Keluarga (KK)', null, '1', '1'],
                    // ['Akta kelahiran', null, 0, 0],
                    // ['Ijazah Sekolah/Madrasah jenjang sebelumnya', 'Wajib diunggah jika pengumuman kelulusan dari sekolah/madrasah asal sudah keluar atau berkas sudah terbit', 0, 0],
                    // ['SKHUN Sekolah/Madrasah jenjang sebelumnya', 'Wajib diunggah jika pengumuman kelulusan dari sekolah/madrasah asal sudah keluar atau berkas sudah terbit', 0, 0],
                    // ['Surat keterangan sehat dari dokter', null, 0, 0],
                    // ['Surat keterangan kelakuan baik (SKKB)', 'Wajib diunggah apabila pendaftar adalah BUKAN lulusan MTs Sunan Pandanaran', 0, 0],
                    ['Kartu BSM', 'Wajib diunggah jika Anda ingin mengajukan sebagai santri mandiri (dokumen akan melalui proses screening dan verifikasi oleh tim)', '0', '1'],
                    ['Surat Keterangan Tidak Mampu', 'Wajib diunggah jika Anda ingin mengajukan sebagai santri mandiri (dokumen akan melalui proses screening dan verifikasi oleh tim)', '0', '1'],
                    ['Kartu KIP', 'Wajib diunggah jika Anda ingin mengajukan sebagai santri mandiri (dokumen akan melalui proses screening dan verifikasi oleh tim)', '0', '1'],
                    // ['Bukti pembayaran', 'Biaya pendaftaran sebesar Rp 250.000', '1', 0],
                ] as $v) {
                    $files[] = [
                        'admission_id' => $admissions->id,
                        'name' => $v[0],
                        'description' => $v[1],
                        'required' => $v[2],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            
            DB::table('admission_files')->insert($files);

            $sessions = [];
                foreach ([
                    ['SESI 1', '08:00:00', '10:00:00'],
                    ['SESI 2', '13:00:00', '14:00:00'],
                ] as $v) {
                    $sessions[] = [
                        'admission_id' => $admissions->id,
                        'name' => $v[0],
                        'start_time' => $v[1],
                        'end_time' => $v[2],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            
            DB::table('admission_sessions')->insert($sessions);

            $dates = ['2022-03-10', '2022-03-11', '2022-03-12', '2022-03-13'];
            $test_dates = [];
                foreach ($dates as $v) {
                    $test_dates[] = [
                        'admission_id' => $admissions->id,
                        'date' => $v,
                    ];
                
            }
            DB::table('admission_test_dates')->insert($test_dates);

            $admission_tests = DB::table('admission_tests')->update([
                'admission_id' => $admissions->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->info($e->getMessage());
        }

        $this->info("\n..............................");
        $this->info("OK");
    }
}
