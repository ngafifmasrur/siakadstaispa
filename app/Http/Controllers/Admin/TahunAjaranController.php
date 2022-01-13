<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_tahun_ajaran;
use App\Http\Requests\TahunAjaranRequest;
use Session, DB;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tahun_ajaran.index');
    }

    public function data_index(Request $request)
    {
        $query = m_tahun_ajaran::all();

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
                        'data-id_tahun_ajaran' => $data->id_tahun_ajaran,
                        'data-nama_tahun_ajaran' => $data->nama_tahun_ajaran,
                        'data-nama_semester' => $data->nama_semester,
                        'data-a_periode_aktif' => $data->a_periode_aktif,
                        'data-tanggal_mulai' => $data->tanggal_mulai,
                        'data-tanggal_selesai' => $data->tanggal_selesai,
                    ],
                    "route" => route('admin.tahun_ajaran.update', $data->id_tahun_ajaran),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.tahun_ajaran.destroy', $data->id_tahun_ajaran),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('aktif', function ($data) {
                return $data->a_periode_aktif ? 'Aktif' : 'Tidak Aktif';
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
    public function store(TahunAjaranRequest $request)
    {
        DB::beginTransaction();

        try{
            
            $data = m_tahun_ajaran::create($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.tahun_ajaran.index');

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
    public function update(TahunAjaranRequest $request, m_tahun_ajaran $tahun_ajaran)
    {
        DB::beginTransaction();

        try{
            
            $tahun_ajaran->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.tahun_ajaran.index');

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
    public function destroy(m_tahun_ajaran $tahun_ajaran)
    {
        if(is_null($tahun_ajaran)){
            abort(404);
        }

        $tahun_ajaran->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
