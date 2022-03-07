<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    m_global_konfigurasi,
    m_kelas_kuliah,
    t_dosen_pengajar_kelas_kuliah,
    m_jadwal,
    m_informasi
};
use Carbon\Carbon, Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $pengajaraKelasKuliah = t_dosen_pengajar_kelas_kuliah::setFilter([
                                    'filter' => "id_dosen='".Auth::user()->id_dosen."'"
                                ])
                                ->where('id_dosen', Auth::user()->id_dosen)
                                ->pluck('id_kelas_kuliah')->toArray();
        
        $kelasKuliah = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_kelas_kuliah', $pengajaraKelasKuliah)->get();
        
        $kelasKuliah->map(function ($item){
            $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();
            $item['hari'] = $jadwal->hari ?? null;
            $item['jam_mulai'] = $jadwal->jam_mulai ?? null;
            $item['jam_akhir'] = $jadwal->jam_akhir ?? null;
            $item['link_zoom'] = $jadwal->link_zoom ?? null;
            return $item;
        });

        $informasi = m_informasi::where('status', 1)->get();

        return view('dosen.dashboard', compact('kelasKuliah', 'informasi'));
    }
}
