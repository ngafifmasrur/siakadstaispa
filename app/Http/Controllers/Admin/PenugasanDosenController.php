<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PenugasanDosenRequest;
use App\Models\{
    m_tahun_ajaran,
    m_program_studi,
    t_penugasan_dosen_belum_nidn,
    m_dosen_belum_nidn,
    m_dosen,
    m_perguruan_tinggi    
};
use Session, DB, Str;

class PenugasanDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $tahun_ajaran = m_tahun_ajaran::pluck('nama_tahun_ajaran', 'id_tahun_ajaran');
        $dosen = m_dosen_belum_nidn::pluck('nama_dosen', 'id_dosen')->prepend('Pilih Dosen', NULL);

        return view('admin.penugasan_dosen.index', compact('prodi', 'tahun_ajaran','dosen'));
    }

    public function data_index(Request $request)
    {
        $query = t_penugasan_dosen_belum_nidn::query()
                ->when($request->id_prodi, function ($query) use ($request) {
                    $query->where('id_prodi', $request->id_prodi);
                })
                ->when($request->id_tahun_ajaran, function ($query) use ($request) {
                    $query->where('id_tahun_ajaran', $request->id_tahun_ajaran);
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
                        'data-id_dosen' => $data->id_dosen,
                        'data-id_tahun_ajaran' => $data->id_tahun_ajaran,
                        'data-id_prodi' => $data->id_prodi,
                        'data-nomor_surat_tugas' => $data->nomor_surat_tugas,
                        'data-tanggal_surat_tugas' => $data->tanggal_surat_tugas,
                        'data-mulai_surat_tugas' => $data->mulai_surat_tugas,
                    ],
                    "route" => route('admin.penugasan_dosen.update', $data->id_registrasi_dosen),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.penugasan_dosen.destroy', $data->id_registrasi_dosen),
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

    public function store(PenugasanDosenRequest $request)
    {
        DB::beginTransaction();
        try{
            $dosen = m_dosen_belum_nidn::where('id_dosen', $request->id_dosen)->first();
            $perguruan_tinggi = m_perguruan_tinggi::first();
            $program_studi = m_program_studi::where('id_prodi', $request->id_prodi)->first();
            $tahun_ajaran = m_tahun_ajaran::where('id_tahun_ajaran', $request->id_tahun_ajaran)->first();

            $request->merge([
                'id_registrasi_dosen' => Str::uuid(),
                'nama_dosen' => $dosen->nama_dosen,
                'id_perguruan_tinggi' => $perguruan_tinggi->id_perguruan_tinggi,
                'nama_perguruan_tinggi' => $perguruan_tinggi->nama_perguruan_tinggi,
                'nama_program_studi' => $program_studi->nama_program_studi,
                'nama_tahun_ajaran' => $tahun_ajaran->nama_tahun_ajaran
            ]);

            $penugasan_dosen = t_penugasan_dosen_belum_nidn::create($request->all());

            DB::commit();
           
            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->back();

        }catch(\Exception $e){

            dd($e);
            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return back()->withInput();
        }
    }

    public function update(PenugasanDosenRequest $request, t_penugasan_dosen_belum_nidn $penugasan_dosen)
    {
        DB::beginTransaction();
        try{
            $dosen = m_dosen_belum_nidn::where('id_dosen', $request->id_dosen)->first();
            $perguruan_tinggi = m_perguruan_tinggi::first();
            $program_studi = m_program_studi::where('id_prodi', $request->id_prodi)->first();
            $tahun_ajaran = m_tahun_ajaran::where('id_tahun_ajaran', $request->id_tahun_ajaran)->first();

            $request->merge([
                'nama_dosen' => $dosen->nama_dosen,
                'id_perguruan_tinggi' => $perguruan_tinggi->id_perguruan_tinggi,
                'nama_perguruan_tinggi' => $perguruan_tinggi->nama_perguruan_tinggi,
                'nama_program_studi' => $program_studi->nama_program_studi,
                'nama_tahun_ajaran' => $tahun_ajaran->nama_tahun_ajaran
            ]);

            $penugasan_dosen->update($request->all());

            DB::commit();
           
            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->back();

        }catch(\Exception $e){

            dd($e);
            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return back()->withInput();
        }
    }

    public function destroy(t_penugasan_dosen_belum_nidn $penugasan_dosen)
    {
        DB::beginTransaction();
        try{

            $penugasan_dosen->delete();

            DB::commit();
           
            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return back()->withInput();
        }
    }

    public function show()
    {
        abort(404);
    }
}
