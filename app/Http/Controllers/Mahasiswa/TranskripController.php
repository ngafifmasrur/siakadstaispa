<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_riwayat_pendidikan_mahasiswa,
    t_transkrip_mahasiswa,
    m_global_konfigurasi,
    m_semester
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session, DB;

class TranskripController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester');
        return view('mahasiswa.transkrip.index', compact('periode'));
    }

    public function data_index(Request $request)
    {

        $user = Auth::user();
        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='$user->id_mahasiswa' AND id_periode_masuk='$request->periode'"
        ])->first() ?? null;

        if(!isset($riwayat_pendidikan)) {
            $query = t_transkrip_mahasiswa::setFilter([
                'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa'"
            ])->get();
        } else {
            $query = null;
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('total_nilai',function ($data) {
                return $data->sks_mata_kuliah*$data->nilai_indeks;
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
}
