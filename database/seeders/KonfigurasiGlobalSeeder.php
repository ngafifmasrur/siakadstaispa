<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\m_global_konfigurasi;
use App\Models\m_semester;

class KonfigurasiGlobalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $semester = m_semester::where('a_periode_aktif', '1')->first();

        m_global_konfigurasi::create([
            'id_semester_aktif' => $semester->id_semester,
            'nama_semester_aktif' => $semester->nama_semester,
            'id_tahun_ajaran' => $semester->id_tahun_ajaran,
            'nama_tahun_ajaran' => $semester->nama_semester,
            'id_semester_nilai' => $semester->id_semester,
            'perhitungan_matkul' => 'Nilai Tertinggi',
            'id_semester_krs' => $semester->id_semester,
            'id_semester_tracer_study' => $semester->id_semester,
            'batas_sks_krs' => 0,
        ]);
    }
}
