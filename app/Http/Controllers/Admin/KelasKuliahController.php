<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_kelas_kuliah;
use App\Models\m_program_studi;
use App\Models\m_mata_kuliah;
use App\Models\m_semester;
use App\Http\Requests\KelasKuliahRequest;
use Session, DB;

class KelasKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id');
        $semester = m_semester::pluck('nama_semester', 'id');
        $mata_kuliah = m_mata_kuliah::pluck('nama_mata_kuliah', 'id');

        return view('admin.kelas_kuliah.index', compact('prodi', 'semester', 'mata_kuliah'));
    }

    public function data_index(Request $request)
    {
        $query = m_kelas_kuliah::all();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fas fa-edit",
                    'attribute' => [
                        'data-nama' => $data->nama_kelas_kuliah,
                        'data-prodi' => $data->id_prodi,
                        'data-semester' => $data->id_semester,
                        'data-matkul' => $data->id_matkul,
                        'data-bahasan' => $data->bahasan,
                        'data-tanggal_mulai' => $data->tanggal_mulai_efektif,
                        'data-tanggal_akhir' => $data->tanggal_akhir_efektif,
                    ],
                    "route" => route('admin.kelas_kuliah.update',['kelas_kuliah' => $data->id]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fas fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.kelas_kuliah.destroy',['kelas_kuliah' => $data->id]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('matkul', function ($data) {
                return $data->mata_kuliah->nama_mata_kuliah;
            })
            ->addColumn('semester', function ($data) {
                return $data->semester->nama_semester;
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
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KelasKuliahRequest $request)
    {

        DB::beginTransaction();

        try{
            
            $data = m_kelas_kuliah::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.kelas_kuliah.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KelasKuliahRequest $request,m_kelas_kuliah $kelas_kuliah)
    {
        DB::beginTransaction();

        try{
            
            $kelas_kuliah->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.kelas_kuliah.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(m_kelas_kuliah $kelas_kuliah)
    {
        if(is_null($kelas_kuliah)){
            abort(404);
        }

        $kelas_kuliah->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
