<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPerkuliahanMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_perkuliahan_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_registrasi_mahasiswa');
            $table->bigInteger('id_semester');
            $table->bigInteger('id_status_mahasiswa');
            $table->double('ips')->nullable();
            $table->double('ipk')->nullable();
            $table->double('sks_semester')->nullable();
            $table->double('total_sks')->nullable();
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
        Schema::dropIfExists('t_perkuliahan_mahasiswa');
    }
}
