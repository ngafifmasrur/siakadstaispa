<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KonfigurasiRequest;
use App\Models\m_konfigurasi;
use Illuminate\Http\Request;
use Session, DB;

class KonfigurasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = [
            'url_feeder_pd_dikti' => 'URL Feeder PD Dikti',
            'username_feeder_pd_dikti' => 'Username Feeder PD Dikti',
            'password_feeder_pd_dikti' => 'Password Feeder PD Dikti'
        ];

        return view('admin.konfigurasi.index', compact('options'));
    }

    public function data_index(Request $request)
    {
        $query = m_konfigurasi::all();

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
                        'data-variable' => $data->variable,
                        'data-value' => $data->value
                    ],
                    "route" => route('admin.konfigurasi.update', $data->id),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.konfigurasi.destroy', $data->id),
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
     * @param  KonfigurasiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KonfigurasiRequest $request)
    {
        DB::beginTransaction();

        try{
            
            $data = m_konfigurasi::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.konfigurasi.index');

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
     * @param  KonfigurasiRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KonfigurasiRequest $request, m_konfigurasi $konfigurasi)
    {
        DB::beginTransaction();

        try{
            
            $konfigurasi->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.konfigurasi.index');

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
    public function destroy(m_konfigurasi $konfigurasi)
    {
        if(is_null($konfigurasi)){
            abort(404);
        }

        $konfigurasi->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
