<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_jadwal', function (Blueprint $table) {
            $table->id();
            $table->integer('id_prodi');
            $table->integer('id_dosen');
            $table->integer('id_kelas');
            $table->integer('id_matkul_aktif');
            $table->integer('id_ruang');
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_akhir');
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
        Schema::dropIfExists('m_jadwal');
    }
}
