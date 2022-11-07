<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWakilKetuaBidangAkademikToMGlobalKonfigurasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_global_konfigurasi', function (Blueprint $table) {
            $table->string('wakil_ketua_bidang_akademik')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_global_konfigurasi', function (Blueprint $table) {
            $table->dropColumn('wakil_ketua_bidang_akademik');
        });
    }
}
