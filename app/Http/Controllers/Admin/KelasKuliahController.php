<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_kelas_kuliah;
use App\Models\m_program_studi;
use App\Models\m_mata_kuliah;
use App\Models\m_semester;
use App\Http\Requests\KelasKuliahRequest;
use Session, DB;

class KelasKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        // $mata_kuliah = m_mata_kuliah::pluck('nama_mata_kuliah', 'id');

        return view('admin.kelas_kuliah.index', compact('prodi', 'semester'));
    }

    public function data_index(Request $request)
    {
        $query = m_kelas_kuliah::query()
                ->when($request->id_prodi, function ($q) use ($request) {
                    $q->where('id_prodi', $request->id_prodi);
                })
                ->when($request->id_semester, function ($q) use ($request) {
                    $q->where('id_semester', $request->id_semester);
                });

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    "route" => route('admin.kelas_kuliah.update',['kelas_kuliah' => $data->id_kelas_kuliah]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.kelas_kuliah.destroy',['kelas_kuliah' => $data->id_kelas_kuliah]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('dosen',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Daftar Dosen',
                    'class' => 'btn btn-primary btn-sm',
                    "icon" => "fa fa-users",
                    "route" => route('admin.pengajar_kelas_kuliah.index',['id_kelas_kuliah' => $data->id_kelas_kuliah]),
                ]);
                return $button;
            })
            ->addColumn('mahasiswa',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Daftar Mahasiswa',
                    'class' => 'btn btn-primary btn-sm',
                    "icon" => "fa fa-users",
                    "route" => route('admin.peserta_kelas_kuliah.index',['id_kelas_kuliah' => $data->id_kelas_kuliah]),
                ]);
                return $button;
            })
            ->addColumn('nama_program_studi', function ($data) {
                return $data->nama_program_studi;
            })
            ->addColumn('nama_mata_kuliah', function ($data) {
                return $data->nama_mata_kuliah;
            })
            ->addColumn('nama_semester', function ($data) {
                return $data->nama_semester;
            })
            ->rawColumns(['action', 'dosen', 'mahasiswa'])
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
            
            $data = m_kelas_kuliah::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.kelas_kuliah.index');

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
    public function update(KelasKuliahRequest $request,m_kelas_kuliah $kelas_kuliah)
    {
        DB::beginTransaction();

        try{
            
            $kelas_kuliah->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.kelas_kuliah.index');

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
    public function destroy(m_kelas_kuliah $kelas_kuliah)
    {
        if(is_null($kelas_kuliah)){
            abort(404);
        }

        $kelas_kuliah->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
