<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_jadwal;
use App\Models\m_mata_kuliah;
use App\Models\t_dosen_pengajar_kelas_kuliah;
use App\Models\m_semester;
use App\Models\m_program_studi;
use App\Models\m_global_konfigurasi;
use App\Models\m_kelas_kuliah;
use App\Models\{
    t_jurnal_kuliah,
    t_peserta_kelas_kuliah,
    t_absensi_mahasiswa,
    m_mahasiswa
};
use Session, DB, Auth, PDF;

class PresensiMahasiswaController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi');
        $periode = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester');

        return view('bendahara.presensi_mahasiswa.index', compact('prodi', 'periode'));
    }

    public function data_index(Request $request)
    {
        $query = m_mahasiswa::setFilter([
            'filter' => "id_prodi='$request->prodi' AND id_periode='$request->periode'"
        ])->get();

        $count_total = $query->count();
        $count_filter = m_mahasiswa::count_total([
            'filter' => "id_prodi='$request->prodi' AND id_periode='$request->periode'"
        ]);

        return datatables()->of($query)
            ->with([
                "recordsTotal"    => intval($count_total),
                "recordsFiltered" => intval($count_filter),
            ])
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Status',
                    'class' => 'btn btn-primary btn-sm',
                    "label" => "Unduh Presensi",
                    "route" => route('bendahara.presensi_mahasiswa.cetak', $data->id_mahasiswa),
                ]);

                return $button;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function cetak(Request $request, $id_mahasiswa)
    { 
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;

        $mahasiswa = m_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='$id_mahasiswa'",
        ])->first();


        $pesertaKelasKuliah = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_mahasiswa='$id_mahasiswa'",
        ])->pluck('id_kelas_kuliah')->toArray();

        $list_kelas = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_kelas_kuliah', $pesertaKelasKuliah)->get();

        $jurnal = t_jurnal_kuliah::query()->whereIn('id_kelas_kuliah', $pesertaKelasKuliah)->get();
        $absensi = t_absensi_mahasiswa::query()->get();

        $pdf = PDF::loadView('bendahara.presensi_mahasiswa.cetak', compact('mahasiswa','list_kelas', 'jurnal', 'absensi'))->setPaper('a4', 'landscape');
        return $pdf->stream('Presensi_-_Mahasiswa-_-'.$mahasiswa->nama_mahasiswa.'.pdf');
    }
}
