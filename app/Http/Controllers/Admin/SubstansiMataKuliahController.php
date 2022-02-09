<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_substansi_mata_kuliah,
    m_program_studi,
    m_semester,
    ref_jenis_evaluasi
};
use Session, DB;

class SubstansiMataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $jenis_evaluasi = ref_jenis_evaluasi::pluck('nama_jenis_evaluasi', 'id_jenis_evaluasi')->prepend('Pilih Jenis Evaluasi', NULL);

        return view('admin.substansi_mata_kuliah.index', compact('prodi', 'jenis_evaluasi'));
    }

    public function data_index(Request $request)
    {
        $query = t_substansi_mata_kuliah::query()
        ->when($request->prodi, function ($query) use ($request) {
            $query->where('id_prodi', $request->prodi);
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
                    'attribute' => [
                        'data-id_prodi' => $data->id_prodi,
                        'data-nama_substansi' => $data->nama_substansi,
                        'data-sks_mata_kuliah' => $data->sks_mata_kuliah,
                        'data-sks_tatap_muka' => $data->sks_tatap_muka,
                        'data-sks_praktek' => $data->sks_praktek,
                        'data-sks_simulasi' => $data->sks_simulasi,
                        'data-sks_praktek_lapangan' => $data->sks_praktek_lapangan,
                        'data-id_jenis_substansi' => $data->id_jenis_substansi,
                    ],
                    "route" => route('admin.substansi_mata_kuliah.update', $data->id_substansi),
                ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.substansi_mata_kuliah.destroy', $data->id_substansi),
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
        $records = $request->except('_token', '_method');
        $result = InsertDataFeeder('InsertSubstansiKuliah', $records, 'GetListSubstansiKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function update(Request $request, $substansi_mata_kuliah)
    {
        $records = $request->except('_token', '_method');
        $key = [
            'id_substansi' => $substansi_mata_kuliah
        ];

        $result = UpdateDataFeeder('UpdateSubstansiKuliah', $key, $records, 'GetListSubstansiKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Diupdate');
        return redirect()->back();
    }

    public function destroy(Request $request, $substansi_mata_kuliah)
    {
        $key = [
            'id_substansi' => $substansi_mata_kuliah
        ];
        
        $result = DeleteDataFeeder('DeleteSubstansiKuliah', $key, 'GetListSubstansiKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Dihapus');
        return redirect()->back();
    }
}
