<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_peserta_kelas_kuliah,
    m_kelas_kuliah
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
        $kelas_kuliah = m_kelas_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->first();
        $angkatan = $kelas_kuliah->semester->tahun_ajaran;
        $mahasiswa = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_prodi='$kelas_kuliah->id_prodi' AND angkatan='$angkatan'",
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
        $records = $request->all();
        $result = InsertDataFeeder('InsertPesertaKelasKuliah', $records);

        return $result;
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
        
        $result = DeleteDataFeeder('DeletePesertaKelasKuliah', $key);

        return $result;
    }
}
