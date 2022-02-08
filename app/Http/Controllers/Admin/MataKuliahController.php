<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_program_studi;
use App\Models\m_mata_kuliah;
use App\Http\Requests\MataKuliahRequest;
use Session, DB, Str;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $jenis_matkul = $this->jenis_matkul;
        $kelompok_matkul = $this->kelompok_matkul;
        return view('admin.mata_kuliah.index', compact('prodi', 'jenis_matkul', 'kelompok_matkul'));
    }

    public function data_index(Request $request)
    {
        $query = m_mata_kuliah::query()
                ->when($request->prodi, function ($query) use ($request) {
                    $query->where('id_prodi', $request->prodi);
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
                    // 'attribute' => [
                    //     'data-id_prodi' => $data->id_prodi,
                    //     'data-kode_mata_kuliah' => $data->kode_mata_kuliah,
                    //     'data-nama_mata_kuliah' => $data->nama_mata_kuliah,
                    //     'data-id_jenis_mata_kuliah' => $data->id_jenis_mata_kuliah,
                    //     'data-id_kelompok_mata_kuliah' => $data->id_kelompok_mata_kuliah,
                    //     'data-sks_mata_kuliah' => $data->sks_mata_kuliah,
                    //     'data-sks_tatap_muka' => $data->sks_tatap_muka,
                    //     'data-sks_praktek' => $data->sks_praktek,
                    //     'data-sks_praktek_lapangan' => $data->sks_praktek_lapangan,
                    //     'data-sks_simulasi' => $data->sks_simulasi,
                    //     'data-metode_kuliah' => $data->metode_kuliah,
                    //     'data-ada_sap' => $data->ada_sap,
                    //     'data-ada_silabus' => $data->ada_silabus,
                    //     'data-ada_bahan_ajar' => $data->ada_bahan_ajar,
                    //     'data-ada_acara_praktek' => $data->ada_acara_praktek,
                    //     'data-ada_diktat' => $data->ada_diktat,
                    //     'data-paket' => $data->paket,
                    //     'data-tanggal_mulai_efektif' => $data->tanggal_mulai_efektif,
                    //     'data-tanggal_selesai_efektif' => $data->tanggal_selesai_efektif,
                    // ],
                    "route" => route('admin.mata_kuliah.update',['mata_kuliah' => $data->id_matkul]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.mata_kuliah.destroy',['mata_kuliah' => $data->id_matkul]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('jenis_matkul', function ($data) {
                return $data->jenis_matkul->nama_jenis_mata_kuliah;
            })
            ->addColumn('kelompok_matkul', function ($data) {
                return $data->nama_kelompok_mata_kuliah ?? '-';
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function store(Request $request)
    {
        $records = $request->except('_token', '_method', 'paket');
        $result = InsertDataFeeder('InsertMataKuliah', $records);

        return $result;
    }

    public function update(Request $request, $anggota_aktivitas)
    {
        $records = $request->all();
        $key = [
            'id_anggota' => $anggota_aktivitas
        ];

        $result = UpdateDataFeeder('UpdateAnggotaAktivitasMahasiswa', $key, $records);

        return $result;
    }

    public function destroy(Request $request, $anggota_aktivitas)
    {
        $key = [
            'id_anggota' => $anggota_aktivitas
        ];
        
        $result = DeleteDataFeeder('DeleteAnggotaAktivitasMahasiswa', $key);

        return $result;
    }
}
