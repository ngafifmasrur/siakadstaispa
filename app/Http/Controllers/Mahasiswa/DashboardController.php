<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\{
    t_peserta_kelas_kuliah,
    m_mahasiswa,
    m_kelas_kuliah,
    m_global_konfigurasi,
    m_jadwal
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $pesertaKelasKuliah = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->pluck('id_kelas_kuliah')->toArray();
        
        $kelasKuliah = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_kelas_kuliah', $pesertaKelasKuliah)->get();

        $kelasKuliah->map(function ($item){
            $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kulaih)->first();
            $item['hari'] = $item->hari;
            $item['jam_mulai'] = $item->jam_mulai;
            $item['jam_akhir'] = $item->jam_akhir;
            return $item;
        });

        return view('mahasiswa.dashboard', compact('kelasKuliah'));
    }
}
