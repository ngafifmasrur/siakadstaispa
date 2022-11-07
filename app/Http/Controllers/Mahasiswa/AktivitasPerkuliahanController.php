<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    m_aktivitas_kuliah_mahasiswa,
    m_global_konfigurasi,
    t_dosen_wali_mahasiswa,
    t_riwayat_nilai_mahasiswa,
    t_riwayat_pendidikan_mahasiswa,
    m_dosen,
    m_mata_kuliah,
    t_matkul_kurikulum
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session, DB, PDF;

class AktivitasPerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check_feeder = t_riwayat_pendidikan_mahasiswa::count_total();
        if($check_feeder == 0) {
            Session::flash('error_msg', 'Aplikasi SIAKAD sedang mengalami gangguan, coba lagi nanti.');
            return view('mahasiswa.krs.index2'); 
        }
        $mahasiwa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();
        if(!isset($mahasiwa)){
            Session::flash('error_msg', 'Mahasiswa tidak memiliki semester aktif / riwayat pendidikan');
            return view('mahasiswa.krs.index2');
        }
        return view('mahasiswa.aktivitas_perkuliahan.index');
    }

    public function data_index(Request $request)
    {
        $user = Auth::user();
        $semester = m_global_konfigurasi::first()->value('id_semester_aktif');
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first() ?? null;

        $query = m_aktivitas_kuliah_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'KHS',
                    'class' => 'btn btn-outline-primary btn-sm',
                    "icon" => "fa fa-print",
                    "label" => "Cetak KHS",
                    "route" => route('mahasiswa.aktivitas_perkuliahan.khs', $data->id_semester),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function khs($semester)
    { 
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first() ?? null;

        $perkuliahan = m_aktivitas_kuliah_mahasiswa::setFilter([
            'filter' => "id_registrasi_mahasiswa='$mahasiswa->id_registrasi_mahasiswa' AND id_semester='$semester'"
        ])->first();

        $matkul_semester = t_matkul_kurikulum::setFilter([
            'filter' => "id_prodi='$mahasiswa->id_prodi'"
        ])->select('id_matkul', 'semester')->get();

        $nilai = t_riwayat_nilai_mahasiswa::setFilter([
            'filter' => "id_registrasi_mahasiswa='$mahasiswa->id_registrasi_mahasiswa' AND id_periode='$semester'"
        ])->get();

        $nilai->map(function ($item) use ($matkul_semester){
            $matkul = m_mata_kuliah::setFilter([
                'limit' => "1000000"
            ])->where('id_matkul', $item->id_matkul)->first();
            $item['kode_mata_kuliah'] = $matkul->kode_mata_kuliah;
            $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;
            $item['total_nilai'] = $matkul->sks_mata_kuliah*$item->nilai_indeks;
            $item['smt'] = $matkul_semester->where('id_matkul', $item->id_matkul)->first()->semester ?? '-';

            return $item;
        });

        $ips = $perkuliahan->ips ?? null;
        if(isset($ips)) {
            switch (true) {
                case ($ips >= 3.00):
                    $maksimal_sks = 24;
                break;
                case ($ips >= 2.50 && $ips <= 2.99):
                    $maksimal_sks = 21;
                break;
                case ($ips >= 2.00 && $ips <= 2.49):
                    $maksimal_sks = 18;
                break;
                case ($ips >= 1.50 && $ips <= 1.99):
                    $maksimal_sks = 15;
                break;
                case ($ips <= 1.50):
                    $maksimal_sks = 12;
                break;
                }
        } else {
            $maksimal_sks = '-';
        }

        // Dosen Pembimbing
        $dosen_wali = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $mahasiswa->id_registrasi_mahasiswa)->first();
        if(isset($dosen_wali)) {
            $dosen = m_dosen::setFilter([
                'filter' => "id_dosen='$dosen_wali->id_dosen'"
            ])->where('id_dosen', $dosen_wali->id_dosen)->first()->nama_dosen;
        } else {
            $dosen = '-';
        }
        
        $pdf = PDF::loadView('mahasiswa.aktivitas_perkuliahan.cetak', compact('semester', 'maksimal_sks', 'mahasiswa', 'nilai', 'dosen', 'perkuliahan'))->setPaper('a4');
        return $pdf->stream('Histori_-_Nilai-_-'.$mahasiswa->nama_mahasiswa.'.pdf');    
    }
}
