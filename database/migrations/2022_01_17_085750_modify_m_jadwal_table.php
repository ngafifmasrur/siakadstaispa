<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_jadwal', function (Blueprint $table) {
            $table->text('kontrak_belajar')->nullable();
            $table->string('path_kontrak_belajar')->nullable();
            $table->string('path_rpp')->nullable();
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
            $table->dropColumn([
                'kontrak_belajar',
                'path_kontrak_belajar',
                'path_rpp',
            ]);
        });
    }
}
