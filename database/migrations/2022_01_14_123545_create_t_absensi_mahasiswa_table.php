<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTAbsensiMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_absensi_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->integer('id_jurnal_kuliah');
            $table->uuid('id_mahasiswa');
            $table->enum('status', ['Hadir', 'Sakit', 'Ijin', 'Alpa']);
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
        Schema::dropIfExists('t_absensi_mahasiswa');
    }
}
