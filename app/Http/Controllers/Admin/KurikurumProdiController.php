<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_matkul_kurikulum,
    m_kurikulum,
    m_program_studi,
    m_semester,
    m_mata_kuliah
};
use Session, DB;

class KurikurumProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $kurikulum = m_kurikulum::pluck('nama_kurikulum', 'id_kurikulum')->prepend('Pilih Kurikulum', NULL);
        return view('admin.kurikulum_prodi.index', compact('prodi', 'kurikulum'));
    }

    public function data_index(Request $request, $id_kurikulum, $id_prodi)
    {
        $query = t_matkul_kurikulum::where('id_kurikulum', $id_kurikulum)
                ->where('id_prodi', $id_prodi)
                ->where('semester', $request->semester)
                ->get();
               

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
                    "route" => route('admin.kurikulum_prodi.destroy',[$data->id_kurikulum, $data->id_matkul]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
           ->addColumn('apakah_wajib', function ($data) {
                return $data->apakah_wajib ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>';
            })
            ->rawColumns(['action', 'apakah_wajib'])
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
    public function create(m_kurikulum $id_kurikulum, m_program_studi $id_prodi)
    {
        $table_semester = t_matkul_kurikulum::setFilter([
            'filter' => "id_kurikulum='$id_kurikulum->id_kurikulum' AND id_prodi='$id_prodi->id_prodi'"
        ])->pluck('semester', 'semester');

        $matkul = m_mata_kuliah::setFilter([
            'filter' => "id_prodi='$id_prodi->id_prodi'"
        ])->get()
                ->map(function($data) {
                    return [
                        'id_matkul'    => $data->id_matkul,
                        'matkul_kode'  => $data->matkul_kode
                    ];
                })->pluck('matkul_kode', 'id_matkul')->prepend('Pilih Mata Kuliah', NULL);

        return view('admin.kurikulum_prodi.create', compact('matkul', 'id_prodi', 'id_kurikulum', 'table_semester'));
    }

    public function store(Request $request)
    {
        $semester = m_semester::where('id_semester', $request->id_semester)->value('semester');
        $records = $request->except('_token', '_method', 'id_semester', 'id_prodi');
        $records['semester'] = $semester;

        $result = InsertDataFeeder('InsertMatkulKurikulum', $records, 'GetListKurikulum');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function destroy(Request $request, $id_kurikulum, $id_matkul)
    {
        $key = [
            'id_kurikulum' => $id_kurikulum,
            'id_matkul' => $id_matkul

        ];
        
        $result = DeleteDataFeeder('DeleteMatkulKurikulum', $key);

        return $result;
    }

    public function kurikulum_by_prodi(Request $request)
    {
        if (!$request->id_prodi) {
            $kurikulum = null;
        } else {
            $kurikulum = m_kurikulum::setFilter([
                'filter' => "id_prodi='$request->id_prodi'"
            ])->get();
        }

        return response()->json($kurikulum);
    }
}
