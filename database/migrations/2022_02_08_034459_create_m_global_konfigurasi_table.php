<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMGlobalKonfigurasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_global_konfigurasi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_semester_aktif');
            $table->bigInteger('id_semester_nilai');
            $table->string('perhitungan_matkul');
            $table->bigInteger('id_semester_krs');
            $table->bigInteger('id_semester_tracer_study');
            $table->bigInteger('batas_sks_krs');
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
        Schema::dropIfExists('m_global_konfigurasi');
    }
}
