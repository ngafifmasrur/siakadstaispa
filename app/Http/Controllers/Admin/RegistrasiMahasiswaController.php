<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    m_kelas_kuliah,
    m_program_studi,
    m_mahasiswa,
    m_semester,
    ref_jenis_pendaftaran,
    m_perguruan_tinggi,
    t_riwayat_pendidikan_mahasiswa,
    ref_jalur_masuk,
    ref_pembiayaan
};
use Illuminate\Http\Request;
use Session, DB;

class RegistrasiMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $periode = m_semester::orderBy('nama_semester','DESC')->pluck('nama_semester', 'id_semester')->prepend('Pilih Periode Masuk', NULL);
        $mahasiswa = m_mahasiswa::pluck('nama_mahasiswa', 'id_mahasiswa');
        $jalur_masuk = ref_jalur_masuk::pluck('nama_jalur_masuk', 'id_jalur_masuk')->prepend('Pilih Jalur Masuk', NULL);
        $jenis_daftar = ref_jenis_pendaftaran::pluck('nama_jenis_daftar', 'id_jenis_daftar')->prepend('Pilih Jenis Pendaftaran', NULL);
        $pembiayaan = ref_pembiayaan::pluck('nama_pembiayaan', 'id_pembiayaan')->prepend('Pilih Pembiayaan', NULL);

        return view('admin.registrasi_mahasiswa.index', compact('prodi', 'periode', 'mahasiswa', 'jalur_masuk', 'jenis_daftar', 'pembiayaan'));
    }

    public function data_index(Request $request)
    {
        $query = t_riwayat_pendidikan_mahasiswa::setFilter([
                    'filter' => "id_periode_masuk='$request->id_periode_masuk'"
                ])
                ->when($request->id_prodi, function ($query) use ($request) {
                    $query->where('id_prodi', $request->id_prodi);
                })->get();

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
                        'onclick' => 'editForm(`'. route('admin.registrasi_mahasiswa.update', $data->id_registrasi_mahasiswa) .'`, `Edit`, `#modal-form`)'
                    ],
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.registrasi_mahasiswa.destroy', $data->id_registrasi_mahasiswa),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->nama_program_studi;
            })
            ->addColumn('nama_mahasiswa', function ($data) {
                return $data->nama_mahasiswa;
            })
            ->addColumn('periode', function ($data) {
                return $data->nama_periode_masuk;
            })
            ->addColumn('jenis_daftar', function ($data) {
                return $data->nama_jenis_daftar;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function show(t_riwayat_pendidikan_mahasiswa $registrasi_mahasiswa)
    {

        abort_if(! $registrasi_mahasiswa, 404);

        return response()->json([
			'code'    => 200,
			'message' => 'success',
			'data'    => $registrasi_mahasiswa
		], 200);
    }

    public function store(Request $request)
    {
        $mahasiswa = m_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='$request->id_mahasiswa'"
        ])->first();
        $perguruan_tinggi = m_perguruan_tinggi::first()->value('id_perguruan_tinggi');

        $records = $request->except('_token', '_method');
        $records['nim'] = $mahasiswa->nim;
        $records['id_perguruan_tinggi'] = $perguruan_tinggi;

        $result = InsertDataFeeder('InsertRiwayatPendidikanMahasiswa', $records, 'GetListRiwayatPendidikanMahasiswa');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
        
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function update(Request $request, $registrasi_mahasiswa)
    {
        $mahasiswa = m_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='$request->id_mahasiswa'"
        ])->first();
        $perguruan_tinggi = m_perguruan_tinggi::first()->value('id_perguruan_tinggi');

        $records = $request->except('_token', '_method');
        $records['nim'] = $mahasiswa->nim;
        $records['id_perguruan_tinggi'] = $perguruan_tinggi;

        $key = [
            'id_registrasi_mahasiswa' => $registrasi_mahasiswa
        ];

        $result = UpdateDataFeeder('UpdateRiwayatPendidikanMahasiswa', $key, $records, 'GetListRiwayatPendidikanMahasiswa');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
        
        Session::flash('success_msg', 'Berhasil Diupdate');
        return redirect()->back();    
    }

    public function destroy(Request $request, $registrasi_mahasiswa)
    {
        $key = [
            'id_registrasi_mahasiswa' => $registrasi_mahasiswa
        ];
        
        $result = DeleteDataFeeder('DeleteRiwayatPendidikanMahasiswa', $key, 'GetListRiwayatPendidikanMahasiswa');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
        
        Session::flash('success_msg', 'Berhasil Dihapus');
        return redirect()->back();
    }
}
