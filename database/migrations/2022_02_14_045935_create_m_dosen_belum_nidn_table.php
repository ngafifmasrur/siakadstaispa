<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMDosenBelumNidnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('m_dosen_belum_nidn', function (Blueprint $table) {
            $table->uuid('id_dosen');
            $table->string('nama_dosen');
            $table->string('nidn')->nullable();
            $table->string('nip');
            $table->string('jenis_kelamin');
            $table->integer('id_agama');
            $table->string('nama_agama');
            $table->date('tanggal_lahir');
            $table->boolean('id_status_aktif');
            $table->string('nama_status_aktif');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_dosen_belum_nidn');
    }
}
