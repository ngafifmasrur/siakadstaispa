<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_jadwal;
use App\Models\m_tahun_ajaran;
use App\Models\m_semester;
use App\Models\t_krs;
use App\Http\Requests\Dosen\KontrakRequest;
use Session, DB;

class JadwalMengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun_ajaran = m_tahun_ajaran::where('a_periode_aktif', 1)->pluck('nama_tahun_ajaran', 'id_tahun_ajaran')->prepend('Pilih Tahun Ajaran', NULL);
        $semester = m_semester::pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        return view('dosen.jadwal_mengajar.index', compact('tahun_ajaran', 'semester'));
    }

    public function data_index(Request $request)
    {
        $query = m_jadwal::query()
                ->select('m_jadwal.*', 'm_tahun_ajaran.id_tahun_ajaran', 'm_mata_kuliah_aktif.id_semester')
                ->join('m_mata_kuliah_aktif', 'm_mata_kuliah_aktif.id', 'm_jadwal.id_matkul_aktif')
                ->join('m_semester', 'm_semester.id_semester', 'm_mata_kuliah_aktif.id_semester')
                ->join('m_tahun_ajaran', 'm_tahun_ajaran.id_tahun_ajaran', 'm_semester.id_tahun_ajaran')
                ->when($request->semester, function ($query) use ($request) {
                    $query->where('m_mata_kuliah_aktif.id_semester', $request->semester);
                })->when($request->tahun_ajaran, function ($query) use ($request) {
                    $query->where('m_tahun_ajaran.id_tahun_ajaran', $request->tahun_ajaran);
                })->withCount('krs');

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {    

                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Daftar Peserta',
                    'class' => 'btn btn-outline-primary btn-xs',
                    "icon" => "fa fa-users",
                    "label" => "Daftar Peserta",
                    "route" => route('dosen.jadwal_mengajar.daftar_peserta', $data->id),
                ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Kontrak',
                    'class' => 'btn btn-outline-danger btn_edit btn-xs',
                    "icon" => "fa fa-edit",
                    "label" => "Kontrak",
                    'attribute' => [
                        'data-kontrak_belajar' => $data->kontrak_belajar,
                        'data-path_kontrak_belajar' => load_from_local($data->path_kontrak_belajar),
                        'data-path_rpp' => load_from_local($data->path_rpp)
                    ],
                    "route" => route('dosen.jadwal_mengajar.update', $data->id),
                ]);
    
                return $button;
            })
            ->addColumn('kode_matkul', function ($data) {
                return $data->matkul->matkul->kode_mata_kuliah ?? '';
            })
            ->addColumn('nama_matkul', function ($data) {
                return $data->matkul->matkul->nama_mata_kuliah ?? '';
            })
            ->addColumn('ruangan', function ($data) {
                return $data->ruangan->nama_ruangan ?? '';
            })
            ->addColumn('dosen', function ($data) {
                return $data->dosen->nama_dosen ?? '';
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi ?? '';
            })
            ->addColumn('kelas', function ($data) {
                return $data->kelas->nama_kelas_kuliah ?? '';
            })
            ->addColumn('jadwal', function ($data) {
                return $data->hari.', '.$data->jam_mulai.' - '.$data->jam_akhir;
            })
            ->addColumn('jumlah_peserta', function ($data) {
                return $data->krs_count;
            })
            ->rawColumns(['action'])
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
