<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_periode_perkuliahan,
    m_program_studi,
    m_semester,
};
use Session, DB;

class PeriodePerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::orderBy('nama_semester','DESC')->pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        return view('admin.periode_perkuliahan.index', compact('prodi', 'semester'));
    }

    public function data_index(Request $request)
    {
        $query = t_periode_perkuliahan::query()
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
                        'data-id_prodi' => $data->id_prodi,
                        'data-id_semester' => $data->id_semester,
                        'data-jumlah_target_mahasiswa_baru' => $data->jumlah_target_mahasiswa_baru,
                        'data-tanggal_awal_perkuliahan' => $data->tanggal_awal_perkuliahan,
                        'data-tanggal_akhir_perkuliahan' => $data->tanggal_akhir_perkuliahan,
                    ],
                    "route" => route('admin.periode_perkuliahan.update', [$data->id_prodi, $data->id_semester]),
                ]);
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.periode_perkuliahan.destroy', [$data->id_prodi, $data->id_semester]),
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
        $result = InsertDataFeeder('InsertPeriodePerkuliahan', $records, 'GetListPeriodePerkuliahan');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function update(Request $request, $id_prodi, $id_semester)
    {
        $records = $request->except('_token', '_method');
        $key = [
            'id_semester' => intval($id_semester),
            'id_prodi' => $id_prodi
        ];

        $result = UpdateDataFeeder('UpdatePeriodePerkuliahan', $key, $records, 'GetListPeriodePerkuliahan');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function destroy(Request $request, $id_prodi, $id_semester)
    {
        $key = [
            'id_semester' => intval($id_semester),
            'id_prodi' => $id_prodi
        ];
        
        $result = DeleteDataFeeder('DeletePeriodePerkuliahan', $key, 'GetListPeriodePerkuliahan');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

}
