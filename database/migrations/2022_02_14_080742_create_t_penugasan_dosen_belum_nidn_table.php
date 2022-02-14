<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPenugasanDosenBelumNidnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_penugasan_dosen_belum_nidn', function (Blueprint $table) {
            $table->uuid('id_registrasi_dosen');
            $table->uuid('id_dosen');
            $table->string('nama_dosen');
            $table->string('nidn')->nullable();
            $table->integer('id_tahun_ajaran');
            $table->string('nama_tahun_ajaran');
            $table->uuid('id_perguruan_tinggi');
            $table->string('nama_perguruan_tinggi');
            $table->uuid('id_prodi');
            $table->string('nama_program_studi');
            $table->string('nomor_surat_tugas');
            $table->date('tanggal_surat_tugas');
            $table->date('mulai_surat_tugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_penugasan_dosen_belum_nidn');
    }
}
