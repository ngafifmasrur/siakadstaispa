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
    m_mata_kuliah,
    t_matkul_kurikulum,
    t_dosen_wali_mahasiswa,
    m_dosen,
    t_perkuliahan_mahasiswa
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
        $semester = [];
        for ($smt=1; $smt <= 8; $smt++) {
            $semester[$smt] = 'Semester '.$smt;
        }

        return view('mahasiswa.histori_nilai.index', compact('semester'));
    }

    public function data_index(Request $request)
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;

        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first() ?? null;

        $matkul_kurikulum = t_matkul_kurikulum::setFilter([
            'filter' => "id_semester='$semester_aktif' AND id_prodi='$riwayat_pendidikan->id_prodi' AND semester='$request->semester'"
        ])->pluck('id_matkul')->toArray();

        $matkul_semester = t_matkul_kurikulum::setFilter([
            'filter' => "id_semester='$semester_aktif' AND id_prodi='$riwayat_pendidikan->id_prodi' AND semester='$request->semester'"
        ])->select('id_matkul', 'semester');

        if(isset($riwayat_pendidikan)) {
            $query = t_riwayat_nilai_mahasiswa::setFilter([
                'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa' AND id_periode='$semester_aktif'"
            ])->whereIn('id_matkul', $matkul_kurikulum)->get();

            $query->map(function ($item) use ($matkul_semester) {
                $matkul = m_mata_kuliah::setFilter([
                    'filter' => "id_matkul='$item->id_matkul'"
                ])->first();
                $item['kode_mata_kuliah'] = $matkul->kode_mata_kuliah;
                $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;
                $item['total_nilai'] = $matkul->sks_mata_kuliah*$item->nilai_indeks;
                $item['smt'] = $matkul_semester->where('id_matkul', $item->id_matkul)->first()->semester;

                return $item;
            });
        } else {
            $query = [];
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
        $semester_aktif = m_global_konfigurasi::first();
        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first() ?? null;
    
        $matkul_kurikulum = t_matkul_kurikulum::setFilter([
            'filter' => "id_semester='$semester_aktif->id_semester_aktif' AND id_prodi='$riwayat_pendidikan->id_prodi' AND semester='$request->semester'"
        ])->pluck('id_matkul')->toArray();

        $matkul_semester = t_matkul_kurikulum::setFilter([
            'filter' => "id_semester='$semester_aktif->id_semester_aktif' AND id_prodi='$riwayat_pendidikan->id_prodi' AND semester='$request->semester'"
        ])->select('id_matkul', 'semester');

        if(isset($riwayat_pendidikan)) {
            $nilai = t_riwayat_nilai_mahasiswa::setFilter([
                'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa' AND id_periode='$semester_aktif->id_semester_aktif'"
            ])->whereIn('id_matkul', $matkul_kurikulum)->get();

            $nilai->map(function ($item) use ($matkul_semester) {
                $matkul = m_mata_kuliah::setFilter([
                    'filter' => "id_matkul='$item->id_matkul'"
                ])->first();
                $item['kode_mata_kuliah'] = $matkul->kode_mata_kuliah;
                $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;
                $item['total_nilai'] = $matkul->sks_mata_kuliah*$item->nilai_indeks;
                $item['smt'] = $matkul_semester->where('id_matkul', $item->id_matkul)->first()->semester;

                return $item;
            });

        } else {
            $nilai = null;
        }

        $perkuliahan = t_perkuliahan_mahasiswa::setFilter([
            'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa' AND id_semester='$semester_aktif->id_semester_aktif'"
        ])->first();

        // Dosen Pembimbing
        $dosen_wali = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $riwayat_pendidikan->id_registrasi_mahasiswa)->first();
        if(isset($dosen_wali)) {
            $dosen = m_dosen::setFilter([
                'filter' => "id_dosen='$dosen_wali->id_dosen'"
            ])->first()->nama_dosen;
        } else {
            $dosen = '-';
        }
        
        $pdf = PDF::loadView('mahasiswa.histori_nilai.cetak', compact('riwayat_pendidikan', 'nilai', 'semester_aktif', 'dosen', 'perkuliahan'))->setPaper('a4');
        return $pdf->stream('Histori_-_Nilai-_-'.$riwayat_pendidikan->nama_mahasiswa.'.pdf');    
    }
}
