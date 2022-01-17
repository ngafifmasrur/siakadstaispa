<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPengabdianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pengabdian', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_prodi');
            $table->uuid('id_dosen');
            $table->string('sumber_dana');
            $table->double('nominal');
            $table->smallInteger('tahun');
            $table->string('judul_pengabdian');
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
        Schema::dropIfExists('t_pengabdian');
    }
}
