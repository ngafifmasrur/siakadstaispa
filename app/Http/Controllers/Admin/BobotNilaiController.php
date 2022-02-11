<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_program_studi;
use App\Models\m_skala_nilai_prodi;
use App\Http\Requests\BobotNilaiRequest;
use Session, DB;

class BobotNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi');
        return view('admin.bobot_nilai.index', compact('prodi'));
    }

    public function data_index(Request $request)
    {
        $query = m_skala_nilai_prodi::setFilter([
            'filter' => "id_prodi='$request->id_prodi'"
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
                    'attribute' => [
                        'data-nilai_huruf' => $data->nilai_huruf,
                        'data-prodi' => $data->id_prodi,
                        'data-nilai_indeks' => $data->nilai_indeks,
                        'data-bobot_minimum' => $data->bobot_minimum,
                        'data-bobot_maksimum' => $data->bobot_maksimum,
                        'data-tanggal_mulai' => $data->tanggal_mulai_efektif,
                        'data-tanggal_selesai' => $data->tanggal_akhir_efektif,
                    ],
                    "route" => route('admin.bobot_nilai.update',['bobot_nilai' => $data->id_bobot_nilai]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.bobot_nilai.destroy',['bobot_nilai' => $data->id_bobot_nilai]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->nama_program_studi;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $records = $request->except('_token', '_method');
        $result = InsertDataFeeder('InsertSkalaNilaiProdi', $records, 'GetListSkalaNilaiProdi');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bobot_nilai)
    {
        $records = $request->except('_token', '_method');
        $key = [
            'id_bobot_nilai' => $bobot_nilai
        ];

        $result = UpdateDataFeeder('UpdateSkalaNilaiProdi', $key, $records, 'GetListSkalaNilaiProdi');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Diupdate');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bobot_nilai)
    {
        $key = [
            'id_bobot_nilai' => $bobot_nilai
        ];
        
        $result = DeleteDataFeeder('DeleteSkalaNilaiProdi', $key, 'GetListSkalaNilaiProdi');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Dihapus');
        return redirect()->back();
    }
}
