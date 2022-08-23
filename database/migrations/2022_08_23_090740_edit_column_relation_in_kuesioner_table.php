<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnRelationInKuesionerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_kuesioner', function (Blueprint $table) {
            $table->string('kuesioner_id')->change();
            $table->string('dosen_id')->change();
            $table->string('mahasiswa_id')->change();
        });
        Schema::table('t_jawaban_kuesioner', function (Blueprint $table) {
            $table->string('t_kuesioner_id')->change();
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
