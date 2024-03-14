<?php

namespace Modules\Admission\Http\Controllers;

use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Models\AdmissionCBT;
use Modules\Admission\Models\RegistrantCBT;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
	/**
     * Instance the main property.
     */
    protected $repo;

    /**
     * Create a new controller instance.
     */
    public function __construct(AdmissionRegistrantRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display home.
     */
    public function index()
    {
    	$this->authorize('registration', Admission::class);

    	$registrant = $this->repo->getCurrentUser();
        $admission_cbt = AdmissionCBT::where('admission_cbt.admission_id', $registrant->admission_id)->get();
        $admission_cbt->map(function ($item) use ($registrant){
            $item['status_registrant_cbt'] = RegistrantCBT::where('registrant_id', $registrant->id)
            ->where('cbt_id', $item->id)->first()->status ?? 0;

            return $item;
        });
        $status_cbt = count($registrant->admission->cbts) > 0 &&
             (count($registrant->admission->cbts) == count($registrant->cbts->where('status', 2)));


    	return view('admission::home.index', compact('registrant', 'admission_cbt', 'status_cbt'));
    }

    /**
     * Export the admission form.
     */
    public function form(AdmissionRegistrant $registrant)
    {
        $this->authorize('view', $registrant);

        $user = $registrant->user;
        $files = $registrant->admission->files->load([
                        'registrants' => function($query) use ($registrant) {
                            $query->where('registrant_id', $registrant->id);
                        }
                    ]);
        $personal = [
            'IDENTITAS' => [
                'Nama lengkap' =>  $user->profile->full_name,
                'Tempat, tanggal lahir' =>  $user->profile->pdob,
                'NIK' =>  $user->profile->nik ?? null,
                'No.KK' =>  $user->profile->nokk ?? null,
                'NISN' =>  $user->profile->nisn ?? null,
                'Jenis kelamin' =>  $user->profile->sex !== null ? config('web.references.sexes')[$user->profile->sex] : null,
                'Golongan darah' =>  $user->profile->blood !== null ? config('web.references.bloods')[$user->profile->blood] : null,
                'Kewarganegaraan' =>  $user->profile->country->name ?? null
            ],
            'KONTAK' => [
                'No. Telp/HP' => $user->phone->number.($user->phone->whatsapp ? ' (WA)' : ''),
                'Alamat e-mail' => $user->email->address,
                'Alamat' => $user->address->branch,
                'Regional' => $user->address->regional,
                'Kode pos' => $user->address->postal,
            ],
            'LAINNYA' => [
                'Jenis Pendaftaran' =>  $registrant->is_saman ? 'Santri Mandiri (SAMAN)' : 'REGULER',
                'Tanggal ke pondok' =>  $registrant->tanggal_kedatangan ?? '-',
            ],
        ];

        $ttdparent = array_filter([
            !$user->father->is_dead ? $user->father->name : null,
            !$user->mother->is_dead ? $user->mother->name : null,
        ]);

        if($registrant->is_saman == 0) {
            $parent = [
                'INFORMASI AYAH' => [
                    'NIK ayah' => $user->father->nik ?: null,
                    'Nama ayah' => ($user->father->is_dead ? 'ALM. ' : '').$user->father->name ?? null,
                    'Tempat, tanggal lahir' => $user->father->pdob ?? null,
                    'Pendidikan terakhir' => $user->father->grade->name ?? null,
                    'Pekerjaan' => $user->father->employment->name ?? null,
                    'Penghasilan/bulan' => $user->father->salary->name ?? null,
                ],
                'INFORMASI IBU' => [
                    'NIK ibu' => $user->mother->nik ?: null,
                    'Nama ibu' => ($user->mother->is_dead ? 'ALM. ' : '').$user->mother->name ?? null,
                    'Tempat, tanggal lahir' => $user->mother->pdob ?? null,
                    'Pendidikan terakhir' => $user->mother->grade->name ?? null,
                    'Pekerjaan' => $user->mother->employment->name ?? null,
                    'Penghasilan/bulan' => $user->mother->salary->name ?? null,
                ],
                'PEMBAYARAN' => [
                    'Biaya Pendidikan' => 'Rp. 1.700.000',
                    'Biaya Pesantren' => 'Rp. 1.300.000',
                    'Total' => 'Rp. 3.000.000',
                    'Status Pembayaran' => $registrant->paid_off_at ? 'LUNAS' : 'Belum melakukan pembayaran / Belum Diverifikasi',
                ],
            ];
        } else {
            $parent = [
                'INFORMASI AYAH' => [
                    'NIK ayah' => $user->father->nik ?: null,
                    'Nama ayah' => ($user->father->is_dead ? 'ALM. ' : '').$user->father->name ?? null,
                    'Tempat, tanggal lahir' => $user->father->pdob ?? null,
                    'Pendidikan terakhir' => $user->father->grade->name ?? null,
                    'Pekerjaan' => $user->father->employment->name ?? null,
                    'Penghasilan/bulan' => $user->father->salary->name ?? null,
                ],
                'INFORMASI IBU' => [
                    'NIK ibu' => $user->mother->nik ?: null,
                    'Nama ibu' => ($user->mother->is_dead ? 'ALM. ' : '').$user->mother->name ?? null,
                    'Tempat, tanggal lahir' => $user->mother->pdob ?? null,
                    'Pendidikan terakhir' => $user->mother->grade->name ?? null,
                    'Pekerjaan' => $user->mother->employment->name ?? null,
                    'Penghasilan/bulan' => $user->mother->salary->name ?? null,
                ],
            ];
        }

        $admission = [
            'DETAIL PENDAFTARAN' => [
                'Tahun' =>  $registrant->admission->period->name,
                'Jalur pendaftaran' =>  $registrant->admission->name,
                'Nama' =>  $user->profile->name,
                'Tempat, tanggal lahir' =>  $user->profile->pdob,
                'Nomor pendaftaran' =>  $registrant->kd,
                'Tanggal tes' =>  $registrant->test_at ? strtoupper($registrant->test_at->formatLocalized('%A, %d %B %Y')) : null,
                'Sesi tes' =>  $registrant->session->name. ' ('.$registrant->session->range.')',
                'Terdaftar pada' =>  $registrant->created_at->formatLocalized('%d %B %Y pukul %H:%M'),
            ]
        ];

        $cbts = $registrant->cbts->where('status', 2);

        // Profile Photo
        $gambar = $registrant->avatar ? Storage::disk('public')->url($registrant->avatar) : asset('assets/img/img-blank-3-4.png');

        $pdf = \PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('admission::home.form', compact('registrant', 'user', 'files', 'personal', 'ttdparent', 'parent', 'admission', 'cbts', 'gambar'))
                    ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed'=> TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        return $pdf->download('FORMULIR-PENDAFTARAN-'.$registrant->kd.'.pdf');
    }
}
