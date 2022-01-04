<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRiwayatPangkatDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_riwayat_pangkat_dosen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_dosen');
            $table->bigInteger('id_pangkat_golongan');
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
        Schema::dropIfExists('t_riwayat_pangkat_dosen');
    }
}
