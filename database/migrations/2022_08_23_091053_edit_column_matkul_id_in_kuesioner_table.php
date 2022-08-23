<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnMatkulIdInKuesionerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_kuesioner', function (Blueprint $table) {
            $table->string('matkul_id')->change();
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
            $table->dropColumn('matkul_id');
        });
    }
}
