<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_kurikulum;
use App\Models\m_semester;
use App\Models\m_program_studi;
use Session, DB;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        return view('admin.kurikulum.index', compact('prodi', 'semester'));
    }

    public function data_index(Request $request)
    {
        $query = m_kurikulum::query()
        ->when($request->prodi, function ($query) use ($request) {
            $query->where('id_prodi', $request->prodi);
        })
        ->when($request->semester, function ($query) use ($request) {
            $query->where('id_semester', $request->semester);
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
                        'data-nama' => $data->nama_kurikulum,
                        'data-prodi' => $data->id_prodi,
                        'data-semester' => $data->id_semester,
                        'data-sks_lulus' => $data->jumlah_sks_lulus,
                        'data-sks_wajib' => $data->jumlah_sks_wajib,
                        'data-sks_pilihan' => $data->jumlah_sks_pilihan,
                    ],
                    "route" => route('admin.kurikulum.update',['kurikulum' => $data->id_kurikulum]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.kurikulum.destroy',['kurikulum' => $data->id_kurikulum]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('nama_program_studi', function ($data) {
                return $data->nama_program_studi;
            })
            ->addColumn('nama_semester', function ($data) {
                return $data->semester_mulai_berlaku;
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
        $result = InsertDataFeeder('InsertKurikulum', $records, 'GetListKurikulum');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function update(Request $request, $kurikulum)
    {
        $records = $request->except('_token', '_method');
        $key = [
            'id_kurikulum' => $kurikulum
        ];

        $result = UpdateDataFeeder('UpdateKurikulum', $key, $records, 'GetListKurikulum');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Diupdate');
        return redirect()->back();
    }

    public function destroy(Request $request, $kurikulum)
    {
        $key = [
            'id_kurikulum' => $kurikulum
        ];
        
        $result = DeleteDataFeeder('DeleteKurikulum', $key, 'GetListKurikulum');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Dihapus');
        return redirect()->back();
    }
}
