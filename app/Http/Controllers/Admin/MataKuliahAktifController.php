<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_program_studi;
use App\Models\m_tahun_ajaran;
use App\Models\m_semester;
use App\Models\m_mata_kuliah;
use App\Models\m_mata_kuliah_aktif;
use App\Http\Requests\MataKuliahAktifRequest;
use Session, DB;

class MataKuliahAktifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $tahun_ajaran = m_tahun_ajaran::where('a_periode_aktif', 1)->pluck('nama_tahun_ajaran', 'id_tahun_ajaran')->prepend('Pilih Tahun Ajaran', NULL);
        return view('admin.mata_kuliah_aktif.index', compact('prodi', 'tahun_ajaran'));
    }

    public function data_index(Request $request, $tahun_ajaran, $prodi)
    {
        $query = m_mata_kuliah_aktif::query()
                ->where('semester', substr($request->semester, -1))
                ->where('id_prodi', $prodi)
                ->whereHas('detail_semester', function($q) use ($tahun_ajaran) {
                     $q->where('id_tahun_ajaran', $tahun_ajaran);
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
                    'attribute' => [
                        'data-id_matkul' => $data->id_matkul,
                        'data-id_semester' => $data->id_semester,
                        'data-nilai_minimum' => $data->nilai_minimum,
                        'data-mk_wajib' => $data->mk_wajib,
                        'data-mk_paket' => $data->mk_paket
                    ],
                    "route" => route('admin.kurikulum_prodi.update',['kurikulum_prodi' => $data->id]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.kurikulum_prodi.destroy',['kurikulum_prodi' => $data->id]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('nama_matkul', function ($data) {
                return $data->matkul->nama_mata_kuliah;
            })
            ->addColumn('kode_matkul', function ($data) {
                return $data->matkul->kode_mata_kuliah;
            })
            ->addColumn('sks', function ($data) {
                return $data->matkul->sks_mata_kuliah;
            })
            ->addColumn('wajib', function ($data) {
                return $data->mk_wajib ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>';
            })
            ->addColumn('paket', function ($data) {
                return $data->mk_paket ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>';
            })
            ->rawColumns(['action', 'wajib', 'paket'])
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
    public function create(m_tahun_ajaran $tahun_ajaran, m_program_studi $prodi)
    {
        $table_semester = m_semester::where('id_tahun_ajaran', $tahun_ajaran->id_tahun_ajaran)
                        ->pluck('semester', 'id_semester');

        $matkul = m_mata_kuliah::where('id_prodi', $prodi->id_prodi)->get()
                ->map(function($data) {
                    return [
                        'id_matkul'    => $data->id_matkul,
                        'matkul_kode'  => $data->matkul_kode
                    ];
                })->pluck('matkul_kode', 'id_matkul')->prepend('Pilih Mata Kuliah', NULL);

        $semester = m_semester::where('id_tahun_ajaran', $tahun_ajaran->id_tahun_ajaran)->pluck('semester', 'id_semester')->prepend('Pilih Semester', NULL);

        return view('admin.mata_kuliah_aktif.create', compact('matkul', 'semester', 'prodi', 'tahun_ajaran', 'table_semester'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MataKuliahAktifRequest $request)
    {

        $matkul = m_mata_kuliah::where('id_matkul', $request->id_matkul)->first();
        $semester = m_semester::where('id_semester', $request->id_semester)->first();

        $cek = m_mata_kuliah_aktif::where('id_semester', $semester->id_semester)
                                    ->where('id_matkul', $request->id_matkul)
                                    ->where('id_prodi', $matkul->id_prodi)
                                    ->first();

        if(isset($cek)) {
            Session::flash('error_msg', 'Kurikulum Prodi sudah pernah dibuat');
            return redirect()->back()->withInput();
        }


        DB::beginTransaction();

        try{
            
            
            $request->merge([
                'id_prodi' => $matkul->id_prodi,
                'mk_paket' => $request->mk_paket ?? 0,
                'mk_wajib' => $request->mk_wajib ?? 0,
                'semester' => $semester->semester
            ]);
            $data = m_mata_kuliah_aktif::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->back();

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
    public function update(MataKuliahAktifRequest $request, m_mata_kuliah_aktif $kurikulum_prodi)
    {
        $matkul = m_mata_kuliah::where('id_matkul', $request->id_matkul)->first();

        $cek = m_mata_kuliah_aktif::where('id_semester', $request->id_semester)
        ->where('id_matkul', $request->id_matkul)
        ->where('id_prodi', $matkul->id_prodi)
        ->whereNotIn('id', [$kurikulum_prodi->id])
        ->first();

        DB::beginTransaction();

        try{
            
            $kurikulum_prodi->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->back();

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
    public function destroy(m_mata_kuliah_aktif $kurikulum_prodi)
    {
        if(is_null($kurikulum_prodi)){
            abort(404);
        }

        $kurikulum_prodi->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
