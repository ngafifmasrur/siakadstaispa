<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSemesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_semester', function (Blueprint $table) {
            $table->bigInteger('id_semester')->primary();
            $table->bigInteger('id_tahun_ajaran');
            $table->string('nama_semester');
            $table->integer('semester');
            $table->boolean('a_periode_aktif');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
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
        Schema::dropIfExists('m_semester');
    }
}
