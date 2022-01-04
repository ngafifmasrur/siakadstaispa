<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_program_studi;
use App\Models\m_mata_kuliah;
use Session, DB;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id');
        $jenis_matkul = $this->jenis_matkul;
        $kelompok_matkul = $this->kelompok_matkul;
        return view('admin.mata_kuliah.index', compact('prodi', 'jenis_matkul', 'kelompok_matkul'));
    }

    public function data_index(Request $request)
    {
        $jenis_matkul = $this->jenis_matkul;
        $kelompok_matkul = $this->kelompok_matkul;
        $query = m_mata_kuliah::all();

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
                        'data-nama' => $data->nama_mata_kuliah,
                        'data-prodi' => $data->id_prodi,
                    ],
                    "route" => route('admin.mata_kuliah.update',['mata_kuliah' => $data->id]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fas fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.mata_kuliah.destroy',['mata_kuliah' => $data->id]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('jenis', function ($data) use ($jenis_matkul) {
                return $jenis_matkul[$data->id_jenis_mata_kuliah];
            })
            ->addColumn('kelompok', function ($data) use ($kelompok_matkul) {
                return $kelompok_matkul[$data->id_kelompok_mata_kuliah];
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
        DB::beginTransaction();

        try{
            
            $data = m_mata_kuliah::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.mata_kuliah.index');

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,m_mata_kuliah $mata_kuliah)
    {
        DB::beginTransaction();

        try{
            
            $mata_kuliah->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.mata_kuliah.index');

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
    public function destroy(m_mata_kuliah $mata_kuliah)
    {
        if(is_null($mata_kuliah)){
            abort(404);
        }

        $mata_kuliah->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
