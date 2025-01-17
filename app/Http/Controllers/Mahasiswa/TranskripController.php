<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_riwayat_pendidikan_mahasiswa,
    t_transkrip_mahasiswa,
    m_global_konfigurasi,
    m_semester,
    m_mata_kuliah,
    m_mahasiswa_lulus_do,
    m_dosen,
    t_dosen_wali_mahasiswa
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session, DB, PDF;

class TranskripController extends Controller
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

        // $mahasiwa = t_riwayat_pendidikan_mahasiswa::setFilter([
        //     'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        // ])->first()->id_registrasi_mahasiswa;
        // if(!isset($mahasiwa)){
        //     Session::flash('error_msg', 'Mahasiswa tidak memiliki semester aktif / riwayat pendidikan');
        //     return view('mahasiswa.krs.index2');
        // }

        $periode = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester');
        
        return view('mahasiswa.transkrip.index', compact('periode'));
    }

    public function data_index(Request $request)
    {

        $id_registrasi_mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first()->id_registrasi_mahasiswa;

        if(!isset($riwayat_pendidikan)) {
            $query = t_transkrip_mahasiswa::setFilter([
                'filter' => "id_registrasi_mahasiswa='$id_registrasi_mahasiswa'"
            ])->get();

            $query->map(function ($item){
                $matkul = m_mata_kuliah::setFilter([
                    'filter' => "id_matkul='$item->id_matkul'"
                ])->first();
                $item['kode_mata_kuliah'] = $matkul->kode_mata_kuliah;
                $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;
                $item['total_nilai'] = $matkul->sks_mata_kuliah*$item->nilai_indeks;

                return $item;
            });

        } else {
            $query = null;
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->setRowAttr([
                'style' => 'text-align: center',
            ])

            ->toJson();
    }

    public function cetak(Request $request)
    { 
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $dosen_wakil = m_global_konfigurasi::first()->wakil_ketua_bidang_akademik;
        $nama_semester_aktif = m_global_konfigurasi::first()->nama_semester_aktif;

        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();

        $mahasiswa_lulus = m_mahasiswa_lulus_do::setFilter([
            'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa'"
        ])->first();

        $transkrip = t_transkrip_mahasiswa::setFilter([
            'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa'"
        ])->get();

        $total_semester = t_transkrip_mahasiswa::setFilter([
            'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa'"
        ])->max('smt_diambil');

        $transkrip->map(function ($item){
            $item['total_nilai'] = number_format($item->sks_mata_kuliah*$item->nilai_indeks, 2);

            return $item;
        });

        // Dosen Pembimbing
        $dosen_wali = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $riwayat_pendidikan->id_registrasi_mahasiswa)->first();
        if(isset($dosen_wakil)) {
            $dosen = $dosen_wakil;
        } else {
            $dosen = '-';
        }

        $pdf = PDF::loadView('mahasiswa.transkrip.cetak', compact('dosen', 'total_semester', 'riwayat_pendidikan', 'transkrip', 'nama_semester_aktif', 'mahasiswa_lulus'))->setPaper('a4');
        return $pdf->stream('Transkrip-_-'.$riwayat_pendidikan->nama_mahasiswa.'.pdf');    
    }
}
