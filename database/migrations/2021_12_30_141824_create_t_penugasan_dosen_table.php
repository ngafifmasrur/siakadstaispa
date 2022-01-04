<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPenugasanDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_penugasan_dosen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_dosen');
            $table->bigInteger('id_tahun_ajaran');
            $table->bigInteger('id_perguruan_tinggi');
            $table->bigInteger('id_prodi');
            $table->string('nomor_surat_tugas');
            $table->date('tanggal_surat_tugas')->nullable();
            $table->date('mulai_surat_tugas')->nullable();
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
        Schema::dropIfExists('t_penugasan_dosen');
    }
}
