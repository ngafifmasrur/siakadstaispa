<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_riwayat_pendidikan_mahasiswa,
    t_dosen_wali_mahasiswa,
    m_dosen
};
use Auth, Session, DB;

class DosenWaliController extends Controller
{
    public function index()
    {
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();
        if(!isset($mahasiswa)){
            Session::flash('error_msg', 'Mahasiswa tidak memiliki semester aktif / riwayat pendidikan');
            return view('mahasiswa.krs.index2');
        }
        $dosen_wali_aktif = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $mahasiswa->id_registrasi_mahasiswa)->pluck('id_dosen')->toArray();
        $list_dosen = m_dosen::setFilter([
            'limit' => "100000"
        ])->whereNotIn('id_dosen', $dosen_wali_aktif)->pluck('nama_dosen', 'id_dosen')->prepend('Pilih Dosen', NULL);

        $dosen_wali = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $mahasiswa->id_registrasi_mahasiswa)->first();
        if(isset($dosen_wali)) {
            $dosen = m_dosen::where('id_dosen', $dosen_wali->id_dosen)->first();
        } else {
            $dosen = null;
        }

        return view('mahasiswa.dosen_wali.index', compact('dosen', 'list_dosen'));
    }

    public function store(Request $request)
    {
        $rules = [];
        $rules['id_dosen'] = ['required'];
        $this->validate($request, $rules);

        $mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();

        DB::beginTransaction();

        try{

            $wali_mahasiswa = t_dosen_wali_mahasiswa::updateOrCreate(
                ['id_registrasi_mahasiswa' => $mahasiswa->id_registrasi_mahasiswa],
                ['id_dosen' => $request->id_dosen]
            );

            DB::commit();

            Session::flash('success_msg', 'Berhasil Disimpan');
            return redirect()->route('mahasiswa.dosen_wali.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }
}
