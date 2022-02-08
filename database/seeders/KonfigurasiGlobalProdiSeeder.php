<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\m_global_konfigurasi_prodi;
use App\Models\m_program_studi;

class KonfigurasiGlobalProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prodi = m_program_studi::all();
        $prodi->each(function($prodi, $key) {
            m_global_konfigurasi_prodi::create([
                'id_prodi' => $prodi->id_prodi,
                'nama_prodi' => $prodi->nama_program_studi,
                'buka_krs' => 1,
                'buka_penilaian' => 1,
                'buka_khs' => 1,
                'buka_transkrip' => 1,
                'buka_kartu_ujian' => 1,
            ]);
       });
    }
}
