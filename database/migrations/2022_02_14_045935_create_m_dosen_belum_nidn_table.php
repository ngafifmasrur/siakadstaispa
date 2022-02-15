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
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->integer('id_agama')->nullable();
            $table->string('nama_agama')->nullable();
            $table->integer('id_status_aktif')->nullable();
            $table->string('nama_status_aktif')->nullable();
            $table->string('nidn')->nullable();
            $table->string('nama_ibu_kandung');
            $table->string('nik');
            $table->string('nip')->nullable();
            $table->string('npwp')->nullable();
            $table->string('id_jenis_sdm')->nullable();
            $table->string('nama_jenis_sdm')->nullable();
            $table->string('no_sk_cpns')->nullable();
            $table->date('tanggal_sk_cpns')->nullable();
            $table->string('no_sk_pengangkatan')->nullable();
            $table->string('mulai_sk_pengangkatan')->nullable();
            $table->integer('id_lembaga_pengangkatan')->nullable();
            $table->string('nama_lembaga_pengangkatan')->nullable();
            $table->integer('id_pangkat_golongan')->nullable();
            $table->string('nama_pangkat_golongan')->nullable();
            $table->integer('id_sumber_gaji')->nullable();
            $table->string('nama_sumber_gaji')->nullable();
            $table->string('jalan')->nullable();
            $table->string('dusun')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('ds_kel')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('id_wilayah')->nullable();
            $table->string('nama_wilayah')->nullable();
            $table->string('telepon')->nullable();
            $table->string('handphone')->nullable();
            $table->string('email')->nullable();
            $table->integer('status_pernikahan');
            $table->string('nama_suami_istri')->nullable();
            $table->string('nip_suami_istri')->nullable();
            $table->date('tanggal_mulai_pns')->nullable();
            $table->integer('id_pekerjaan_suami_istri')->nullable();
            $table->string('nama_pekerjaan_suami_istri')->nullable();
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
