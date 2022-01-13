<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_semester;
use App\Models\m_tahun_ajaran;
use App\Http\Requests\SemesterRequest;
use Session, DB;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun_ajaran = m_tahun_ajaran::pluck('nama_tahun_ajaran', 'id_tahun_ajaran')->prepend('Pilih Tahun Ajaran', NULL);
        return view('admin.semester.index', compact('tahun_ajaran'));
    }

    public function data_index(Request $request)
    {
        $query = m_semester::all();

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
                        'data-nama_semester' => $data->nama_semester,
                        'data-semester' => $data->semester,
                        'data-a_periode_aktif' => $data->a_periode_aktif,
                        'data-tanggal_mulai' => $data->tanggal_mulai,
                        'data-tanggal_selesai' => $data->tanggal_selesai,
                    ],
                    "route" => route('admin.semester.update', $data->id_semester),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.semester.destroy', $data->id_semester),
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
    public function store(SemesterRequest $request)
    {
        DB::beginTransaction();

        try{
            
            $request->merge([
                'id_semester' => $request->id_tahun_ajaran.$request->semester,
            ]);
            $data = m_semester::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.semester.index');

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
    public function update(SemesterRequest $request, m_semester $semester)
    {
        DB::beginTransaction();

        try{
            $request->merge([
                'id_semester' => $request->id_tahun_ajaran.$request->semester,
            ]);
            $semester->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.semester.index');

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
    public function destroy(m_semester $semester)
    {
        if(is_null($semester)){
            abort(404);
        }

        $semester->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
