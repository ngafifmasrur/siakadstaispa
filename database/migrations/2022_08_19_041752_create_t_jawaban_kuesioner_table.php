<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTJawabanKuesionerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_jawaban_kuesioner', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('t_kuesioner_id');
            $table->string('kuesioner');
            $table->string('jawaban');
            $table->string('skor');
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
        Schema::dropIfExists('t_jawaban_kuesioner');
    }
}
