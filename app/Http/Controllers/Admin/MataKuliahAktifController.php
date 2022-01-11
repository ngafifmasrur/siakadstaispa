<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_program_studi;
use App\Models\m_semester;
use App\Models\m_mata_kuliah;
use App\Models\m_mata_kuliah_aktif;
use App\Http\Requests\MataKuliahAktifRequest;
use Session, DB;

class MataKuliahAktifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matkul = m_mata_kuliah::pluck('nama_mata_kuliah', 'id');
        $semester = m_semester::pluck('nama_semester', 'id');
        return view('admin.mata_kuliah_aktif.index', compact('matkul', 'semester'));
    }

    public function data_index(Request $request)
    {
        $query = m_mata_kuliah_aktif::all();

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
                        'data-id_matkul' => $data->id_matkul,
                        'data-id_semester' => $data->id_semester,
                    ],
                    "route" => route('admin.mata_kuliah_aktif.update',['mata_kuliah_aktif' => $data->id]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.mata_kuliah_aktif.destroy',['mata_kuliah_aktif' => $data->id]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('nama_matkul', function ($data) {
                return $data->matkul->nama_mata_kuliah;
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
    public function store(MataKuliahAktifRequest $request)
    {
        DB::beginTransaction();

        try{
            
            $data = m_mata_kuliah_aktif::create($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.mata_kuliah_aktif.index');

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
    public function update(MataKuliahAktifRequest $request, m_mata_kuliah_aktif $mata_kuliah_aktif)
    {
        DB::beginTransaction();

        try{
            
            $mata_kuliah_aktif->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.mata_kuliah_aktif.index');

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
    public function destroy(m_mata_kuliah_aktif $mata_kuliah_aktif)
    {
        if(is_null($mata_kuliah_aktif)){
            abort(404);
        }

        $mata_kuliah_aktif->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
