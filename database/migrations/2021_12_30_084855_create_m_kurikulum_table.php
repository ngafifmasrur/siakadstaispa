<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKurikulumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kurikulum', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kurikulum');
            $table->bigInteger('id_prodi');
            $table->bigInteger('id_semester');
            $table->double('jumlah_sks_lulus');
            $table->double('jumlah_sks_wajib');
            $table->double('jumlah_sks_pilihan');
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
        Schema::dropIfExists('m_kurikulum');
    }
}
