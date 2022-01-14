<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\t_krs;
use App\Models\t_semester_mahasiswa;
use App\Models\m_jadwal;
use Session, DB, Auth;


class VervalKRSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwal = m_jadwal::all();
        return view('dosen.verval_krs.index', compact('jadwal'));
    }

    public function data_index(Request $request)
    {
        $query = t_semester_mahasiswa::query()
                ->where('status_krs', 'Mengajukan');

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Verifikasi KRS',
                    'class' => 'btn btn-outline-success btn-sm',
                    "icon" => "fa fa-check",
                    "route" => route('dosen.krs.index', [$data->mahasiswa->id_mahasiswa, $data->detail_semester->id_semester]),
                ]);

                return $button;
            })
            ->addColumn('mahasiswa', function ($data) {
                return $data->mahasiswa->nama_mahasiswa;
            })
            ->addColumn('nim_mahasiswa', function ($data) {
                return $data->mahasiswa->nim;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('sks', function ($data) {
                return $data->sks ?? 0;
            })
            ->rawColumns(['action'])
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
    public function update_status(Request $request, t_krs $krs)
    {
        if(is_null($krs)){
            abort(404);
        }

        switch ($request->status) {
            case 'Setujui':
                $status = 'Disetujui';
                break;
            default:
                $status = 'Ditolak';
                break;          
        }

        $krs->update(['status' => $status]);

        Session::flash('success_msg', 'Status Berhasil Diubah');
        return back();
    }
}
