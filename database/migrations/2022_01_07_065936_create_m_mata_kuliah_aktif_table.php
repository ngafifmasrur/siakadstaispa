<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMMataKuliahAktifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_mata_kuliah_aktif', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_prodi');
            $table->uuid('id_matkul');
            $table->integer('id_semester');
            $table->integer('semester');
            $table->boolean('mk_wajib');
            $table->boolean('mk_paket');
            $table->string('nilai_minimum');
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
        Schema::dropIfExists('m_mata_kuliah_aktif');
    }
}
