<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMPerguruanTinggiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_perguruan_tinggi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perguruan_tinggi');
            $table->string('nama_perguruan_tinggi');
            $table->string('telepon')->nullable();
            $table->string('faximile')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('jalan')->nullable();
            $table->string('dusun')->nullable();
            $table->string('rt_rw')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kode_pos');
            $table->bigInteger('id_wilayah');
            $table->string('lintang_bujur');
            $table->string('bank');
            $table->string('unit_cabang');
            $table->string('nomor_rekening');
            $table->double('mbs');
            $table->double('luas_tanah_milik');
            $table->double('luas_tanah_bukan_milik');
            $table->string('sk_pendirian');
            $table->date('tanggal_sk_pendirian');
            $table->boolean('id_status_milik');
            $table->string('status_perguruan_tinggi');
            $table->string('sk_izin_operasional');
            $table->date('tanggal_izin_operasional');
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
        Schema::dropIfExists('m_perguruan_tinggi');
    }
}
