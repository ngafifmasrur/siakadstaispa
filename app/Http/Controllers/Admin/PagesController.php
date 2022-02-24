<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Models\m_page;
use Session, DB;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.page.index');
    }

    public function data_index(Request $request)
    {
        $query = m_page::all();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm',
                    "icon" => "fa fa-edit",
                    "route" => route('admin.page.edit', $data->id),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.page.destroy', $data->id),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('link',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Lihat',
                    'class' => 'btn btn-primary btn-sm',
                    "icon" => "fa fa-eye",
                    "label" => "Lihat",
                    "route" => route('landing_page.page', $data->slug),
                ]);

                return $button;
            })
            ->addColumn('status',function ($data) {
                return $data->is_active == 1 ? 'Published' : 'Unpublished';
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
        return view('admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        DB::beginTransaction();

        try{

            $slug = $request->input('judul');
            $slug = Str::slug($slug, '-');
            $results = DB::select(DB::raw("SELECT count(*) as total from m_page where slug REGEXP '^{$slug}(-[0-9]+)?$' "));
            $finalSlug = ($results['0']->total > 0) ? "{$slug}-{$results['0']->total}" : $slug;

            $page = new m_page();
            $page->judul = $request->judul;
            $page->slug = $finalSlug;
            $page->content = $request->content;
            $page->is_active = $request->is_active ?? 0;
            $page->save();
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.page.index');

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
    public function edit(m_page $page)
    {
        return view('admin.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, m_page $page)
    {
        DB::beginTransaction();

        try{
            

            $page->judul = $request->judul;
            $page->content = $request->content;
            $page->is_active = $request->is_active ?? 0;
            $page->update();
            
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.page.index');

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
    public function destroy(m_page $page)
    {
        if(is_null($page)){
            abort(404);
        }

        $berita->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
