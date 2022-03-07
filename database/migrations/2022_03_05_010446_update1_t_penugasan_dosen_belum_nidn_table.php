<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update1TPenugasanDosenBelumNidnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_penugasan_dosen_belum_nidn', function (Blueprint $table) {
            $table->string('jk')->nullable();
            $table->date('tgl_create')->nullable();
            $table->date('tgl_ptk_keluar')->nullable();
            $table->string('id_stat_pegawai')->nullable();
            $table->string('id_jns_keluar')->nullable();
            $table->string('id_ikatan_kerja')->nullable();
            $table->string('a_sp_homebase')->nullable();

        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_penugasan_dosen_belum_nidn', function (Blueprint $table) {
            $table->dropColumn([
                'jk',
                'tgl_create',
                'tgl_ptk_keluar',
                'id_stat_pegawai',
                'id_jns_keluar',
                'id_ikatan_kerja',
                'a_sp_homebase'
            ]);
        });
    }
}