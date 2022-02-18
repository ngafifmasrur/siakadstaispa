<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_riwayat_pendidikan_mahasiswa,
    t_riwayat_nilai_mahasiswa,
    m_global_konfigurasi,
    m_semester,
    m_mahasiswa,
    m_mata_kuliah
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session, DB, PDF;

class HistoriNilaiController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester');
        return view('mahasiswa.histori_nilai.index', compact('periode'));
    }

    public function data_index(Request $request)
    {
        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first() ?? null;

        if(isset($riwayat_pendidikan)) {
            $query = t_riwayat_nilai_mahasiswa::setFilter([
                'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa' AND id_periode='$request->periode'"
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
            $query = [];
        }

        return datatables()->of($query)
            ->addIndexColumn()
           ->addColumn('kode_mk',function ($data) {
                return $data->kode_mata_kuliah;
            })
            ->addColumn('sks_mata_kuliah',function ($data) {
                return $data->sks_mata_kuliah;
            })
            ->addColumn('total_nilai',function ($data) {
                return $data->total_nilai;
            })
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function cetak(Request $request)
    { 
        $periode = $request->periode;
        $user = Auth::user();
        $mahasiswa = m_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='$user->id_mahasiswa'"
        ])->first();

        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='$user->id_mahasiswa'"
        ])->first() ?? null;

        if(isset($riwayat_pendidikan)) {
            $nilai = t_riwayat_nilai_mahasiswa::setFilter([
                'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa' AND id_periode='$request->periode'"
            ])->get();
            $nama_semester = m_semester::setFilter([
                'filter' => "id_semester='$request->periode'"
            ])->first()->nama_semester;

            $nilai->map(function ($item) {
                $matkul = m_mata_kuliah::setFilter([
                    'filter' => "id_matkul='$item->id_matkul'"
                ])->first();
                $item['kode_mata_kuliah'] = $matkul->kode_mata_kuliah;
                $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;
                $item['total_nilai'] = $matkul->sks_mata_kuliah*$item->nilai_indeks;

                return $item;
            });

        } else {
            $nilai = null;
        }
        
        $pdf = PDF::loadView('mahasiswa.histori_nilai.cetak', compact('riwayat_pendidikan', 'mahasiswa', 'nilai', 'periode', 'nama_semester'))->setPaper('a4');
        return $pdf->stream('Histori_-_Nilai-_-'.$mahasiswa->nama_mahasiswa.'.pdf');    
    }
}
