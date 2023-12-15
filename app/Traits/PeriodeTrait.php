<?php

namespace App\Traits;

use App\Models\InstancePeriod;
use Illuminate\Support\Facades\DB;
use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionCommittee;
use Modules\Admission\Models\AdmissionCommitteeMember;
use Modules\Admission\Models\AdmissionFile;
use Modules\Admission\Models\AdmissionForm;
use Modules\Admission\Models\AdmissionGeneralRequirement;
use Modules\Admission\Models\AdmissionSession;
use Modules\Admission\Models\AdmissionSpecialRequirement;
use Modules\Admission\Models\AdmissionTestDate;

trait PeriodeTrait
{

    /**
     * Create or find existing Periode
     *
     * @param [integer] $request
     * @return mixed
     */
    public function generatePeriodeAndAdmission($request)
    {
        InstancePeriod::updateOrCreate([
            'inst_id' => 1,
            'year' => $request->year
        ],[
            'name' => $request->year . '-' . ($request->year + 1)
        ]);

        $periode = DB::table('inst_periods')->where('year', $request->year)->first();

        Admission::updateOrCreate([
            'period_id' => $periode->id,
            'generation' => $periode->id
        ],[
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'open' => $request->status
        ]);

        return Admission::where('period_id', $periode->id)->first();
    }

    /**
     * Generate Committes
     *
     * @param [integer] $admission
     * @return void
     */
    public function generateAdmissionCommittes($admission)
    {
        $committees = [];
        foreach ([
            'Programmer',
            'Panitia',
            'Div. Pembayaran'
        ] as $value) {
                $committees[] = [
                    'admission_id' => $admission->id,
                    'name' => $value
                ];
        }

        DB::table('admission_committees')->insert($committees);
        $committeess = AdmissionCommittee::where('admission_id', $admission->id)->get();

        AdmissionCommitteeMember::where('kd', 'PAN-01')->update([
            'committee_id' => $committeess->where('name', 'Panitia')->first()->id
        ]);

        AdmissionCommitteeMember::where('kd', 'PRG-01')->update([
            'committee_id' => $committeess->where('name', 'Programmer')->first()->id
        ]);

        AdmissionCommitteeMember::where('kd', 'PB-01')->update([
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

        DB::table('admission_committee_permissions')->insertOrIgnore($committee_permissions);
    }

    /**
     * Generate Forms
     *
     * @param [integer] $admission
     * @return void
     */
    public function generateAdmissionForms($admission)
    {
        $availableForms = [
            [
                'key'        => 0,
                'keterangan' => 'Profile',
                'required'   => 1
            ],[
                'key'        => 1,
                'keterangan' => 'Alamat e-mail',
                'required'   => 1
            ],[
                'key'        => 2,
                'keterangan' => 'Nomor HP',
                'required'   => 0
            ],[
                'key'        => 3,
                'keterangan' => 'Alamat asal',
                'required'   => 1
            ],[
                'key'        => 4,
                'keterangan' => 'Data ayah',
                'required'   => 1
            ],[
                'key'        => 5,
                'keterangan' => 'Data ibu',
                'required'   => 1
            ],[
                'key'        => 10,
                'keterangan' => 'Pemilihan program studi',
                'required'   => 1
            ],[
                'key'        => 11,
                'keterangan' => 'Berkas pendaftaran',
                'required'   => 1
            ],[
                'key'        => 12,
                'keterangan' => 'Pemilihan tanggal kedatangan',
                'required'   => 1
            ]
        ];

        $forms = [];
        foreach($availableForms as $item) {
            AdmissionForm::updateOrCreate([
                'admission_id' => $admission->id,
                'key' => $item['key'],
                'required' => $item['required']
            ]);
        }

        DB::table('admission_forms')->insertOrIgnore($forms);
    }

    /**
     * Generate Req
     *
     * @param [integer] $admission
     * @return void
     */
    public function generateAdmissionReqs($admission)
    {
        foreach ([
            'Memiliki komitmen kuat menempuh pendidikan di lingkungan pesantren',
            'Sanggup tinggal di asrama pesantren',
            'Sanggup mentaati kode etik mahasiswa STAI Sunan Paandanaran',
            'Menandatangani surat perjanjian mahasiswa STAI Sunan Paandanaran',
            'Lulus pada jenjang pendidikan MA/SMA/SKM/sederajat'
        ] as $value) {
            AdmissionGeneralRequirement::updateOrCreate([
                'admission_id' => $admission->id,
                'name' => $value
            ]);
        }

        foreach ([
            'Mampu membaca al-Qur\'an dengan fasih dan kaedah yang baik',
            'Hafal al-Qur\'an surah al-Ghasiyyah s/d an-Nas',
            'Membayar biaya pendaftaran',
            'Pas foto fisik berwarna ukuran 3x4 dan 2x2 (masing-masing 2 lembar)',
            'Pas foto digital berwarna rasio 3:4 berbaju seragam putih berlatarbelakang warna merah (Putra: bersongkok hitam, Putri: berjilbab putih)',
        ] as $value) {
            AdmissionSpecialRequirement::updateOrCreate([
                'admission_id' => $admission->id,
                'name' => $value
            ]);
        }
    }

    /**
     * Generate Admission Files
     *
     * @param [integer] $admission
     * @return void
     */
    public function generateAdmissionFiles($admission)
    {
        foreach ([
            ['Kartu Keluarga (KK)', null, '1', '1'],
            ['Kartu BSM', 'Wajib diunggah jika Anda ingin mengajukan sebagai santri mandiri (dokumen akan melalui proses screening dan verifikasi oleh tim)', '0', '1'],
            ['Surat Keterangan Tidak Mampu', 'Wajib diunggah jika Anda ingin mengajukan sebagai santri mandiri (dokumen akan melalui proses screening dan verifikasi oleh tim)', '0', '1'],
            ['Kartu KIP', 'Wajib diunggah jika Anda ingin mengajukan sebagai santri mandiri (dokumen akan melalui proses screening dan verifikasi oleh tim)', '0', '1'],
        ] as $v) {
            AdmissionFile::updateOrCreate([
                'admission_id' => $admission->id,
                'name' => $v[0],
                'description' => $v[1],
                'required' => $v[2]
            ]);
        }
    }

    /**
     * generate Admission Session
     *
     * @param [integer] $admission
     * @return void
     */
    public function generateAdmissionSession($admission)
    {
        foreach ([
            ['SESI 1', '08:00:00', '10:00:00'],
            ['SESI 2', '13:00:00', '14:00:00'],
        ] as $v) {
            AdmissionSession::updateOrCreate([
                'admission_id' => $admission->id,
                'name' => $v[0],
                'start_time' => $v[1],
                'end_time' => $v[2]
            ]);
        }

        $dates = ['2022-03-10', '2022-03-11', '2022-03-12', '2022-03-13'];
        foreach ($dates as $v) {
            AdmissionTestDate::updateOrCreate([
                'admission_id' => $admission->id,
                'date' => $v,
            ]);
        }

        DB::table('admission_tests')->update([
            'admission_id' => $admission->id
        ]);
    }
}
