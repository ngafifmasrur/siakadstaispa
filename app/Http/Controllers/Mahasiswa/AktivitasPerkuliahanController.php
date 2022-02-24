<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    m_aktivitas_kuliah_mahasiswa,
    m_global_konfigurasi
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session, DB;

class AktivitasPerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mahasiswa.aktivitas_perkuliahan.index');
    }

    public function data_index(Request $request)
    {
        $user = Auth::user();
        $semester = m_global_konfigurasi::first()->value('id_semester_aktif');

        $query = m_aktivitas_kuliah_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='$user->id_mahasiswa'"
        ])->get();

        return datatables()->of($query)
            ->addIndexColumn()
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
