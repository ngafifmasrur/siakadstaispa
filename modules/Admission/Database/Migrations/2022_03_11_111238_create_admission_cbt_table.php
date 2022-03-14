<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionCbtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_cbt', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('mapel');
            $table->string('kode_mapel');
            $table->string('description')->nullable();
            $table->double('durasi');
            $table->integer('status')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admission_cbt');
    }
}
