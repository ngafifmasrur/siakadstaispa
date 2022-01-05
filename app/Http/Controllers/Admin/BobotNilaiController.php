<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_program_studi;
use App\Models\m_skala_nilai_prodi;
use Session, DB;

class BobotNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id');
        return view('admin.bobot_nilai.index', compact('prodi'));
    }

    public function data_index(Request $request)
    {
        $query = m_skala_nilai_prodi::all();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fas fa-edit",
                    'attribute' => [
                        'data-nilai_huruf' => $data->nilai_huruf,
                        'data-prodi' => $data->id_prodi,
                        'data-nilai_indeks' => $data->nilai_indeks,
                        'data-bobot_minimum' => $data->bobot_minimum,
                        'data-bobot_maksimum' => $data->bobot_maksimum,
                        'data-tanggsal_mulai' => $data->tanggal_mulai_efektif,
                        'data-tanggsal_selesai' => $data->tanggal_selesai_efektif,
                    ],
                    "route" => route('admin.bobot_nilai.update',['bobot_nilai' => $data->id]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fas fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.bobot_nilai.destroy',['bobot_nilai' => $data->id]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required',
            'nilai_huruf' => 'required|string',
            'nilai_indeks' => 'nullable|numeric',
            'bobot_minimum' => 'required|numeric',
            'bobot_maksimum' => 'required|numeric',
            'tanggal_mulai_efektif' => 'required|date',
            'tanggal_selesai_efektif' => 'required|date',
        ]);

        DB::beginTransaction();

        try{
            
            $data = m_skala_nilai_prodi::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.bobot_nilai.index');

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,m_skala_nilai_prodi $bobot_nilai)
    {
        $request->validate([
            'id_prodi' => 'required',
            'nilai_huruf' => 'required|string',
            'nilai_indeks' => 'nullable|numeric',
            'bobot_minimum' => 'required|numeric',
            'bobot_maksimum' => 'required|numeric',
            'tanggal_mulai_efektif' => 'required|date',
            'tanggal_selesai_efektif' => 'required|date',
        ]);

        DB::beginTransaction();

        try{
            
            $bobot_nilai->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.bobot_nilai.index');

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
    public function destroy(m_skala_nilai_prodi $bobot_nilai)
    {
        if(is_null($bobot_nilai)){
            abort(404);
        }

        $bobot_nilai->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
