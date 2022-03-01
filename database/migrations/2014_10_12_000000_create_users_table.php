<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared(file_get_contents( "database/migrations/references.sql" ));

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedTinyInteger('level')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('user_password_resets', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('token');
            $table->unsignedInteger('expired_in')->nullable();

            $table->primary('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('address')->unique();
            $table->timestamp('verified_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('number')->unique();
            $table->boolean('whatsapp')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_profile', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();
            $table->unsignedTinyInteger('sex')->nullable();
            $table->unsignedTinyInteger('blood')->nullable();
            $table->unsignedInteger('country_id')->nullable()->default(102);
            $table->string('avatar')->nullable();
            $table->string('nik')->nullable();
            $table->string('nokk')->nullable();
            $table->unsignedTinyInteger('child_order')->nullable();
            $table->unsignedTinyInteger('siblings')->nullable();
            $table->boolean('biological')->default(0);
            $table->string('illness')->nullable();
            $table->timestamps();

            $table->primary('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_address', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('address')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('village')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('postal')->nullable();
            $table->timestamps();

            $table->primary('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('ref_province_regency_districts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_father', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable();
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('biological')->default(0);
            $table->string('nik')->nullable();
            $table->string('ktp')->nullable();
            $table->boolean('is_dead')->default(0);
            $table->unsignedTinyInteger('employment_id')->nullable();
            $table->unsignedTinyInteger('grade_id')->nullable();
            $table->unsignedTinyInteger('salary_id')->nullable();
            $table->string('address')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('village')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('postal')->nullable();
            $table->timestamps();

            $table->primary('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('employment_id')->references('id')->on('ref_employments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('ref_grades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('salary_id')->references('id')->on('ref_salaries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('ref_province_regency_districts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_mother', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable();
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('biological')->default(0);
            $table->string('nik')->nullable();
            $table->string('ktp')->nullable();
            $table->boolean('is_dead')->default(0);
            $table->unsignedTinyInteger('employment_id')->nullable();
            $table->unsignedTinyInteger('grade_id')->nullable();
            $table->unsignedTinyInteger('salary_id')->nullable();
            $table->string('address')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('village')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('postal')->nullable();
            $table->timestamps();

            $table->primary('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('employment_id')->references('id')->on('ref_employments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('ref_grades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('salary_id')->references('id')->on('ref_salaries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('ref_province_regency_districts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_foster', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable();
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('biological')->default(0);
            $table->string('nik')->nullable();
            $table->string('ktp')->nullable();
            $table->boolean('is_dead')->default(0);
            $table->unsignedTinyInteger('employment_id')->nullable();
            $table->unsignedTinyInteger('grade_id')->nullable();
            $table->unsignedTinyInteger('salary_id')->nullable();
            $table->string('address')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('village')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('postal')->nullable();
            $table->timestamps();

            $table->primary('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('employment_id')->references('id')->on('ref_employments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('ref_grades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('salary_id')->references('id')->on('ref_salaries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('ref_province_regency_districts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_disabilities', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('disability_id');

            $table->primary(['user_id', 'disability_id']);

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('disability_id')->references('id')->on('ref_disabilities')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->unsignedTinyInteger('territory_id');
            $table->unsignedTinyInteger('type_id');
            $table->unsignedTinyInteger('num_id');
            $table->year('year')->nullable();
            $table->string('file')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('territory_id')->references('id')->on('ref_territories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('ref_achievement_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('num_id')->references('id')->on('ref_achievement_nums')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_appreciations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->unsignedTinyInteger('territory_id');
            $table->year('year')->nullable();
            $table->string('file')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('territory_id')->references('id')->on('ref_territories')->onUpdate('cascade')->onDelete('cascade');
        });
        
        Schema::create('user_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->unsignedTinyInteger('type_id');
            $table->year('year')->nullable();
            $table->float('duration');
            $table->unsignedTinyInteger('position_id');
            $table->string('file')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('ref_organization_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('ref_organization_positions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_studies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('grade_id')->nullable();
            $table->string('name');
            $table->string('npsn')->nullable();
            $table->string('nss')->nullable();
            $table->year('from')->nullable();
            $table->year('to')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('ref_grades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('ref_province_regency_districts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_sessions', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->unsignedInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity');

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sessions');
        Schema::dropIfExists('user_studies');
        Schema::dropIfExists('user_organizations');
        Schema::dropIfExists('user_appreciations');
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('user_disabilities');
        Schema::dropIfExists('user_foster');
        Schema::dropIfExists('user_mother');
        Schema::dropIfExists('user_father');
        Schema::dropIfExists('user_address');
        Schema::dropIfExists('user_profile');
        Schema::dropIfExists('user_phones');
        Schema::dropIfExists('user_emails');
        Schema::dropIfExists('user_password_resets');
        Schema::dropIfExists('users');

        Schema::dropIfExists('ref_transportations');
        Schema::dropIfExists('ref_territories');
        Schema::dropIfExists('ref_salaries');
        Schema::dropIfExists('ref_religions');
        Schema::dropIfExists('ref_province_regency_districts');
        Schema::dropIfExists('ref_province_regencies');
        Schema::dropIfExists('ref_provinces');
        Schema::dropIfExists('ref_periods');
        Schema::dropIfExists('ref_organization_types');
        Schema::dropIfExists('ref_organization_positions');
        Schema::dropIfExists('ref_hobbies');
        Schema::dropIfExists('ref_habitations');
        Schema::dropIfExists('ref_grade_levels');
        Schema::dropIfExists('ref_grades');
        Schema::dropIfExists('ref_employments');
        Schema::dropIfExists('ref_disabilities');
        Schema::dropIfExists('ref_desires');
        Schema::dropIfExists('ref_countries');
        Schema::dropIfExists('ref_achievement_types');
        Schema::dropIfExists('ref_achievement_nums');
    }
}
