<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_mahasiswa;
use App\Models\m_program_studi;
use App\Models\ref_agama;
use App\Models\m_semester;
use App\Models\ref_jenis_tinggal;
use App\Models\ref_jenjang_pendidikan;
use App\Models\ref_kebutuhan_khusus;
use App\Models\ref_pekerjaan;
use App\Models\ref_penghasilan;
use App\Models\ref_alat_transportasi;
use App\Models\ref_wilayah;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\MahasiswaRequest;
use Session, DB, Auth;

class BiodataController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $agama = ref_agama::pluck('nama_agama', 'id');
        $jenis_tinggal = ref_jenis_tinggal::pluck('nama_jenis_tinggal', 'id');
        $jenjang_pendidikan = ref_jenjang_pendidikan::pluck('nama_jenjang_didik', 'id');
        $kebutuhan_khusus = ref_kebutuhan_khusus::pluck('nama_kebutuhan_khusus', 'id');
        $pekerjaan = ref_pekerjaan::pluck('nama_pekerjaan', 'id');
        $penghasilan = ref_penghasilan::pluck('nama_penghasilan', 'id');
        $alat_transportasi = ref_alat_transportasi::pluck('nama_jalat_transportasi', 'id');
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id');

        return view('mahasiswa.biodata.index', compact('agama', 'jenis_tinggal', 'jenjang_pendidikan', 'kebutuhan_khusus', 'pekerjaan', 'penghasilan', 'alat_transportasi', 'wilayah', 'mahasiswa'));
    }

    public function update(MahasiswaRequest $request)
    {
        DB::beginTransaction();

        $mahasiswa = Auth::user()->mahasiswa;

        try{
            $role_mahasiswa  = Role::where('name', 'mahasiswa')->first();

            $user = User::where('nim', $mahasiswa->nim)->first();
            $user->email = $request->nim;
            $user->name = $request->nama_mahasiswa;
            if($request->password){
                $user->password = bcrypt($request->password);
            }
            $user->update();

            $mahasiswa->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.mahasiswa.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }
}