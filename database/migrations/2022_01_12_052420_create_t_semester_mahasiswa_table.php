<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTSemesterMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_semester_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_mahasiswa');
            $table->bigInteger('id_tahun_ajaran');
            $table->bigInteger('id_semester');
            $table->uuid('id_prodi');
            $table->integer('semester');
            $table->enum('status', ['Aktif', 'Tidak Aktif']);
            $table->double('sks')->nullable();
            $table->double('ips')->nullable();
            $table->uuid('id_dosen_pembimbing')->nullable();
            $table->enum('status_krs', ['Belum Mengajukan', 'Mengajukan', 'Diverifikasi', 'Ditolak']);
            $table->text('catatan_krs')->nullable();
            $table->string('status_pembayaran_spp')->nullable();
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
        Schema::dropIfExists('t_semester_mahasiswa');
    }
}
