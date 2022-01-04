<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKelasKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kelas_kuliah', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_prodi');
            $table->bigInteger('id_semester');
            $table->bigInteger('id_matkul');
            $table->string('nama_kelas_kuliah');
            $table->string('bahasan')->nullable();
            $table->date('tanggal_mulai_efektif')->nullable();
            $table->date('tanggal_akhir_efektif')->nullable();
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
        Schema::dropIfExists('m_kelas_kuliah');
    }
}
