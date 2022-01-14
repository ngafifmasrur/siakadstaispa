<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\t_krs;
use App\Models\m_jadwal;
use App\Models\t_semester_mahasiswa;
use Session, DB, Auth;

class KRSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_mahasiswa, $id_semester)
    {
        $jadwal = m_jadwal::all();
        $semester_mahasiswa = t_semester_mahasiswa::where('id_mahasiswa', $id_mahasiswa)
                                ->where('id_semester', $id_semester)
                                ->first();
        return view('dosen.krs.index', compact('jadwal', 'id_mahasiswa', 'id_semester', 'semester_mahasiswa'));
    }

    public function data_index(Request $request, $id_mahasiswa, $id_semester)
    {
        $query = t_krs::join('m_jadwal', 'm_jadwal.id', 'id_jadwal')
        ->join('m_mata_kuliah_aktif', 'm_mata_kuliah_aktif.id', 'm_jadwal.id_matkul_aktif')
        ->join('m_semester', 'm_semester.id_semester', 'm_mata_kuliah_aktif.id_semester')
        ->join('m_mahasiswa', 'm_mahasiswa.nim', 't_krs.nim')
        ->where('m_mahasiswa.id_mahasiswa', $id_mahasiswa)
        ->where('m_semester.id_semester', $id_semester)
        ->select('t_krs.*', 'm_semester.id_semester', 'm_mahasiswa.id_mahasiswa');

        return datatables()->of($query)
            ->addIndexColumn()
            // ->addColumn('action',function ($data) {
           
            //     $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
            //     $button .= view("components.button.default", [
            //         'type' => 'button',
            //         'tooltip' => 'Setujui',
            //         'class' => 'btn btn-outline-success btn-sm btn_setujui',
            //         "icon" => "fa fa-check",
            //         'attribute' => [
            //             'data-text' => 'Anda yakin ingin mengubah status KRS ini ?',
            //             'data-status' => 'Setujui',
            //         ],
            //         "route" => route('dosen.krs.update_status', $data->id),
            //         "disabled" => ($data->status == 'Disetujui') ? 'disabled' : 'enabled',
            //     ]);

            //     $button .= view("components.button.default", [
            //         'type' => 'button',
            //         'tooltip' => 'Belum Disetujui',
            //         'class' => 'btn btn-outline-danger btn-sm btn_setujui',
            //         "icon" => "fa fa-times",
            //         'attribute' => [
            //             'data-text' => 'Anda yakin ingin mengubah status KRS ini ?',
            //             'data-status' => 'Tolak',
            //         ],
            //         "route" => route('dosen.krs.update_status', $data->id),
            //         "disabled" => ($data->status == 'Ditolak') ? 'disabled' : 'enabled',
            //     ]);
    
            //     $button .= '</div>';
    
            //     return $button;
            // })
            ->addColumn('mahasiswa', function ($data) {
                return $data->mahasiswa->nama_mahasiswa;
            })
            ->addColumn('nim_mahasiswa', function ($data) {
                return $data->mahasiswa->nim;
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

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request, $id_mahasiswa, $id_semester)
    {
        $semester_mahasiswa = t_semester_mahasiswa::where('id_mahasiswa', $id_mahasiswa)
                            ->where('id_semester', $id_semester)
                            ->first();
        if(is_null($semester_mahasiswa)){
            abort(404);
        }

        switch ($request->status) {
            case 'Setujui':
                $status = 'Diverifikasi';
                break;
            default:
                $status = 'Ditolak';
                break;          
        }

        $semester_mahasiswa->update([
            'status_krs' => $status,
            'catatan_krs' => $request->catatan_krs
        ]);
        Session::flash('success_msg', 'Status Berhasil Diubah');
        return back();
    }
}
