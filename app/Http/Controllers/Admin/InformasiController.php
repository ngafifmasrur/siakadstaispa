<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InformasiRequest;
use App\Models\m_informasi;
use Illuminate\Http\Request;
use Session, DB;
use Illuminate\Support\Str;
use File;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.informasi.index');
    }

    public function data_index(Request $request)
    {
        $query = m_informasi::all();

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
                        'data-judul' => $data->judul,
                        'data-isi' => $data->informasi,
                        'data-status' => $data->status,
                    ],
                    "route" => route('admin.informasi.update', $data->id),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.informasi.destroy', $data->id),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('status',function ($data) {
                return $data->status == 1 ? 'Published' : 'Unpublished';
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
     * @param  InformasiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InformasiRequest $request)
    {
        DB::beginTransaction();

        try{

            $informasi = new m_informasi();
            $informasi->judul = $request->judul;
            $informasi->informasi = $request->informasi;
            $informasi->status = $request->status;
            $informasi->save();
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.informasi.index');

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
     * @param  InformasiRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformasiRequest $request, m_informasi $beinformasirita)
    {
        DB::beginTransaction();

        try{
            
                $informasi->judul = $request->judul;
                $informasi->informasi = $request->informasi;
                $informasi->status = $request->status;
                $informasi->update();
            
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.informasi.index');

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
    public function destroy(m_informasi $informasi)
    {
        if(is_null($informasi)){
            abort(404);
        }

        $informasi->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
