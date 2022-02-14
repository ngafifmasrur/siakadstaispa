<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_dosen_pengajar_kelas_kuliah,
    t_penugasan_dosen,
    ref_jenis_evaluasi,
    m_global_konfigurasi,
    m_kelas_kuliah,
    t_substansi_mata_kuliah
};
use Session, DB;

class DosenPengajarKelasKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_kelas_kuliah)
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $tahun_ajaran = m_global_konfigurasi::first()->id_tahun_ajaran;

        $jenis_evaluasi = ref_jenis_evaluasi::pluck('nama_jenis_evaluasi', 'id_jenis_evaluasi')->prepend('Pilih Jenis Evaluasi', NULL);

        // Kelas Kuliah
        $kelas_kuliah = m_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'"
        ])->first();

        $substansi_kuliah = t_substansi_mata_kuliah::setFilter([
            'filter' => "id_prodi='$kelas_kuliah->id_prodi'"
        ])->pluck('nama_substansi', 'id_substansi')->prepend('Pilih Substansi', NULL);

        // Cari Dosen By Prodi kelas kuliah & Semester Aktif
        $dosen = t_penugasan_dosen::setFilter([
            'filter' => "id_prodi='$kelas_kuliah->id_prodi' AND id_tahun_ajaran='$tahun_ajaran'",
        ])->pluck('nama_dosen', 'id_registrasi_dosen')->prepend('Pilih Dosen', NULL);

        return view('admin.pengajar_kelas_kuliah.index', compact('id_kelas_kuliah', 'jenis_evaluasi', 'dosen', 'kelas_kuliah', 'substansi_kuliah'));
    }

    public function data_index(Request $request, $id_kelas_kuliah)
    {
        $query = t_dosen_pengajar_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.pengajar_kelas_kuliah.destroy', $data->id_aktivitas_mengajar),
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
        // $records = $request->except('_token', '_method');
        
        $records['id_registrasi_dosen'] = $request->id_registrasi_dosen;
        $records['id_kelas_kuliah'] = $id_kelas_kuliah;
        $records['id_substansi'] = $request->id_substansi;
        $records['sks_substansi_total'] = $request->sks_substansi_total;
        $records['id_jenis_evaluasi'] = $request->id_jenis_evaluasi;

        $result = InsertDataFeeder('InsertDosenPengajarKelasKuliah', $records, 'GetDosenPengajarKelasKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function update(Request $request, $id_aktivitas_mengajar)
    {
        $records['id_registrasi_dosen'] = $request->id_registrasi_dosen;
        $records['id_kelas_kuliah'] = $id_kelas_kuliah;
        $records['id_substansi'] = $request->id_substansi;
        $records['sks_substansi_total'] = $request->sks_substansi_total;
        $records['id_jenis_evaluasi'] = $request->id_jenis_evaluasi;

        $key = [
            'id_aktivitas_mengajar' => $id_aktivitas_mengajar,
        ];

        $result = UpdateDataFeeder('UpdateDosenPengajarKelasKuliah', $key, $records, 'GetDosenPengajarKelasKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function destroy(Request $request, $id_aktivitas_mengajar)
    {
        $key = [
            'id_aktivitas_mengajar' => $id_aktivitas_mengajar,
        ];
        
        $result = DeleteDataFeeder('DeleteDosenPengajarKelasKuliah', $key, 'GetDosenPengajarKelasKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }
}
