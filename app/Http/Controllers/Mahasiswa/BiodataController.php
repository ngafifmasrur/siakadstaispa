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
use App\Models\ref_detail_mahasiswa;
use App\Models\ref_negara;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\MahasiswaRequest;
use Session, DB, Auth;

class BiodataController extends Controller
{
    public function index()
    {
        $mahasiswa = ref_detail_mahasiswa::where('id_mahasiswa', Auth::user()->id_mahasiswa)->first();
        
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        $jenis_tinggal = ref_jenis_tinggal::pluck('nama_jenis_tinggal', 'id_jenis_tinggal');
        $jenjang_pendidikan = ref_jenjang_pendidikan::pluck('nama_jenjang_didik', 'id_jenjang_didik');
        $kebutuhan_khusus = ref_kebutuhan_khusus::pluck('nama_kebutuhan_khusus', 'id_kebutuhan_khusus');
        $pekerjaan = ref_pekerjaan::pluck('nama_pekerjaan', 'id_pekerjaan');
        $penghasilan = ref_penghasilan::pluck('nama_penghasilan', 'id_penghasilan');
        $alat_transportasi = ref_alat_transportasi::pluck('nama_alat_transportasi', 'id_alat_transportasi');
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id_wilayah');
        $negara = ref_negara::pluck('nama_negara', 'id_negara');

        return view('mahasiswa.biodata.index', compact('negara', 'agama', 'jenis_tinggal', 'jenjang_pendidikan', 'kebutuhan_khusus', 'pekerjaan', 'penghasilan', 'alat_transportasi', 'wilayah', 'mahasiswa'));
    }

    public function update(Request $request)
    {

        $records = $request->except('_token', '_method');
        $key['id_mahasiswa'] = Auth::user()->id_mahasiswa;
        $result = UpdateDataFeeder('UpdateBiodataMahasiswa', $key, $records, 'GetBiodataMahasiswa');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Update Berhasil');
        return redirect()->back();
    }
}
