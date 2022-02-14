<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDosenBelumNidnPengajarKelasKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_dosen_belum_nidn_pengajar_kelas_kuliah', function (Blueprint $table) {
            $table->uuid('id_aktivitas_mengajar');
            $table->uuid('id_registrasi_dosen');
            $table->uuid('id_dosen');
            $table->string('nidn')->nullable();
            $table->string('nama_dosen');
            $table->uuid('id_kelas_kuliah');
            $table->string('nama_kelas_kuliah');
            $table->integer('id_substansi')->nullable();
            $table->integer('sks_substansi_total');
            $table->integer('rencana_minggu_pertemuan')->nullable();
            $table->integer('realisasi_minggu_pertemuan')->nullable();
            $table->integer('id_jenis_evaluasi');
            $table->string('nama_jenis_evaluasi');
            $table->uuid('id_prodi');
            $table->integer('id_semester');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_dosen_belum_nidn_pengajar_kelas_kuliah');
    }
}