<?php

namespace App\Http\Controllers\Dosen;

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
    t_absensi_mahasiswa
};
use App\Http\Requests\Dosen\KontrakRequest;
use Session, DB, Auth, PDF;

class JadwalMengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::orderBy('nama_semester','DESC')->pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        return view('dosen.jadwal_mengajar.index', compact('prodi', 'semester'));
    }

    public function data_index(Request $request)
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $kelasKuliah = t_dosen_pengajar_kelas_kuliah::setFilter([
                            'filter' => "id_dosen='".Auth::user()->id_dosen."'"
                        ])
                        ->where('id_dosen', Auth::user()->id_dosen)
                        ->pluck('id_kelas_kuliah')->toArray();

        $query = m_kelas_kuliah::setFilter([
                    'filter' => "id_semester='$semester_aktif'",
                ])
                ->whereIn('id_kelas_kuliah', $kelasKuliah)
                ->when($request->prodi, function($q) use ($request){
                    $q->where('id_prodi', $request->prodi);
                })->get();

        $query->map(function ($item){
            $matkul = m_mata_kuliah::setFilter([
                'filter' => "id_matkul='$item->id_matkul'"
            ])->first();
            $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();
            $item['hari'] = $jadwal->hari ?? null;
            $item['jam_mulai'] = $jadwal->jam_mulai ?? null;
            $item['jam_akhir'] = $jadwal->jam_akhir ?? null;
            $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;

            return $item;
        });

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('jumlah_mahasiswa', function ($data) {
                return '-';
            })
            ->addColumn('jadwal',function ($data) {
                if($data->hari && $data->jam_mulai && $data->jam_akhir) {
                    return $data->hari.', '.$data->jam_mulai.'-'.$data->jam_akhir;
                }

                return '-';
            })
            ->addColumn('cetak_presensi',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Status',
                    'class' => 'btn btn-primary btn-sm',
                    "label" => "Unduh Presensi",
                    "route" => route('dosen.jadwal_mengajar.cetak_presensi', $data->id_kelas_kuliah),
                ]);

                return $button;
            })
            ->rawColumns(['cetak_presensi'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function daftar_peserta($id_jadwal)
    {
        $peserta = t_krs::where('id_jadwal', $id_jadwal)->get();

        return view('dosen.jadwal_mengajar.daftar_peserta', compact('peserta'));
    }

    public function update(KontrakRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $data = $request->except('path_kontrak_belajar', 'path_rpp');

            $m_jadwal = m_jadwal::findOrFail($id);

            if ($request->hasFile('path_kontrak_belajar')) {
                remove_in_local($m_jadwal->path_kontrak_belajar);

                $data['path_kontrak_belajar'] = upload_in_local('path_kontrak_belajar', $request->file('path_kontrak_belajar'), 'path_kontrak_belajar');
            }

            if ($request->hasFile('path_rpp')) {
                remove_in_local($m_jadwal->path_rpp);

                $data['path_rpp'] = upload_in_local('path_rpp', $request->file('path_rpp'), 'path_rpp');
            }

            $m_jadwal->update($data);
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('dosen.jadwal_mengajar.index');
        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function cetak_presensi(Request $request, $id_kelas_kuliah)
    { 

        $kelas = m_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->first();
        $dosen = t_dosen_pengajar_kelas_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->first();

        $jadwal = m_jadwal::where('id_kelas_kuliah', $id_kelas_kuliah)->first();

        $jurnal = t_jurnal_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->get();
        $data_jurnal = t_jurnal_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->pluck('id')->toArray();

        $absensi = t_absensi_mahasiswa::whereIn('id_jurnal_kuliah', $data_jurnal)->get();
        $list_mahasiswa = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->get();

        $pdf = PDF::loadView('dosen.jadwal_mengajar.cetak_presensi', compact('dosen','jurnal', 'data_jurnal', 'absensi', 'list_mahasiswa', 'kelas', 'jadwal'))->setPaper('a4', 'landscape');
        return $pdf->stream('Presensi_-_Kelas-_-'.$kelas->nama_mata_kuliah.'.pdf');
    }
}
