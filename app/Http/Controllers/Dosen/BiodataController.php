<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_dosen;
use App\Models\ref_agama;
use App\Models\ref_wilayah;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\DosenRequest;
use Session, DB, Auth;

class BiodataController extends Controller
{
    public function index()
    {
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id_wilayah');
        $dosen = Auth::user()->dosen;
        return view('dosen.biodata.index', compact('agama', 'wilayah', 'dosen'));
    }

    public function update(DosenRequest $request)
    {
        DB::beginTransaction();

        $dosen = Auth::user()->dosen;

        try{

            $dosen->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }
}
