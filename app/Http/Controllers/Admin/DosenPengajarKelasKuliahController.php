<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_dosen_pengajar_kelas_kuliah
};
use Session, DB;

class DosenPengajarKelasKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_kelas_kuliah)
    {
        return view('admin.pengajar_kelas_kuliah.index', compact('id_kelas_kuliah'));
    }

    public function data_index(Request $request, $id_kelas_kuliah)
    {
        $query = t_dosen_pengajar_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    "route" => route('admin.pengajar_kelas_kuliah.update', $data->id_aktivitas_mengajar),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.pengajar_kelas_kuliah.destroy', $data->id_aktivitas_mengajar),
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

    public function store(Request $request)
    {
        $records = $request->all();
        $result = InsertDataFeeder('InsertDosenPengajarKelasKuliah', $records);

        return $result;
    }

    public function update(Request $request, $id_aktivitas_mengajar)
    {
        $records = $request->all();
        $key = [
            'id_aktivitas_mengajar' => $id_aktivitas_mengajar,
        ];

        $result = UpdateDataFeeder('UpdateDosenPengajarKelasKuliah', $key, $records);

        return $result;
    }

    public function destroy(Request $request, $id_aktivitas_mengajar)
    {
        $key = [
            'id_aktivitas_mengajar' => $id_aktivitas_mengajar,
        ];
        
        $result = DeleteDataFeeder('DeleteDosenPengajarKelasKuliah', $key);

        return $result;
    }
}
