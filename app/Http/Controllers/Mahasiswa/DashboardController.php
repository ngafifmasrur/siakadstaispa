<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\m_kelas_kuliah;
use App\Models\m_mahasiswa;
use App\Models\t_peserta_kelas_kuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pesertaKelasKuliah = t_peserta_kelas_kuliah::where('id_mahasiswa', Auth::user()->id_mahasiswa)->get();
        $kelasKuliah = m_kelas_kuliah::where('id_mahasiswa', Auth::user()->id_mahasiswa)->get();

        return view('mahasiswa.dashboard', compact('kelasKuliah', 'pesertaKelasKuliah'));
    }
}
