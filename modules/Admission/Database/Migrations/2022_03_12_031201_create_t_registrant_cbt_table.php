<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTRegistrantCbtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_registrant_cbt', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('registrant_id');
            $table->unsignedInteger('cbt_id');
            $table->datetime('waktu_mulai');
            $table->datetime('waktu_selesai')->nullable();
            $table->double('sisa_waktu')->nullable();
            $table->integer('status')->default(0); // 1 mengerjakan, 2 selesai
            $table->integer('total_skor')->default(0);
            $table->integer('jumlah_jawaban_benar')->nullable();
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
        Schema::dropIfExists('t_registrant_cbt');
    }
}
