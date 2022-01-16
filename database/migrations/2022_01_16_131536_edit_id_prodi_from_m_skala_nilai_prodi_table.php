<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditIdProdiFromMSkalaNilaiProdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_skala_nilai_prodi', function (Blueprint $table) {
            $table->uuid('id_prodi')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_skala_nilai_prodi', function (Blueprint $table) {
            //
        });
    }
}
