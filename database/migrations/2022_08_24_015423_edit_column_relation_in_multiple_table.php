<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnRelationInMultipleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_kuesioner', function (Blueprint $table) {
            $table->string('kuesioner_id')->default(0)->change();
        });
        Schema::table('t_jawaban_kuesioner', function (Blueprint $table) {
            $table->string('m_kuesioner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_kuesioner', function (Blueprint $table) {
            $table->dropColumn('kuesioner_id');
        });
    }
}
