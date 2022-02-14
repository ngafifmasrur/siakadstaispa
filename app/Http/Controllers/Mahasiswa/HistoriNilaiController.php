<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_riwayat_pendidikan_mahasiswa,
    t_riwayat_nilai_mahasiswa,
    m_global_konfigurasi,
    m_semester,
    m_mahasiswa,
    m_mata_kuliah
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session, DB, PDF;

class HistoriNilaiController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester');
        return view('mahasiswa.histori_nilai.index', compact('periode'));
    }

    public function data_index(Request $request)
    {
        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first() ?? null;

        if(isset($riwayat_pendidikan)) {
            $query = t_riwayat_nilai_mahasiswa::setFilter([
                'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa'"
            ])->get();

            $query->map(function ($item){
                $matkul = m_mata_kuliah::setFilter([
                    'filter' => "id_matkul='$item->id_matkul'"
                ])->first();
                $item['kode_mata_kuliah'] = $matkul->kode_mata_kuliah;
                $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;
                $item['total_nilai'] = $matkul->sks_mata_kuliah*$item->nilai_indeks;

                return $item;
            });
        } else {
            $query = [];
        }

        return datatables()->of($query)
            ->addIndexColumn()
           ->addColumn('kode_mk',function ($data) {
                return $data->kode_mata_kuliah;
            })
            ->addColumn('sks_mata_kuliah',function ($data) {
                return $data->sks_mata_kuliah;
            })
            ->addColumn('total_nilai',function ($data) {
                return $data->total_nilai;
            })
            // ->addColumn('action',function ($data) {
           
            //     $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
            //     $button .= view("components.button.default", [
            //         'type' => 'button',
            //         'tooltip' => 'Ubah',
            //         'class' => 'btn btn-outline-primary btn-sm btn_edit',
            //         "icon" => "fa fa-edit",
            //         'attribute' => [
            //             'data-id_jenis_aktivitas' => $data->id_jenis_aktivitas,
            //             'data-id_prodi' => $data->id_prodi,
            //             'data-id_semester' => $data->id_semester,
            //             'data-judul' => $data->judul,
            //             'data-keterangan' => $data->keterangan,
            //             'data-lokasi' => $data->lokasi,
            //             'data-sk_tugas' => $data->sk_tugas,
            //         ],
            //         "route" => route('admin.aktivitas.update', $data->id_aktivitas),
            //     ]);
    
            //     $button .= view("components.button.default", [
            //         'type' => 'button',
            //         'tooltip' => 'Hapus',
            //         'class' => 'btn btn-outline-danger btn-sm btn_delete',
            //         "icon" => "fa fa-trash",
            //         'attribute' => [
            //             'data-text' => 'Anda yakin ingin menghapus data ini ?',
            //         ],
            //         "route" => route('admin.aktivitas.destroy', $data->id_aktivitas),
            //     ]);
    
            //     $button .= '</div>';
    
            //     return $button;
            // })
            // ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function cetak(Request $request)
    { 
        $periode = $request->periode;
        $user = Auth::user();
        $mahasiswa = m_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='$user->id_mahasiswa'"
        ])->first();

        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='$user->id_mahasiswa'"
        ])->first() ?? null;

        if(isset($riwayat_pendidikan)) {
            $nilai = t_riwayat_nilai_mahasiswa::setFilter([
                'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa'"
            ])->get();
            
            $nilai->map(function ($item){
                $matkul = m_mata_kuliah::setFilter([
                    'filter' => "id_matkul='$item->id_matkul'"
                ])->first();
                $item['kode_mata_kuliah'] = $matkul->kode_mata_kuliah;
                $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;
                $item['total_nilai'] = $matkul->sks_mata_kuliah*$item->nilai_indeks;

                return $item;
            });

        } else {
            $nilai = null;
        }
        
        $pdf = PDF::loadView('mahasiswa.histori_nilai.cetak', compact('riwayat_pendidikan', 'mahasiswa', 'nilai', 'periode'))->setPaper('a4', 'landscape');
        return $pdf->stream('Histori_-_Nilai-_-'.$mahasiswa->nama_mahasiswa.'.pdf');    
    }
}
