<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_dosen', function (Blueprint $table) {
            $table->uuid('id_dosen')->primary();
            $table->string('nama_dosen');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->bigInteger('id_agama');
            $table->bigInteger('id_status_aktif');
            $table->string('nidn');
            $table->string('nama_ibu');
            $table->string('nik');
            $table->string('nip')->nullable();
            $table->string('npwp')->nullable();
            $table->bigInteger('id_jenis_sdm');
            $table->string('no_sk_cpns')->nullable();
            $table->string('tanggal_sk_cpns')->nullable();
            $table->string('no_sk_pengangkatan')->nullable();
            $table->date('mulai_sk_pengangkatan')->nullable();
            $table->bigInteger('id_lembaga_pengangkatan')->nullable();
            $table->bigInteger('id_pangkat_golongan')->nullable();
            $table->bigInteger('id_sumber_gaji')->nullable();
            $table->string('jalan')->nullable();
            $table->string('dusun')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('ds_kel')->nullable();
            $table->string('kode_pos')->nullable();
            $table->bigInteger('id_wilayah');
            $table->string('telepon');
            $table->string('handphone')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('status_pernikahan')->nullable();
            $table->string('nip_suami_istri')->nullable();
            $table->bigInteger('id_pekerjaan_suami_istri')->nullable();
            $table->date('tanggal_mulai_pns')->nullable();
            $table->boolean('mampu_handle_kebutuhan_khusus');
            $table->boolean('mampu_handle_braille');
            $table->boolean('mampu_handle_bahasa_isyarat');
            $table->integer('user_id');
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
        Schema::dropIfExists('m_dosen');
    }
}
