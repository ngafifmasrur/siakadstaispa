<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\{
    t_jurnal_kuliah,
    t_absensi_mahasiswa,
    t_peserta_kelas_kuliah
};
use Auth, Session, DB;

class AbsenController extends Controller
{
    public function index($id_jurnal_kuliah)
    {
        // $decrypted_id_jurnal_kuliah = Crypt::decryptString($id_jurnal_kuliah);
        $jurnal_kuliah = t_jurnal_kuliah::findOrFail($id_jurnal_kuliah);

        $is_peserta = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$jurnal_kuliah->id_kelas_kuliah'",
        ])->where('id_mahasiswa', Auth::user()->id_mahasiswa)->first();

        if(!isset($is_peserta)){
            abort('403');
        }

        $absensi_mahasiswa = t_absensi_mahasiswa::where('id_jurnal_kuliah', $jurnal_kuliah->id)
        ->where('id_mahasiswa', Auth::user()->id_mahasiswa)->first();
        $status = [
            'Hadir' => 'Hadir',
            'Sakit' => 'Sakit',
            'Ijin'  => 'Ijin',
            'Alpa'  => 'Alpa'
        ];

        return view('mahasiswa.absen.index', compact('jurnal_kuliah', 'absensi_mahasiswa', 'status'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jurnal_kuliah' => 'required',
            'status' => 'required|in:Hadir,Sakit,Ijin,Alpa'
        ]);

        $jurnal_kuliah = t_jurnal_kuliah::findOrFail($request->id_jurnal_kuliah);

        DB::beginTransaction();

        try{

            t_absensi_mahasiswa::updateOrCreate(
                ['id_jurnal_kuliah' => $jurnal_kuliah->id, 'id_mahasiswa' => Auth::user()->id_mahasiswa],
                ['status' => $request->status]
            );
            

            DB::commit();

            Session::flash('success_msg', 'Berhasil melakukan absen!');
            return redirect()->route('mahasiswa.absen.index', $jurnal_kuliah->id);

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }
}
