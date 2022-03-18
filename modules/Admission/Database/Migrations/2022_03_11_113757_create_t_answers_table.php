<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('registrant_id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('cbt_id');
            $table->unsignedInteger('registrant_cbt_id');
            $table->string('jawaban_benar')->nullable();
            $table->string('jawaban_peserta')->nullable();
            $table->float('skor');
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('ref_questions')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('t_answers');
    }
}
