<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPenelitianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_penelitian', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_prodi');
            $table->uuid('id_dosen');
            $table->string('ketua');
            $table->string('anggota_1');
            $table->string('anggota_2');
            $table->string('anggota_3');
            $table->string('sumber_dana');
            $table->double('nominal');
            $table->smallInteger('tahun');
            $table->string('judul_penelitian');
            $table->string('link')->nullable();
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
        Schema::dropIfExists('t_penelitian');
    }
}
