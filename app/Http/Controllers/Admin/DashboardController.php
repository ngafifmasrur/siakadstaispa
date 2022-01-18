<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_mahasiswa;
use App\Models\m_dosen;
use App\Models\m_program_studi;
use App\Models\t_krs;


class DashboardController extends Controller
{
    public function index()
    {
        $total_mhs = m_mahasiswa::count();
        $total_dosen = m_dosen::count();
        $total_prodi = m_program_studi::count();
        $total_krs_menunggu = t_krs::where('status', 'Menunggu')->distinct('nim')->count();
        $total_krs_diverifikasi = t_krs::where('status', 'Diverifikasi')->distinct('nim')->count();

        return view('admin.dashboard', compact('total_mhs', 'total_dosen', 'total_prodi', 'total_krs_diverifikasi', 'total_krs_menunggu'));
    }
}
