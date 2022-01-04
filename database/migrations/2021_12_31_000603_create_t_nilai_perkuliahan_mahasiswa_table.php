<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTNilaiPerkuliahanMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_nilai_perkuliahan_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_prodi');
            $table->bigInteger('id_semester');
            $table->bigInteger('id_matkul');
            $table->bigInteger('id_kelas_kuliah');
            $table->bigInteger('id_registrasi_mahasiswa');
            $table->string('jurusan');
            $table->string('angkatan');
            $table->decimal('nilai_angka')->nullable();
            $table->decimal('nilai_indeks')->nullable();
            $table->decimal('nilai_huruf')->nullable();
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
        Schema::dropIfExists('t_nilai_perkuliahan_mahasiswa');
    }
}
