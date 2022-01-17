<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_jadwal;
use App\Models\m_tahun_ajaran;
use App\Models\m_semester;
use App\Models\t_krs;
use App\Http\Requests\JadwalRequest;
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
}
