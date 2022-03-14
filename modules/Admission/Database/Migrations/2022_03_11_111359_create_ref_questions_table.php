<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_questions', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('cbt_id');
            $table->longText('soal');
            $table->longText('jawaban_a');
            $table->longText('jawaban_b');
            $table->longText('jawaban_c');
            $table->longText('jawaban_d');
            $table->longText('jawaban_e')->nullable();
            $table->string('jawaban_benar');
            $table->float('skor')->nullable();
            $table->integer('status')->default(0); // 1 mengerjakan, 2 selesai
            $table->timestamps();

            $table->foreign('cbt_id')->references('id')->on('admission_cbt')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_questions');
    }
}
