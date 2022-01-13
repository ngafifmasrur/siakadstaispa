<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMProdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_prodi', function (Blueprint $table) {
            $table->uuid('id_prodi')->primary();
            $table->string('kode_program_studi');
            $table->string('nama_program_studi');
            $table->string('status');
            $table->bigInteger('id_jenjang_pendidikan');
            $table->string('nama_jenjang_pendidikan');
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
        Schema::dropIfExists('m_prodi');
    }
}
