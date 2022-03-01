<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstancesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insts', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('short_name');
            $table->string('name');
            $table->string('long_name');
            $table->timestamps();
        });

        Schema::create('inst_announcements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('inst_id');
            $table->string('title');
            $table->string('content');
            $table->string('url')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('inst_id')->references('id')->on('insts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('inst_buildings', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('inst_id');
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('village')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('postal')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('inst_id')->references('id')->on('insts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('ref_province_regency_districts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('inst_building_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('building_id');
            $table->string('kd');
            $table->string('name');
            $table->unsignedTinyInteger('capacity')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['building_id', 'kd']);

            $table->foreign('building_id')->references('id')->on('inst_buildings')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('inst_config', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('inst_id');
            $table->string('kd');
            $table->boolean('cached')->default(1);
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('value');

            $table->unique(['inst_id', 'kd']);

            $table->foreign('inst_id')->references('id')->on('insts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('inst_conversions', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('inst_id');
            $table->string('kd');
            $table->string('name');
            $table->year('year')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['inst_id', 'kd']);

            $table->foreign('inst_id')->references('id')->on('insts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('inst_conversion_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('conversion_id');
            $table->float('min');
            $table->float('max');
            $table->string('alpha');
            $table->float('result');
            $table->timestamps();

            $table->foreign('conversion_id')->references('id')->on('inst_conversions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('inst_curriculas', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('inst_id');
            $table->string('kd');
            $table->string('name');
            $table->year('year')->nullable();

            $table->unique(['inst_id', 'kd']);

            $table->foreign('inst_id')->references('id')->on('insts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('inst_holiday_categories', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name');
        });

        Schema::create('inst_holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('inst_id');
            $table->string('name');
            $table->date('date');
            $table->unsignedTinyInteger('category_id');
            $table->timestamps();

            $table->foreign('inst_id')->references('id')->on('insts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('inst_holiday_categories')->onUpdate('cascade')->onDelete('cascade');
        });

         Schema::create('inst_periods', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('inst_id');
            $table->string('name');
            $table->year('year');

            $table->foreign('inst_id')->references('id')->on('insts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('inst_period_semesters', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('period_id');
            $table->boolean('open')->default(0);
            $table->unsignedTinyInteger('conversion_id')->nullable();
            $table->string('name');

            $table->foreign('period_id')->references('id')->on('inst_periods')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('conversion_id')->references('id')->on('inst_conversions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inst_period_semesters');
        Schema::dropIfExists('inst_periods');
        Schema::dropIfExists('inst_holidays');
        Schema::dropIfExists('inst_holiday_categories');
        Schema::dropIfExists('inst_curriculas');
        Schema::dropIfExists('inst_conversion_values');
        Schema::dropIfExists('inst_conversions');
        Schema::dropIfExists('inst_config');
        Schema::dropIfExists('inst_building_rooms');
        Schema::dropIfExists('inst_buildings');
        Schema::dropIfExists('inst_announcements');
        Schema::dropIfExists('insts');
    }
}
