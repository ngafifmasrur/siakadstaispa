<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_perkuliahan_mahasiswa
};
use Session, DB;

class PerkuliahanMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.perkuliahan_mahasiswa.index');
    }

    public function data_index(Request $request)
    {
        $query = t_perkuliahan_mahasiswa::query();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    "route" => route('admin.semester_mahasiswa.update', [$data->id_registrasi_mahasiswa, $data->id_semester]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.semester_mahasiswa.destroy', [$data->id_registrasi_mahasiswa, $data->id_semester]),
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
        $result = InsertDataFeeder('InsertPerkuliahanMahasiswa', $records);

        return $result;
    }

    public function update(Request $request, $id_registrasi_mahasiswa, $id_semester)
    {
        $records = $request->all();
        $key = [
            'id_registrasi_mahasiswa' => $id_registrasi_mahasiswa,
            'id_prodi' => $id_prodi
        ];

        $result = UpdateDataFeeder('UpdatePerkuliahanMahasiswa', $key, $records);

        return $result;
    }

    public function destroy(Request $request, $id_registrasi_mahasiswa, $id_semester)
    {
        $key = [
            'id_registrasi_mahasiswa' => $id_registrasi_mahasiswa,
            'id_prodi' => $id_prodi
        ];
        
        $result = DeleteDataFeeder('DeletePerkuliahanMahasiswa', $key);

        return $result;
    }
}
