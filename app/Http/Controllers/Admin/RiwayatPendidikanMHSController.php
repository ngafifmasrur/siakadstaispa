<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_kelas_kuliah;
use App\Models\m_program_studi;
use App\Models\m_mahasiswa;
use App\Models\m_semester;
use App\Models\ref_jenis_pendaftaran;
use App\Models\m_perguruan_tinggi;
use App\Models\t_riwayat_pendidikan_mahasiswa;
use App\Http\Requests\RiwayatPendidikanMHSRequest;
use Session, DB;

class RiwayatPendidikanMHSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_mahasiswa)
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id');
        $periode = m_semester::pluck('nama_semester', 'id');
        $mahasiswa = m_mahasiswa::findOrFail($id_mahasiswa);
        $jalur_daftar = $this->jalur_daftar;
        $jenis_daftar = ref_jenis_pendaftaran::pluck('nama_jenis_daftar', 'id');
        return view('admin.mahasiswa.detail.riwayat_pendidikan', compact('prodi', 'periode', 'mahasiswa', 'jalur_daftar', 'jenis_daftar'));
    }

    public function data_index(Request $request, $id_mahasiswa)
    {
        $query = t_riwayat_pendidikan_mahasiswa::where('id_mahasiswa', $id_mahasiswa)->get();
        $mahasiswa = m_mahasiswa::findOrFail($id_mahasiswa);

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) use ($mahasiswa) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    'attribute' => [
                        'data-id_mahasiswa' => $data->id_mahasiswa,
                        'data-id_jenis_daftar' => $data->id_jenis_daftar,
                        'data-id_jalur_daftar' => $data->id_jalur_daftar,
                        'data-id_periode_masuk' => $data->id_periode_masuk,
                        'data-id_perguruan_tinggi' => $data->id_perguruan_tinggi,
                        'data-id_pembiayaan' => $data->id_pembiayaan,
                        'data-sks_diakui' => $data->sks_diakui,
                        'data-nim' => $data->nim,
                    ],
                    "route" => route('admin.riwayat_pendidikan.update',['riwayat_pendidikan' => $data->id, 'id_mahasiswa' => $mahasiswa->id]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.riwayat_pendidikan.destroy',['id_mahasiswa' => $mahasiswa->id, 'riwayat_pendidikan' => $data->id ]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('nama_mahasiswa', function ($data) {
                return $data->mahasiswa->nama_mahasiswa;
            })
            ->addColumn('periode', function ($data) {
                return $data->periode->nama_semester;
            })
            ->addColumn('jenis_daftar', function ($data) {
                return $data->jenis_daftar->nama_jenis_daftar;
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
    public function store(RiwayatPendidikanMHSRequest $request, $id_mahasiswa)
    {

        $perguruan_tinggi = m_perguruan_tinggi::find(1)->kode_perguruan_tinggi ?? 0;
        $mahasiswa = m_mahasiswa::find($id_mahasiswa);
        DB::beginTransaction();

        try{
            
            $request->merge([
                'id_perguruan_tinggi' => $perguruan_tinggi,
                'id_mahasiswa' => $mahasiswa->id,
                'nim' => $mahasiswa->nim
            ]);

            $data = t_riwayat_pendidikan_mahasiswa::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.riwayat_pendidikan.index', $id_mahasiswa);

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
    public function update(RiwayatPendidikanMHSRequest $request, $id_mahasiswa,t_riwayat_pendidikan_mahasiswa $riwayat_pendidikan)
    {
        DB::beginTransaction();

        try{
            
            $iwayat_pendidikan->update($request->validated());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Diubah');
            return redirect()->route('admin.riwayat_pendidikan.index', $id_mahasiswa);

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
    public function destroy($id_mahasiswa, t_riwayat_pendidikan_mahasiswa $riwayat_pendidikan)
    {
        if(is_null($riwayat_pendidikan)){
            abort(404);
        }

        $riwayat_pendidikan->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
