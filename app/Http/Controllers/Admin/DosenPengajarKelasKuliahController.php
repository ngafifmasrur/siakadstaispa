<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PengajarKelasRequest;
use App\Models\{
    t_dosen_pengajar_kelas_kuliah,
    t_penugasan_dosen,
    ref_jenis_evaluasi,
    m_global_konfigurasi,
    m_kelas_kuliah,
    t_substansi_mata_kuliah,
    t_penugasan_dosen_belum_nidn,
    t_dosen_belum_nidn_pengajar_kelas_kuliah
};
use Session, DB, Str;

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
            'filter' => "id_tahun_ajaran='$tahun_ajaran'",
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

    public function store(PengajarKelasRequest $request, $id_kelas_kuliah)
    {

        $check_nidn = t_penugasan_dosen::where('id_registrasi_dosen', $request->id_registrasi_dosen)->first();

        if(isset($check_nidn->nidn)){

            $records['id_registrasi_dosen'] = $request->id_registrasi_dosen;
            $records['id_kelas_kuliah'] = $id_kelas_kuliah;
            $records['id_substansi'] = $request->id_substansi;
            $records['sks_substansi_total'] = $request->sks_substansi_total;
            $records['id_jenis_evaluasi'] = $request->id_jenis_evaluasi;
            $records['rencana_minggu_pertemuan'] = $request->rencana_minggu_pertemuan;
            $records['realisasi_minggu_pertemuan'] = $request->realisasi_minggu_pertemuan;
    
            $result = InsertDataFeeder('InsertDosenPengajarKelasKuliah', $records, 'GetDosenPengajarKelasKuliah');
    
            if($result['error_code'] !== '0') {
                Session::flash('error_msg', $result['error_desc']);
                return back()->withInput();
            }

        } else {

            $dosen = t_penugasan_dosen_belum_nidn::where('id_registrasi_dosen', $request->id_registrasi_dosen)->first();
            $kelas_kuliah = m_kelas_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->first();
            $jenis_evaluasi = ref_jenis_evaluasi::where('id_jenis_evaluasi', $request->id_jenis_evaluasi)->first();
            
            t_dosen_belum_nidn_pengajar_kelas_kuliah::create([
                'id_aktivitas_mengajar' => Str::uuid(),
                'id_registrasi_dosen' => $request->id_registrasi_dosen,
                'id_dosen' => $dosen->id_dosen,
                'nama_dosen' => $dosen->nama_dosen,
                'id_kelas_kuliah' => $id_kelas_kuliah,
                'nama_kelas_kuliah' => $kelas_kuliah->nama_kelas_kuliah,
                'id_substansi' => $request->id_substansi,
                'sks_substansi_total' => $request->sks_substansi_total,
                'rencana_minggu_pertemuan' => $request->rencana_minggu_pertemuan,
                'realisasi_minggu_pertemuan' => $request->realisasi_minggu_pertemuan,
                'id_jenis_evaluasi' => $request->id_jenis_evaluasi,
                'nama_jenis_evaluasi' => $jenis_evaluasi->nama_jenis_evaluasi,
                'id_prodi' => $kelas_kuliah->id_prodi,
                'id_semester' => $kelas_kuliah->id_semester,
            ]);

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
        $records['rencana_minggu_pertemuan'] = $request->rencana_minggu_pertemuan;
        $records['realisasi_minggu_pertemuan'] = $request->realisasi_minggu_pertemuan;

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
       
        $pengajar_kelas_kuliah = t_dosen_pengajar_kelas_kuliah::setFilter([
            'filter' => "id_aktivitas_mengajar='$id_aktivitas_mengajar'"
        ])->first();
        $check_nidn = t_penugasan_dosen::where('id_registrasi_dosen', $pengajar_kelas_kuliah->id_registrasi_dosen)->first();

        if(isset($check_nidn->nidn)){
            
            $key = [
                'id_aktivitas_mengajar' => $id_aktivitas_mengajar,
            ];
            
            $result = DeleteDataFeeder('DeleteDosenPengajarKelasKuliah', $key, 'GetDosenPengajarKelasKuliah');
    
            if($result['error_code'] !== '0') {
                Session::flash('error_msg', $result['error_desc']);
                return back()->withInput();
            }

        } else {

            $pengajar_kelas_kuliah->delete();

        }

        Session::flash('success_msg', 'Berhasil Dihapus');
        return redirect()->back();
    }
}
