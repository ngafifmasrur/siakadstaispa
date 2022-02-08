<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    m_global_konfigurasi,
    m_global_konfigurasi_prodi,
    m_semester
};
use DB, Session;

class KonfigurasiGlobalController extends Controller
{
    public function index()
    {
        $konfigurasi_global = m_global_konfigurasi::first();
        $konfigurasi_global_prodi = m_global_konfigurasi_prodi::all();

        return view('admin.konfigurasi_global.index', compact('konfigurasi_global','konfigurasi_global_prodi'));
    }

    public function edit()
    {
        $konfigurasi_global = m_global_konfigurasi::first();
        $konfigurasi_global_prodi = m_global_konfigurasi_prodi::all();
        $semester = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        return view('admin.konfigurasi_global.edit', compact('konfigurasi_global','konfigurasi_global_prodi', 'semester'));
    }

    public function update(Request $request)
    {
        $konfigurasi_global = m_global_konfigurasi::first();
        $konfigurasi_global_prodi = m_global_konfigurasi_prodi::all();

        DB::beginTransaction();

        try {

            $konfigurasi_global->update([
                'id_semester_aktif' => $request->id_semester_aktif,
                'id_semester_nilai' => $request->id_semester_nilai,
                'perhitungan_matkul' => $request->perhitungan_matkul,
                'id_semester_krs' => $request->id_semester_krs,
                'id_semester_tracer_study' => $request->id_semester_tracer_study,
                'batas_sks_krs' => $request->batas_sks_krs,
            ]);

            $konfigurasi_global_prodi->each(function($konfig_prodi, $key) use ($request) {
                $konfig_prodi->update([
                    'buka_krs' => $request->buka_krs_.$key ?? 0,
                    'buka_penilaian' => $request->buka_penilaian_.$key ?? 0,
                    'buka_khs' => $request->buka_khs_.$key ?? 0,
                    'buka_transkrip' => $request->buka_transkrip_.$key ?? 0,
                    'buka_kartu_ujian' => $request->buka_kartu_ujian_.$key ?? 0,
                ]);
           });

            Session::flash('success_msg', 'Konfigurasi berhasil disimpan');
            return redirect()->route('admin.konfigurasi_global.index');
        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }
    
}
