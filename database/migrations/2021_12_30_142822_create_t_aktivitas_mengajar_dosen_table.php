<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTAktivitasMengajarDosenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_aktivitas_mengajar_dosen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_dosen');
            $table->bigInteger('id_periode');
            $table->bigInteger('id_prodi');
            $table->bigInteger('id_matkul');
            $table->bigInteger('id_kelas');
            $table->string('rencana_tatap_muka');
            $table->string('realisasi_tatap_muka');
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
        Schema::dropIfExists('t_aktivitas_mengajar_dosen');
    }
}
