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
            $table->id();
            $table->string('nama_dosen');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->bigInteger('id_agama');
            $table->bigInteger('id_status_aktif');
            $table->string('nidn');
            $table->string('nama_ibu');
            $table->string('nik');
            $table->string('nip');
            $table->string('npwp');
            $table->bigInteger('id_jenis_sdm');
            $table->string('no_sk_cpns');
            $table->string('tanggal_sk_cpns');
            $table->string('no_sk_pengangkatan');
            $table->date('mulai_sk_pengangkatan');
            $table->bigInteger('id_lembaga_pengangkatan');
            $table->bigInteger('id_pangkat_golongan');
            $table->bigInteger('id_sumber_gaji');
            $table->string('jalan');
            $table->string('dusun');
            $table->string('rt');
            $table->string('rw');
            $table->string('ds_kel');
            $table->string('kode_pos');
            $table->bigInteger('id_wilayah');
            $table->string('telepon');
            $table->string('handphone');
            $table->string('email');
            $table->bigInteger('status_pernikahan');
            $table->string('nip_suami_istri');
            $table->date('tanggal_mulai_pns');
            $table->bigInteger('id_pekerjaan_suami_istri');
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
