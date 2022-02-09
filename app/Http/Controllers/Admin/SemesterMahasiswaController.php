<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_semester;
use App\Models\m_tahun_ajaran;
use App\Models\m_mahasiswa;
use App\Models\m_program_studi;
use App\Models\t_semester_mahasiswa;
use App\Http\Requests\SemesterMHSRequest;
use Session, DB;

class SemesterMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $tahun_ajaran = m_tahun_ajaran::where('a_periode_aktif', 1)->pluck('nama_tahun_ajaran', 'id_tahun_ajaran')->prepend('Pilih Tahun Ajaran', NULL);
        $semester = m_semester::orderBy('nama_semester','DESC')->pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        $mahasiswa = m_mahasiswa::pluck('nama_mahasiswa', 'id_mahasiswa')->prepend('Cari Mahasiswa', NULL);
        return view('admin.semester_mahasiswa.index', compact('tahun_ajaran', 'semester', 'prodi', 'mahasiswa'));
    }

    public function data_index(Request $request)
    {
        $query = t_semester_mahasiswa::query()
                ->when($request->prodi, function ($query) use ($request) {
                    $query->where('id_prodi', $request->prodi);
                })->when($request->tahun_ajaran, function ($query) use ($request) {
                    $query->where('id_tahun_ajaran', $request->tahun_ajaran);
                })->when($request->semester, function ($query) use ($request) {
                    $query->where('id_semester', $request->semester);
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
                        'data-id_mahasiswa' => $data->id_mahasiswa,
                        'data-id_tahun_ajaran' => $data->id_tahun_ajaran,
                        'data-id_semester' => $data->id_semester,
                        'data-id_prodi' => $data->id_prodi,
                        'data-status' => $data->status,
                    ],
                    "route" => route('admin.semester_mahasiswa.update', $data->id),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.semester_mahasiswa.destroy', $data->id),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('mahasiswa', function ($data) {
                return $data->mahasiswa->nama_mahasiswa;
            })
            ->addColumn('tahun_ajaran', function ($data) {
                return $data->tahun_ajaran->nama_tahun_ajaran;
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
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SemesterMHSRequest $request)
    {
        DB::beginTransaction();

        try{
            $semester = m_semester::where('id_semester', $request->id_semester)->first();
            $request->merge([
                'semester' => $semester->semester,
                'status_krs' => 'Belum Mengajukan'
            ]);
            $data = t_semester_mahasiswa::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.semester_mahasiswa.index');

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
    public function update(SemesterMHSRequest $request, t_semester_mahasiswa $semester_mahasiswa)
    {
        DB::beginTransaction();

        try{
            $semester = m_semester::where('id_semester', $request->id_semester)->first();
            $request->merge([
                'semester' => $semester->semester,
                'status_krs' => 'Belum Mengajukan'
            ]);
            $semester_mahasiswa->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.semester_mahasiswa.index');

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
    public function destroy(t_semester_mahasiswa $semester_mahasiswa)
    {
        if(is_null($semester_mahasiswa)){
            abort(404);
        }

        $semester_mahasiswa->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }

    public function mahasiswa_data_index(Request $request)
    {
        $cek = t_semester_mahasiswa::query()
                ->when($request->prodi, function ($query) use ($request) {
                    $query->where('id_prodi', $request->prodi);
                })->when($request->tahun_ajaran, function ($query) use ($request) {
                    $query->where('id_tahun_ajaran', $request->tahun_ajaran);
                })->when($request->semester, function ($query) use ($request) {
                    $query->where('id_semester', $request->semester);
                })->select('id_mahasiswa')->get()->toArray();

        $query = m_mahasiswa::query()
                ->whereNotIn('id_mahasiswa', $cek);

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('checkbox',function ($data) {
                $checkbox = '<input type="checkbox" name="mahasiswa[]" id="mahasiswa[]" value="'.$data->id_mahasiswa.'">';
                return $checkbox;
            })
            ->rawColumns(['checkbox'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function generate(Request $request)
    {
        DB::beginTransaction();

        try{
            $list_mahasiswa = $request->input('mahasiswa');
            foreach($list_mahasiswa as $mahasiswa){
                $semester = m_semester::where('id_semester', $request->semester)->first();
                t_semester_mahasiswa::create([
                    'id_mahasiswa' => $mahasiswa,
                    'id_semester' => $request->semester,
                    'id_prodi' => $request->prodi,
                    'id_tahun_ajaran' => $request->tahun_ajaran,
                    'semester' => $semester->semester,
                    'status_krs' => 'Belum Mengajukan'
                ]);
            }
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }
}
