<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTUjiMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_uji_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_aktivitas');
            $table->bigInteger('id_kategori_kegiatan');
            $table->bigInteger('id_dosen');
            $table->double('penguji_ke');
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
        Schema::dropIfExists('t_uji_mahasiswa');
    }
}
