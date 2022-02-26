<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KonfigurasiMenuRequest;
use App\Models\m_konfigurasi_menu;
use Illuminate\Http\Request;
use Session, DB;
use Illuminate\Support\Str;

class KonfigurasiMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = m_konfigurasi_menu::orderBy('urutan', 'asc')->get();

        return view('admin.konfigurasi_menu.index', compact('data'));
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
     * @param  KonfigurasiMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KonfigurasiMenuRequest $request)
    {
        DB::beginTransaction();

        try{
            $urutan_akhir = m_konfigurasi_menu::orderBy('urutan', 'desc')->first()->urutan ?? 0;

            $konfigurasi_menu = new m_konfigurasi_menu();
            $konfigurasi_menu->judul = $request->judul;
            $konfigurasi_menu->link = $request->link;
            $konfigurasi_menu->urutan = $urutan_akhir+1;
            $konfigurasi_menu->save();
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.konfigurasi_menu.index');

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
     * @param  KonfigurasiMenuRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KonfigurasiMenuRequest $request, m_konfigurasi_menu $konfigurasi_menu)
    {
        DB::beginTransaction();

        try{
            
            $konfigurasi_menu->judul = $request->judul;
            $konfigurasi_menu->link = $request->link;
            $konfigurasi_menu->update();
            
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.konfigurasi_menu.index');

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
    public function destroy(m_konfigurasi_menu $konfigurasi_menu)
    {
        if(is_null($konfigurasi_menu)){
            abort(404);
        }

        $konfigurasi_menu->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }

    public function updateOrder(Request $request){
        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));
            
            foreach($arr as $sortOrder => $id){
                $menu = m_konfigurasi_menu::find($id);
                $menu->urutan = $sortOrder;
                $menu->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
    }
}
