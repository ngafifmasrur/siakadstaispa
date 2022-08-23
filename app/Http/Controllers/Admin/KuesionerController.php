<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\KuesionerRequest;
use App\Models\m_kuesioner;
use Session, DB;

class KuesionerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kuesioner.index');
    }

    public function data_index(Request $request)
    {
        $query = m_kuesioner::all();

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
                        'data-kuesioner' => $data->kuesioner,
                        'data-jenis' => $data->jenis,
                        'data-status' => $data->status
                    ],
                    "route" => route('admin.kuesioner.update', $data->id),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.kuesioner.destroy', $data->id),
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
    public function store(KuesionerRequest $request)
    {
        DB::beginTransaction();

        try{
            
            $data = m_kuesioner::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.kuesioner.index');

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
    public function update(KuesionerRequest $request, m_kuesioner $kuesioner)
    {
        DB::beginTransaction();

        try{
            
            $kuesioner->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.kuesioner.index');

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
    public function destroy(m_kuesioner $kuesioner)
    {
        if(is_null($kuesioner)){
            abort(404);
        }

        $kuesioner->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
