<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDosenPengajarKelasKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_dosen_pengajar_kelas_kuliah', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_registrasi_dosen');
            $table->bigInteger('id_kelas_kuliah');
            $table->bigInteger('id_jenis_evaluasi');
            $table->bigInteger('id_substansi');
            $table->double('sks_substansi_total');
            $table->double('rencana_tatap_muka');
            $table->double('realisasi_tatap_muka');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_dosen_pengajar_kelas_kuliah');
    }
}
