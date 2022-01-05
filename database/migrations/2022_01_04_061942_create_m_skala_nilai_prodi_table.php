<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSkalaNilaiProdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_skala_nilai_prodi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_prodi');
            $table->string('nilai_huruf');
            $table->double('nilai_indeks')->nullable();
            $table->double('bobot_minimum');
            $table->double('bobot_maksimum');
            $table->date('tanggal_mulai_efektif');
            $table->date('tanggal_selesai_efektif');
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
        Schema::dropIfExists('m_skala_nilai_prodi');
    }
}
