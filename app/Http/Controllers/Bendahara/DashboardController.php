<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_mahasiswa;
use App\Models\m_dosen;

class DashboardController extends Controller
{
    public function index()
    {
        $total_mhs = m_mahasiswa::count_total();
        $total_dosen = m_dosen::count_total();

        return view('bendahara.dashboard', compact('total_mhs', 'total_dosen'));
    }
}
