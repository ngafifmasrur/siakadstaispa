<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMRiwayatPendidikanMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_riwayat_pendidikan_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_mahasiswa');
            $table->bigInteger('id_jenis_daftar');
            $table->bigInteger('id_jalur_daftar');
            $table->bigInteger('id_periode_masuk');
            $table->bigInteger('id_perguruan_tinggi');
            $table->bigInteger('id_prodi');
            $table->bigInteger('id_perguruan_tinggi_asal');
            $table->bigInteger('id_prodi_asal');
            $table->bigInteger('id_pembiayaan');
            $table->bigInteger('sks_diakui');
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
        Schema::dropIfExists('m_riwayat_pendidikan_mahasiswa');
    }
}
