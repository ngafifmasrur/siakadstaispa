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
        $semester = m_semester::pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
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
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('nama_semester', function ($data) {
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
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            
            $data = m_kurikulum::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.kurikulum.index');

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
    public function update(Request $request, m_kurikulum $kurikulum)
    {
        DB::beginTransaction();

        try{
            
            $kurikulum->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.kurikulum.index');

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
    public function destroy(m_kurikulum $kurikulum)
    {
        if(is_null($kurikulum)){
            abort(404);
        }

        $kurikulum->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
