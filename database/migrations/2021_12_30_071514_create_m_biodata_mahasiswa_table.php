<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBiodataMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_biodata_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_mahasiswa');
            $table->string('nama_mahasiswa');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('jalan')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nik');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nama_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->bigInteger('id_jenjang_pendidikan_ayah')->nullable();
            $table->bigInteger('id_pekerjaan_ayah')->nullable();
            $table->bigInteger('id_penghasilan_ayah')->nullable();
            $table->bigInteger('id_kebutuhan_khusus_ayah');
            $table->string('nama_ibu_kandung');
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->bigInteger('id_jenjang_pendidikan_ibu')->nullable();
            $table->bigInteger('id_pekerjaan_ibu')->nullable();
            $table->bigInteger('id_penghasilan_ibu')->nullable();
            $table->bigInteger('id_kebutuhan_khusus_ibu');
            $table->string('nama_wali')->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->bigInteger('id_jenjang_pendidikan_wali')->nullable();
            $table->bigInteger('id_pekerjaan_wali')->nullable();
            $table->bigInteger('id_penghasilan_wali')->nullable();
            $table->bigInteger('id_kebutuhan_khusus_mahasiswa');
            $table->string('telepon')->nullable();
            $table->string('handphone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('penerima_kps');
            $table->string('no_kps')->nullable();
            $table->string('npwp')->nullable();
            $table->bigInteger('id_wilayah');
            $table->bigInteger('id_jenis_tinggal')->nullable();
            $table->bigInteger('id_agama');
            $table->bigInteger('id_alat_transportasi')->nullable();
            $table->string('kewarganegaraan');
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
        Schema::dropIfExists('m_biodata_mahasiswa');
    }
}
