<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_krs_mahasiswa,
    t_dosen_wali_mahasiswa,
    m_global_konfigurasi,
    t_peserta_kelas_kuliah,
    m_mata_kuliah,
    m_jadwal,
    t_riwayat_pendidikan_mahasiswa,
    m_kelas_kuliah
};

use Session, DB, Auth;


class VervalKRSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwal = m_jadwal::all();
        return view('dosen.verval_krs.index', compact('jadwal'));
    }

    public function data_index(Request $request)
    {

        $mahasiswa = t_dosen_wali_mahasiswa::where('id_dosen', Auth::user()->id_dosen)
                    ->pluck('id_registrasi_mahasiswa')->toArray();
        $query = t_krs_mahasiswa::whereIn('id_registrasi_mahasiswa', $mahasiswa)->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Verifikasi KRS',
                    'class' => 'btn btn-outline-success btn-sm btn_edit',
                    "label" => "Ubah Status",
                    "route" => route('dosen.verval_krs.verifikasi', $data->id),
                ]);

                return $button;
            })
            ->addColumn('mahasiswa', function ($data) {
                return $data->mahasiswa->nama_mahasiswa;
            })
            ->addColumn('nim_mahasiswa', function ($data) {
                return $data->mahasiswa->nim;
            })
            ->addColumn('nama_program_studi', function ($data) {
                return $data->mahasiswa->nama_program_studi;
            })
            ->addColumn('status', function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Verifikasi KRS',
                    'class' => 'btn btn-primary btn-sm',
                    "label" => $data->status,
                ]);

                return $button;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request, $id)
    {
 
        $rules = [];
        $rules['status'] = ['required', 'in:Diverifikasi,Ditolak'];
        if ($request->status == 'Ditolak') {
            $rules['alasan_penolakan'] = ['required', 'string'];
        }
        $this->validate($request, $rules);

        $krs_mahasiswa = t_krs_mahasiswa::findOrFail($id);

        if(is_null($krs_mahasiswa)){
            abort(404);
        }

        $krs_mahasiswa->update([
            'status' => $request->status,
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        Session::flash('success_msg', 'Status Berhasil Diubah');
        return redirect()->route('dosen.verval_krs.index');
    }

    public function verifikasi($id)
    {
        $krs_mahasiswa = t_krs_mahasiswa::findOrFail($id);
        $id_registrasi_mahasiswa = $krs_mahasiswa->id_registrasi_mahasiswa;

        return view('dosen.verval_krs.verifikasi', compact('id_registrasi_mahasiswa', 'krs_mahasiswa'));
    }

    public function verifikasi_data_index($id_registrasi_mahasiswa)
    {

        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_registrasi_mahasiswa='$id_registrasi_mahasiswa'"
        ])->first();

        $kelasKuliah = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_mahasiswa='$mahasiswa->id_mahasiswa'"
        ])->pluck('id_kelas_kuliah')->toArray();
        
        $query = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_kelas_kuliah', $kelasKuliah)->get();

        $query->map(function ($item) {
            // Mata Kuliah
            $matkul = m_mata_kuliah::setFilter([
                'filter' => "id_matkul='$item->id_matkul'"
            ])->first();
            // Jadwal
            $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();

            $item['hari'] = $item->hari;
            $item['jam_mulai'] = $item->jam_mulai;
            $item['jam_akhir'] = $item->jam_akhir;
            $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;

            return $item;
        });

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('sks_mata_kuliah',function ($data) {
                return $data->sks_mata_kuliah;
            })
            ->addColumn('nama_dosen', function ($data) {
                return '-';
            })
            ->addColumn('jadwal',function ($data) {
                if($data->hari && $data->jam_mulai && $data->jam_akhir) {
                    return $data->hari.', '.$data->jam_mulai.'-'.$data->jam_akhir;
                }

                return '-';
            })
            ->addColumn('action',function ($data) {
                return '-';
            })
            ->addColumn('jadwal',function ($data) {
                if($data->hari && $data->jam_mulai && $data->jam_akhir) {
                    return $data->hari.', '.$data->jam_mulai.'-'.$data->jam_akhir;
                }

                return '-';
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }
}
