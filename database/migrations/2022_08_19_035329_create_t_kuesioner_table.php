<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTKuesionerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_kuesioner', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kuesioner_id');
            $table->bigInteger('dosen_id');
            $table->bigInteger('mahasiswa_id');
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
        Schema::dropIfExists('t_kuesioner');
    }
}
