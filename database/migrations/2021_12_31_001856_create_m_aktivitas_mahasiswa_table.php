<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMAktivitasMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_aktivitas_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('jenis_anggota');
            $table->bigInteger('id_jenis_aktivitas');
            $table->bigInteger('id_prodi');
            $table->bigInteger('id_semester');
            $table->string('judul');
            $table->text('keterangan')->nullable();
            $table->string('sk_tugas')->nullable();
            $table->string('lokasi')->nullable();
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
        Schema::dropIfExists('m_aktivitas_mahasiswa');
    }
}
