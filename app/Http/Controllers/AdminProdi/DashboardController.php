<?php

namespace App\Http\Controllers\AdminProdi;

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
        $total_krs_menunggu = t_krs::byProdi()->where('status', 'Menunggu')->distinct('nim')->count();
        $total_krs_diverifikasi = t_krs::byProdi()->where('status', 'Diverifikasi')->distinct('nim')->count();

        return view('admin_prodi.dashboard', compact('total_krs_diverifikasi', 'total_krs_menunggu'));
    }
}
