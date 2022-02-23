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
    m_mahasiswa_lulus_do
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
        ])->distinct('smt_diambil')->count();

        $transkrip->map(function ($item){
            $item['total_nilai'] = $item->sks_mata_kuliah*$item->nilai_indeks;

            return $item;
        });

        
        $pdf = PDF::loadView('mahasiswa.transkrip.cetak', compact('total_semester', 'riwayat_pendidikan', 'transkrip', 'nama_semester_aktif', 'mahasiswa_lulus'))->setPaper('a4');
        return $pdf->stream('Transkrip-_-'.$riwayat_pendidikan->nama_mahasiswa.'.pdf');    
    }
}
