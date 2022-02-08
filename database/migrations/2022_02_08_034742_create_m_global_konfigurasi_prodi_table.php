<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMGlobalKonfigurasiProdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_global_konfigurasi_prodi', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_prodi');
            $table->string('nama_prodi');
            $table->boolean('buka_krs');
            $table->boolean('buka_penilaian');
            $table->boolean('buka_khs');
            $table->boolean('buka_transkrip');
            $table->boolean('buka_kartu_ujian');
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
        Schema::dropIfExists('m_global_konfigurasi_prodi');
    }
}
