<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTAnggotaAktifitasMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_anggota_aktifitas_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_aktivitas');
            $table->bigInteger('id_registrasi_mahasiswa');
            $table->string('jenis_peran');
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
        Schema::dropIfExists('t_anggota_aktifitas_mahasiswa');
    }
}
