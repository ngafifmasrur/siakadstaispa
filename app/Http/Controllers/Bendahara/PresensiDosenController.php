<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_dosen;
use App\Models\ref_agama;
use App\Models\ref_wilayah;
use App\Models\Role;
use App\Models\User;
use App\Models\{
    t_jurnal_kuliah,
    t_peserta_kelas_kuliah,
    t_absensi_mahasiswa,
    m_mahasiswa,
    t_dosen_pengajar_kelas_kuliah,
    m_global_konfigurasi,
    m_kelas_kuliah
};
use Session, DB, Auth, PDF;

class PresensiDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bendahara.presensi_dosen.index');
    }

    public function data_index(Request $request)
    {
        $query = m_dosen::setFilter([
            'limit' => $request->start+$request->length,
        ])->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Status',
                    'class' => 'btn btn-primary btn-sm',
                    "label" => "Unduh Presensi",
                    "route" => route('bendahara.presensi_dosen.cetak', $data->id_dosen),
                ]);

                return $button;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function cetak(Request $request, $id_dosen)
    { 
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;

        $dosen = m_dosen::setFilter([
            'filter' => "id_dosen='$id_dosen'",
        ])->where('id_dosen', $id_dosen)
        ->first();


        $pesertaKelasKuliah = t_dosen_pengajar_kelas_kuliah::setFilter([
            'filter' => "id_dosen='$id_dosen'",
        ])
        ->where('id_dosen', $id_dosen)
        ->pluck('id_kelas_kuliah')->toArray();

        $list_kelas = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_kelas_kuliah', $pesertaKelasKuliah)->get();

        $jurnal = t_jurnal_kuliah::query()->whereIn('id_kelas_kuliah', $pesertaKelasKuliah)->get();

        $pdf = PDF::loadView('bendahara.presensi_dosen.cetak', compact('dosen','list_kelas', 'jurnal'))->setPaper('a4', 'landscape');
        return $pdf->stream('Presensi_-_Dosen-_-'.$dosen->nama_dosen.'.pdf');
    }
}
