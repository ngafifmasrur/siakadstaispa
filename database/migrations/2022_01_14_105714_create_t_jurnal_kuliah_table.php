<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTJurnalKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_jurnal_kuliah', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_prodi');
            $table->uuid('id_dosen');
            $table->uuid('id_kelas_kuliah');
            $table->date('tanggal_pelaksanaan');
            $table->longText('topik')->nullable();
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
        Schema::dropIfExists('t_jurnal_kuliah');
    }
}
