<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMMataKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_mata_kuliah', function (Blueprint $table) {
            $table->uuid('id_matkul')->primary();
            $table->uuid('id_prodi');
            $table->string('kode_mata_kuliah');
            $table->string('nama_mata_kuliah');
            $table->string('id_jenis_mata_kuliah');
            $table->string('id_kelompok_mata_kuliah');
            $table->double('sks_mata_kuliah');
            $table->double('sks_tatap_muka');
            $table->double('sks_praktek');
            $table->double('sks_praktek_lapangan');
            $table->double('sks_simulasi');
            $table->string('metode_kuliah');
            $table->boolean('ada_sap');
            $table->boolean('ada_silabus');
            $table->boolean('ada_bahan_ajar');
            $table->boolean('ada_acara_praktek');
            $table->boolean('ada_diktat');
            $table->boolean('paket');
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
        Schema::dropIfExists('m_mata_kuliah');
    }
}
