<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_jadwal;
use App\Models\m_kelas_kuliah;
use App\Models\m_dosen;
use App\Models\m_program_studi;
use App\Models\m_mata_kuliah_aktif;
use App\Models\m_ruang_kelas;
use App\Models\m_tahun_ajaran;
use App\Models\m_skala_nilai_prodi;
use App\Models\m_semester;
use App\Models\t_krs;
use App\Http\Requests\JadwalRequest;
use Session, DB;

class NilaiController extends Controller
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
        return view('dosen.pengisian_nilai.index', compact('tahun_ajaran', 'semester'));
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

        // $krs = t_krs::query();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {    

                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Isi Nilai',
                    'class' => 'btn btn-outline-primary btn-xs',
                    "icon" => "fa fa-pencil",
                    "label" => "Form Nilai",
                    "route" => route('dosen.pengisian_nilai.form_nilai', $data->id),
                ]);
    
                return $button;
            })
            ->addColumn('kode_matkul', function ($data) {
                return $data->matkul->matkul->kode_mata_kuliah;
            })
            ->addColumn('nama_matkul', function ($data) {
                return $data->matkul->matkul->nama_mata_kuliah;
            })
            ->addColumn('ruangan', function ($data) {
                return $data->ruangan->nama_ruangan;
            })
            ->addColumn('dosen', function ($data) {
                return $data->dosen->nama_dosen;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('kelas', function ($data) {
                return $data->kelas->nama_kelas_kuliah;
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

    public function form_nilai($id_jadwal)
    {
        // $nilai = m_skala_nilai_prodi::whereBetween();
        $peserta = t_krs::where('id_jadwal', $id_jadwal)->get();
        $id_prodi = m_jadwal::find($id_jadwal)->id_prodi;

        return view('dosen.pengisian_nilai.form_nilai', compact('peserta', 'id_prodi'));
    }

    public function store_nilai(Request $request)
    {

        DB::beginTransaction();

        try{
            
            // $nilai = [];

            $peserta = $request->except('_token', 'id_prodi');
            foreach ($peserta as $ID => $nilai) {

                if($nilai > 100 || $nilai < 0){
                    Session::flash('error_msg', 'Nilai tidak boleh lebih dari 100.');
                    return redirect()->back()->withInput();
                }

                $nilai_huruf =  m_skala_nilai_prodi::where('id_prodi', $request->id_prodi)
                                ->whereRaw('? between bobot_minimum and bobot_maksimum', [$nilai])->first()->nilai_huruf;

                if(!$nilai_huruf){
                    Session::flash('error_msg', 'Skala Nilai tidak ditemukan.');
                    return redirect()->back()->withInput();
                }

                t_krs::find($ID)->update([
                    'nilai_angka' => $nilai,
                    'nilai_huruf' => $nilai_huruf,
                    'updated_at' => now(),
                ]);
            }
    
            DB::commit();

            Session::flash('success_msg', 'Penilaian Berhasil!');
            return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return dd($e);
        }
    }
}
