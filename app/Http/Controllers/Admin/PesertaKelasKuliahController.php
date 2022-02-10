<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_peserta_kelas_kuliah,
    m_kelas_kuliah,
    t_riwayat_pendidikan_mahasiswa,
    m_global_konfigurasi
};
use Session, DB;

class PesertaKelasKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_kelas_kuliah)
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $kelas_kuliah = m_kelas_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->first();
        $angkatan = $kelas_kuliah->semester->tahun_ajaran;
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_prodi='$kelas_kuliah->id_prodi' AND id_periode_masuk='$semester_aktif'",
        ])->pluck('nama_mahasiswa', 'id_registrasi_mahasiswa')->prepend('Pilih Mahasiswa');
        
        return view('admin.peserta_kelas_kuliah.index', compact('id_kelas_kuliah', 'mahasiswa'));
    }

    public function data_index(Request $request, $id_kelas_kuliah)
    {
        $query = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
            
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';

                // $button .= view("components.button.default", [
                //     'type' => 'button',
                //     'tooltip' => 'Ubah',
                //     'class' => 'btn btn-outline-primary btn-sm btn_edit',
                //     "icon" => "fa fa-edit",
                //     "route" => route('admin.peserta_kelas_kuliah.update', [$data->id_kelas_kuliah, $data->id_registrasi_mahasiswa]),
                // ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.peserta_kelas_kuliah.destroy', [$data->id_kelas_kuliah, $data->id_registrasi_mahasiswa]),
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

    public function store(Request $request, $id_kelas_kuliah)
    {
        $records = [];
        $records['id_registrasi_mahasiswa'] = $request->id_registrasi_mahasiswa;
        $records['id_kelas_kuliah'] = $id_kelas_kuliah;

        $result = InsertDataFeeder('InsertPesertaKelasKuliah', $records, 'GetPesertaKelasKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function update(Request $request, $id_kelas_kuliah, $id_registrasi_mahasiswa)
    {
        $records = $request->all();
        $key = [
            'id_kelas_kuliah' => $id_kelas_kuliah,
            'id_registrasi_mahasiswa' => $id_registrasi_mahasiswa
        ];

        $result = UpdateDataFeeder('UpdatePesertaKelasKuliah', $key, $records);

        return $result;
    }

    public function destroy(Request $request, $id_kelas_kuliah, $id_registrasi_mahasiswa)
    {
        $key = [
            'id_kelas_kuliah' => $id_kelas_kuliah,
            'id_registrasi_mahasiswa' => $id_registrasi_mahasiswa
        ];
        
        $result = DeleteDataFeeder('DeletePesertaKelasKuliah', $key, $GetPesertaKelasKuliah);

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();    }
}
