<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_jadwal;
use App\Models\t_dosen_pengajar_kelas_kuliah;
use App\Models\m_semester;
use App\Models\m_program_studi;
use App\Http\Requests\Dosen\KontrakRequest;
use Session, DB, Auth;

class JadwalMengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        return view('dosen.jadwal_mengajar.index', compact('prodi', 'semester'));
    }

    public function data_index(Request $request)
    {
        $query = t_dosen_pengajar_kelas_kuliah::query()
                ->where('id_dosen', Auth::user()->id_dosen)
                ->when($request->prodi, function($q) use ($request){
                    $q->where('id_prodi', $request->prodi);
                })
                ->when($request->semester, function($q) use ($request){
                    $q->where('id_semester', $request->semester);
                });

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('nama_semester', function ($data) {
                return $data->kelas_kuliah->nama_semester;
            })
            ->addColumn('nama_program_studi', function ($data) {
                return $data->kelas_kuliah->nama_program_studi;
            })
            ->addColumn('nama_mata_kuliah', function ($data) {
                return $data->kelas_kuliah->nama_mata_kuliah;
            })
            ->addColumn('nama_kelas_kuliah', function ($data) {
                return $data->kelas_kuliah->nama_kelas_kuliah;
            })
            ->addColumn('ruang', function ($data) {
                return  $data->kelas_kuliah->ruangan ?? '-';
            })
            ->addColumn('hari', function ($data) {
                return $data->kelas_kuliah->hari ?? '-';
            })
            ->addColumn('waktu', function ($data) {
                return $data->kelas_kuliah->jam_mulai ?? ''.' - '.$data->kelas_kuliah->jam_akhir ?? '';
            })
            ->addColumn('jumlah_mahasiswa', function ($data) {
                return $data->kelas_kuliah->jumlah_mahasiswa;
            })
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function daftar_peserta($id_jadwal)
    {
        $peserta = t_krs::where('id_jadwal', $id_jadwal)->get();

        return view('dosen.jadwal_mengajar.daftar_peserta', compact('peserta'));
    }

    public function update(KontrakRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $data = $request->except('path_kontrak_belajar', 'path_rpp');

            $m_jadwal = m_jadwal::findOrFail($id);

            if ($request->hasFile('path_kontrak_belajar')) {
                remove_in_local($m_jadwal->path_kontrak_belajar);

                $data['path_kontrak_belajar'] = upload_in_local('path_kontrak_belajar', $request->file('path_kontrak_belajar'), 'path_kontrak_belajar');
            }

            if ($request->hasFile('path_rpp')) {
                remove_in_local($m_jadwal->path_rpp);

                $data['path_rpp'] = upload_in_local('path_rpp', $request->file('path_rpp'), 'path_rpp');
            }

            $m_jadwal->update($data);
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('dosen.jadwal_mengajar.index');
        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }
}
