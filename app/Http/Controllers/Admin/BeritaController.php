<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BeritaRequest;
use App\Models\m_berita;
use Illuminate\Http\Request;
use Session, DB;
use Illuminate\Support\Str;
use File;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.berita.index');
    }

    public function data_index(Request $request)
    {
        $query = m_berita::all();

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
                        'data-isi' => $data->isi,
                        'data-publish' => $data->publish,
                        'data-gambar' => url('upload/berita_img').'/'.$data->gambar
                    ],
                    "route" => route('admin.berita.update', $data->id),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.berita.destroy', $data->id),
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
     * @param  BeritaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BeritaRequest $request)
    {
        DB::beginTransaction();

        try{

            $file = $request->file('gambar');
            $filename =  Str::random(32).'.'.$file->getClientOriginalExtension();
	        $file->move('upload/berita_img',$filename);
            $berita = new m_berita();
            $berita->judul = $request->judul;
            $berita->isi = $request->isi;
            $berita->publish = $request->publish;
            $berita->hits = 0;
            $berita->gambar = $filename;
            $berita->save();
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.berita.index');

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
     * @param  BeritaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BeritaRequest $request, m_berita $berita)
    {
        DB::beginTransaction();

        try{
            
            $file = $request->file('gambar');
            if($file!=null){
                File::delete('upload/berita_img/'.$berita->gambar);
                $filename =  Str::random(32).'.'.$file->getClientOriginalExtension();
	            $file->move('upload/berita_img',$filename);
                $berita->judul = $request->judul;
                $berita->isi = $request->isi;
                $berita->publish = $request->publish;
                $berita->gambar = $filename;
                $berita->update();
                
            }else{
                $berita->judul = $request->judul;
                $berita->isi = $request->isi;
                $berita->publish = $request->publish;
                $berita->update();
            }
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.berita.index');

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
    public function destroy(m_berita $berita)
    {
        if(is_null($berita)){
            abort(404);
        }

        File::delete('upload/berita_img/'.$berita->gambar);
        $berita->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
