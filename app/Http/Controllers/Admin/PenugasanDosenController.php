<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    m_tahun_ajaran,
    m_program_studi,
    t_penugasan_dosen
};
use Session, DB;

class PenugasanDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi');
        $tahun_ajaran = m_tahun_ajaran::pluck('nama_tahun_ajaran', 'id_tahun_ajaran');
        return view('admin.penugasan_dosen.index', compact('prodi', 'tahun_ajaran'));
    }

    public function data_index(Request $request)
    {
        $query = t_penugasan_dosen::query()
                ->when($request->id_prodi, function ($query) use ($request) {
                    $query->where('id_prodi', $request->id_prodi);
                })
                ->when($request->id_tahun_ajaran, function ($query) use ($request) {
                    $query->where('id_tahun_ajaran', $request->id_tahun_ajaran);
                });

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    "route" => route('admin.penugasan_dosen.update', $data->id_registrasi_dosen),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.penugasan_dosen.destroy', $data->id_registrasi_dosen),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }
}
