<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_jadwal;
use App\Models\m_kelas_kuliah;
use App\Models\m_dosen;
use App\Models\m_program_studi;
use App\Models\m_mata_kuliah_aktif;
use App\Models\m_ruang_kelas;
use App\Http\Requests\JadwalRequest;
use Session, DB;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruangan = m_ruang_kelas::pluck('nama_ruangan', 'id');
        $dosen = m_dosen::pluck('nama_dosen', 'id_dosen');
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi');
        $kelas = m_kelas_kuliah::pluck('nama_kelas_kuliah', 'id');
        $matkul = m_mata_kuliah_aktif::get()
        ->map(function($data) {
            return [
                'id'    => $data->id,
                'matkul'  => $data->matkul->nama_mata_kuliah
            ];
        })
        ->pluck('matkul', 'id')
        ->all();
        return view('admin.jadwal.index', compact('ruangan', 'dosen', 'prodi', 'matkul', 'kelas'));
    }

    public function data_index(Request $request)
    {
        $query = m_jadwal::all();

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
                        'data-id_prodi' => $data->id_prodi,
                        'data-id_dosen' => $data->id_dosen,
                        'data-id_kelas' => $data->id_kelas,
                        'data-id_ruang' => $data->id_matkul_aktif,
                        'data-hari' => $data->hari,
                        'data-jam_mulai' => $data->jam_mulai,
                        'data-jam_akhir' => $data->jam_akhir,

                    ],
                    "route" => route('admin.jadwal.update', $data->id),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.jadwal.destroy', $data->id),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('ruangan', function ($data) {
                return $data->ruangan->nama_ruangan;
            })
            ->addColumn('dosen', function ($data) {
                return $data->dosen->nama_dosen;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('kelas', function ($data) {
                return $data->kelas->nama_kelas_kuliah;
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
    public function store(JadwalRequest $request)
    {
        DB::beginTransaction();

        try{
            
            $data = m_jadwal::create($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.jadwal.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return dd($e);
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
    public function update(JadwalRequest $request, m_jadwal $jadwal)
    {
        DB::beginTransaction();

        try{
            
            $jadwal->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.jadwal.index');

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
    public function destroy(m_jadwal $jadwal)
    {
        if(is_null($jadwal)){
            abort(404);
        }

        $jadwal->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
