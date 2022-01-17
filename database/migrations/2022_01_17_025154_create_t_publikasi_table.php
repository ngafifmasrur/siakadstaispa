<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPublikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_publikasi', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_prodi');
            $table->uuid('id_dosen');
            $table->string('sifat_publikasi');
            $table->smallInteger('tahun');
            $table->string('judul');
            $table->string('tempat_publikasi');
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
        Schema::dropIfExists('t_publikasi');
    }
}
