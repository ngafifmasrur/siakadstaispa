<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\t_krs;
use App\Models\m_jadwal;
use Session, DB, Auth;

class KRSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $krs_mahasiswa = t_krs::where('nim', Auth::user()->mahasiswa->nim)
        ->select('id_jadwal')->get()->toArray();
        $jadwal = m_jadwal::whereNotIn('id', $krs_mahasiswa)->get();
        return view('mahasiswa.krs.index', compact('jadwal'));
    }

    public function data_index(Request $request)
    {
        $query = t_krs::where('nim', Auth::user()->mahasiswa->nim)->get();

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
            ->addColumn('matkul', function ($data) {
                return $data->jadwal->matkul->matkul_semester;
            })
            ->addColumn('kelas', function ($data) {
                return $data->jadwal->kelas->nama_kelas_kuliah;
            })
            ->addColumn('ruangan', function ($data) {
                return $data->jadwal->ruangan->nama_ruangan;
            })
            ->addColumn('hari', function ($data) {
                return $data->jadwal->hari;
            })
            ->addColumn('jam_mulai', function ($data) {
                return $data->jadwal->jam_mulai;
            })
            ->addColumn('jam_selesai', function ($data) {
                return $data->jadwal->jam_akhir;
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

}
