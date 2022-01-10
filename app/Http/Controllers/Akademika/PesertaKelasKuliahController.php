<?php

namespace App\Http\Controllers\Akademika;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_kelas_kuliah;
use App\Models\t_peserta_kelas_kuliah;
use App\Models\t_riwayat_pendidikan_mahasiswa;
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
                    'type' => 'link',
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
    public function store(Request $request, $kelas_kuliah)
    {

        DB::beginTransaction();

        try{
            
            // $data = t_peserta_kelas_kuliah::create($request->all());
            $list_peserta = $request->input('peserta');
            foreach($list_peserta as $peserta){
                t_peserta_kelas_kuliah::create([
                    'id_registrasi_mahasiswa' => $peserta,
                    'id_kelas_kuliah' => $kelas_kuliah
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function anggota($kelas_kuliah)
    {
        $peserta = t_peserta_kelas_kuliah::where('id_kelas_kuliah', $kelas_kuliah)
                    ->select('id_registrasi_mahasiswa')->get()->toArray();
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::whereNotIn('id', $peserta)->get();
        return view('admin.peserta_kelas_kuliah.show', compact('kelas_kuliah', 'mahasiswa'));
    }

    public function anggota_data_index(Request $request, $kelas_kuliah)
    {
        $query = t_peserta_kelas_kuliah::where('id_kelas_kuliah', $kelas_kuliah)->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data){
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                // $button .= view("components.button.default", [
                //     'type' => 'button',
                //     'tooltip' => 'Ubah',
                //     'class' => 'btn btn-outline-primary btn-sm btn_edit',
                //     "icon" => "fas fa-edit",
                //     'attribute' => [
                //         'data-id_kelas_kuliah' => $data->id_kelas_kuliah,
                //         'data-id_registrasi_mahasiswa' => $data->id_registrasi_mahasiswa
                //     ],
                //     "route" => route('admin.peserta_kelas_kuliah.update',['peserta_kelas_kuliah' => $data->id]),
                // ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fas fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.peserta_kelas_kuliah.destroy', $data->id),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('nim', function ($data) {
                return $data->riwayat_pendidikan_mhs->nim;
            })
            ->addColumn('nama_mahasiswa', function ($data) {
                return $data->riwayat_pendidikan_mhs->mahasiswa->nama_mahasiswa;
            })
            ->addColumn('periode_masuk', function ($data) {
                return $data->riwayat_pendidikan_mhs->periode->nama_semester;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }
}
