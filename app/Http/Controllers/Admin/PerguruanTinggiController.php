<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_perguruan_tinggi;
use App\Models\ref_wilayah;
use DB, Session;

class PerguruanTinggiController extends Controller
{
    public function index()
    {
        $data = m_perguruan_tinggi::find(1);
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id_wilayah');
        return view('admin.perguruan_tinggi.index', compact('data', 'wilayah'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'kode_perguruan_tinggi' => 'required|string',
            'nama_perguruan_tinggi' => 'required|string',
        ]);

        $data = m_perguruan_tinggi::find(1);

        DB::beginTransaction();

        try{
            if(! $data) {
                m_perguruan_tinggi::create($request->all());
            } else {
                $data->update($request->all());
            }

            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.perguruan_tinggi.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();    
        }
    }
}
