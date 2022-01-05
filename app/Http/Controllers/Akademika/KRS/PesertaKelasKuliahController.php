<?php

namespace App\Http\Controllers\Akademika\KRS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_kelas_kuliah;
use App\Http\Requests\KelasKuliahRequest;
use Session, DB;

class PesertaKelasKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.peserta_kelas_kuliah.index');
    }

    public function data_index(Request $request)
    {
        $query = m_kelas_kuliah::all();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Anggota',
                    'class' => 'btn btn-outline-primary btn-sm',
                    "icon" => "fas fa-users",
                    "route" => route('admin.peserta_kelas_kuliah.anggota',['kelas_kuliah' => $data->id]),
                ]);

    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('matkul', function ($data) {
                return $data->mata_kuliah->nama_mata_kuliah;
            })
            ->addColumn('semester', function ($data) {
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
    public function store(KelasKuliahRequest $request)
    {

        DB::beginTransaction();

        try{
            
            $data = t_peserta_kelas_kuliah::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.peserta_kelas_kuliah.index');

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
    public function anggota($kelas_kuliah)
    {
        return view('admin.peserta_kelas_kuliah.show');
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
    public function update(KelasKuliahRequest $request, t_peserta_kelas_kuliah $peserta_kelas_kuliah)
    {
        DB::beginTransaction();

        try{
            
            $kelas_kuliah->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.peserta_kelas_kuliah.index');

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
    public function destroy(t_peserta_kelas_kuliah $peserta_kelas_kuliah)
    {
        if(is_null($peserta_kelas_kuliah)){
            abort(404);
        }

        $peserta_kelas_kuliah->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
