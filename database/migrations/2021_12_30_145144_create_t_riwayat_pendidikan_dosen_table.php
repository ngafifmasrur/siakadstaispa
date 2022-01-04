<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRiwayatPendidikanDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_riwayat_pendidikan_dosen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_dosen');
            $table->bigInteger('id_bidang_studi');
            $table->bigInteger('id_jenjang_pendidikan');
            $table->bigInteger('id_gelar_akademik');
            $table->bigInteger('id_perguruan_tinggi');
            $table->string('fakultas');
            $table->string('tahun_lulus');
            $table->string('sks_lulus');
            $table->string('ipk');
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
        Schema::dropIfExists('t_riwayat_pendidikan_dosen');
    }
}
