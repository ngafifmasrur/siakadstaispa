<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\{
    t_peserta_kelas_kuliah,
    m_mahasiswa,
    m_kelas_kuliah,
    m_global_konfigurasi,
    m_jadwal,
    t_dosen_wali_mahasiswa,
    t_riwayat_pendidikan_mahasiswa,
    m_dosen,
    m_informasi,
    t_krs_mahasiswa
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class DashboardController extends Controller
{
    public function index()
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();
        if(!isset($riwayat_pendidikan)){
            Session::flash('error_msg', 'Mahasiswa tidak memiliki semester aktif / riwayat pendidikan');
            return view('mahasiswa.krs.index2');
        }

        $status_krs = t_krs_mahasiswa::where('id_registrasi_mahasiswa', $riwayat_pendidikan->id_registrasi_mahasiswa)->first();

        if(isset($status_krs) && $status_krs->status == 'Diverifikasi') {
            $pesertaKelasKuliah = t_peserta_kelas_kuliah::setFilter([
                'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
            ])->pluck('id_kelas_kuliah')->toArray();
            
            $kelasKuliah = m_kelas_kuliah::setFilter([
                'filter' => "id_semester='$semester_aktif'"
            ])->whereIn('id_kelas_kuliah', $pesertaKelasKuliah)->get();
    
            $kelasKuliah->map(function ($item){
                $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();
                $item['hari'] = $jadwal->hari ?? null;
                $item['jam_mulai'] = $jadwal->jam_mulai ?? null;
                $item['jam_akhir'] = $jadwal->jam_akhir ?? null;
                return $item;
            });
        } else {
            $kelasKuliah = null;
        }

        $dosen_wali = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $riwayat_pendidikan->id_registrasi_mahasiswa)->first();
        if(isset($dosen_wali)) {
            $dosen = m_dosen::setFilter([
                'limit' => "100000"
            ])->where('id_dosen', $dosen_wali->id_dosen)->first()->nama_dosen;
        } else {
            $dosen = 'Belum memiliki dosen wali';
        }

        $informasi = m_informasi::where('status', 1)->get();

        return view('mahasiswa.dashboard', compact('kelasKuliah', 'dosen', 'informasi', 'status_krs'));
    }
}
