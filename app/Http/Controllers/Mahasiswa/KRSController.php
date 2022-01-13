<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\t_krs;
use App\Models\t_semester_mahasiswa;
use App\Models\m_tahun_ajaran;
use App\Models\m_jadwal;
use Session, DB, Auth;

class KRSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tahun_ajaran)
    {
        $krs_mahasiswa = t_krs::where('nim', Auth::user()->mahasiswa->nim)
        ->select('id_jadwal')->get()->toArray();
        $jadwal = m_jadwal::whereNotIn('id', $krs_mahasiswa)->get();
        $list_tahun_ajaran = m_tahun_ajaran::pluck('id_tahun_ajaran', 'nama_tahun_ajaran');

        $semester_siswa = t_semester_mahasiswa::where('id_mahasiswa', Auth::user()->mahasiswa->id_mahasiswa)
                            ->where('id_tahun_ajaran', $tahun_ajaran)
                            ->where('status', 'Aktif')
                            ->first();

        if(is_null($semester_siswa)){
            Session::flash('error_msg', 'Mahasiswa tidak memiliki semester aktif');
            return view('mahasiswa.krs.index2', compact('tahun_ajaran'));
        }
        return view('mahasiswa.krs.index', compact('jadwal', 'tahun_ajaran', 'list_tahun_ajaran', 'semester_siswa'));
    }

    public function data_index(Request $request, $tahun_ajaran)
    {
        $query = t_krs::join('m_jadwal', 'm_jadwal.id', 'id_jadwal')
                        ->join('m_mata_kuliah_aktif', 'm_mata_kuliah_aktif.id', 'm_jadwal.id_matkul_aktif')
                        ->join('m_semester', 'm_semester.id_semester', 'm_mata_kuliah_aktif.id_semester')
                        ->where('nim', Auth::user()->mahasiswa->nim)
                        ->where('id_tahun_ajaran',$tahun_ajaran)
                        ->select('t_krs.*', 'm_semester.id_tahun_ajaran');

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('mahasiswa.krs.destroy', $data->id),
                ]);

    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('dosen', function ($data) {
                return $data->jadwal->dosen->nama_dosen;
            })
            ->addColumn('prodi', function ($data) {
                return $data->jadwal->prodi->nama_program_studi;
            })
            ->addColumn('kode_matkul', function ($data) {
                return $data->jadwal->matkul->matkul->kode_mata_kuliah;
            })
            ->addColumn('matkul', function ($data) {
                return $data->jadwal->matkul->matkul->nama_mata_kuliah;
            })
            ->addColumn('sks', function ($data) {
                return $data->jadwal->matkul->matkul->sks_mata_kuliah;
            })
            ->addColumn('kelas', function ($data) {
                return $data->jadwal->kelas->nama_kelas_kuliah;
            })
            ->addColumn('ruangan', function ($data) {
                return $data->jadwal->ruangan->nama_ruangan;
            })
            ->addColumn('jadwal', function ($data) {
                return $data->jadwal->hari.', '.$data->jadwal->jam_mulai.' - '.$data->jadwal->jam_akhir;
            })
            ->addColumn('status',function ($data) {
                if($data->status == 'Menunggu') {
                    $button = view("components.button.default", [
                        'type' => 'button',
                        'tooltip' => 'Status',
                        'class' => 'btn btn-primary btn-sm',
                        "label" => "Belum Disetujui",
                    ]);
                } elseif ($data->status == 'Disetujui') {
                    $button = view("components.button.default", [
                        'type' => 'button',
                        'tooltip' => 'Status',
                        'class' => 'btn btn-success btn-sm',
                        "label" => "Disetujui",
                    ]);
                } else {
                    $button = view("components.button.default", [
                        'type' => 'button',
                        'tooltip' => 'Status',
                        'class' => 'btn btn-danger btn-sm',
                        "label" => "Ditolak",
                    ]);
                }
                return $button;
            })
            ->rawColumns(['action', 'status'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try{
            
            $list_jadwal = $request->input('jadwal');
            foreach($list_jadwal as $jadwal){
                t_krs::create([
                    'id_jadwal' => $jadwal,
                    'nim' => Auth::user()->mahasiswa->nim,
                    'status' => 'Menunggu'
                ]);
            }
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(t_krs $kr)
    {
        if(is_null($kr)){
            abort(404);
        }

        $kr->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }

    public function ajukan(Request $request, $tahun_ajaran)
    {

        $krs_mahasiswa = t_krs::join('m_jadwal', 'm_jadwal.id', 'id_jadwal')
                        ->join('m_mata_kuliah_aktif', 'm_mata_kuliah_aktif.id', 'm_jadwal.id_matkul_aktif')
                        ->join('m_semester', 'm_semester.id_semester', 'm_mata_kuliah_aktif.id_semester')
                        ->join('m_mata_kuliah', 'm_mata_kuliah.id_matkul', 'm_mata_kuliah_aktif.id_matkul')
                        ->where('nim', Auth::user()->mahasiswa->nim)
                        ->where('id_tahun_ajaran',$tahun_ajaran)
                        ->select('t_krs.*', 'm_semester.id_tahun_ajaran', 'm_mata_kuliah.sks_mata_kuliah')
                        ->count();

        if($krs_mahasiswa <= 0) {
            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }

        $total_sks = t_krs::join('m_jadwal', 'm_jadwal.id', 'id_jadwal')
        ->join('m_mata_kuliah_aktif', 'm_mata_kuliah_aktif.id', 'm_jadwal.id_matkul_aktif')
        ->join('m_semester', 'm_semester.id_semester', 'm_mata_kuliah_aktif.id_semester')
        ->join('m_mata_kuliah', 'm_mata_kuliah.id_matkul', 'm_mata_kuliah_aktif.id_matkul')
        ->where('nim', Auth::user()->mahasiswa->nim)
        ->where('id_tahun_ajaran',$tahun_ajaran)
        ->select('t_krs.*', 'm_semester.id_tahun_ajaran', 'm_mata_kuliah.sks_mata_kuliah')
        ->sum('m_mata_kuliah.sks_mata_kuliah');
        

        DB::beginTransaction();

        try{
            
            $semester_siswa = t_semester_mahasiswa::where('id_mahasiswa', Auth::user()->mahasiswa->id_mahasiswa)
                                ->where('id_tahun_ajaran', $tahun_ajaran)
                                ->where('status', 'Aktif')
                                ->first();

            $semester_siswa->update([
                'sks' => $total_sks,
                'status_krs' => 'Mengajukan'
            ]);

            DB::commit();

            Session::flash('success_msg', 'Berhasil Diajukan');
            return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return dd($e);
        }
    }

}
