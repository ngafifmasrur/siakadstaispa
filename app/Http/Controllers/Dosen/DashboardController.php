<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_jadwal;
use App\Models\t_semester_mahasiswa;
use App\Models\m_kelas_kuliah;
use Carbon\Carbon, Auth;

class DashboardController extends Controller
{
    protected $dosen;

    public function index()
    {
        // $jadwal_mengajar = m_jadwal::query()->where('id_dosen', Auth::user()->id_dosen)
        //                     ->with('kelas')
        //                     ->where('hari', Carbon::now()->isoFormat('dddd'));
        $total_jadwal_mengajar = m_jadwal::where('id_dosen', Auth::user()->dosen->id_dosen)->count();
        $total_mahasiswa_bimbingan = t_semester_mahasiswa::where('id_dosen_pembimbing', Auth::user()->dosen->id_dosen)->count();
        $jadwal_mengajar = m_jadwal::where('id_dosen', Auth::user()->id_dosen)->where('hari', Carbon::now()->isoFormat('dddd'))->get();
        return view('dosen.dashboard', compact('total_jadwal_mengajar', 'total_mahasiswa_bimbingan', 'jadwal_mengajar'));
    }
}
