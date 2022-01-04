<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPesertaKelasKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_peserta_kelas_kuliah', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_kelas_kuliah');
            $table->bigInteger('id_registrasi_mahasiswa');
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
        Schema::dropIfExists('t_peserta_kelas_kuliah');
    }
}
