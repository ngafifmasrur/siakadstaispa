<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_jadwal;
use App\Models\t_semester_mahasiswa;
use Carbon\Carbon, Auth;

class DashboardController extends Controller
{
    protected $dosen;

    public function index()
    {
        $jadwal_mengajar = m_jadwal::query()->where('id_dosen', Auth::user()->dosen->id_dosen)
                            ->select('m_jadwal.*', 'm_mata_kuliah.kode_mata_kuliah', 'm_mata_kuliah.nama_mata_kuliah')
                            ->join('m_mata_kuliah_aktif', 'm_mata_kuliah_aktif.id', 'm_jadwal.id_matkul_aktif')
                            ->join('m_mata_kuliah', 'm_mata_kuliah.id_matkul', 'm_mata_kuliah_aktif.id_matkul')
                            ->where('hari', Carbon::now()->isoFormat('dddd'))->withCount('krs');
        $total_jadwal_mengajar = m_jadwal::where('id_dosen', Auth::user()->dosen->id_dosen)->count();
        $total_mahasiswa_bimbingan = t_semester_mahasiswa::where('id_dosen_pembimbing', Auth::user()->dosen->id_dosen)->count();
        
        return view('dosen.dashboard', compact('total_jadwal_mengajar', 'total_mahasiswa_bimbingan', 'jadwal_mengajar'));
    }
}
