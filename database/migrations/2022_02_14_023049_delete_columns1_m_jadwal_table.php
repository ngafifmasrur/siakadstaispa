<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumns1MJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_jadwal', function (Blueprint $table) {
            $table->dropColumn('id_dosen');
            $table->dropColumn('id_ruang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_jadwal', function (Blueprint $table) {
            $table->uuid('id_dosen');
            $table->integer('id_ruang');
        });
    }
}
