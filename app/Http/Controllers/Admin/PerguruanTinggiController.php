<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_perguruan_tinggi;
use App\Models\ref_wilayah;
use Session;

class PerguruanTinggiController extends Controller
{
    public function index()
    {
        $data = 'data';
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id');
        return view('admin.perguruan_tinggi.index', compact('data', 'wilayah'));
    }

    public function update(Request $request)
    {

    }
}
