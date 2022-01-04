<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTNilaiTransferPendidikanMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_nilai_transfer_pendidikan_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_registrasi_mahasiswa');
            $table->bigInteger('id_matkul');
            $table->string('kode_mata_kuliah_asal');
            $table->string('nama_mata_kuliah_asal');
            $table->bigInteger('sks_mata_kuliah_asal');
            $table->bigInteger('sks_mata_kuliah_diakui');
            $table->string('nilai_huruf_asal');
            $table->string('nilai_huruf_diakui');
            $table->string('nilai_angka_diakui');
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
        Schema::dropIfExists('t_nilai_transfer_pendidikan_mahasiswa');
    }
}
