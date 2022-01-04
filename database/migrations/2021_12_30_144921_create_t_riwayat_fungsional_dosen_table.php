<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRiwayatFungsionalDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_riwayat_fungsional_dosen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_dosen');
            $table->bigInteger('id_jabatan_fungsional');
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
        Schema::dropIfExists('t_riwayat_fungsional_dosen');
    }
}
