<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedTinyInteger('period_id');
            $table->string('name');
            $table->unsignedTinyInteger('generation');
            $table->boolean('open');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('published')->default(1);
            $table->string('brochure')->nullable();
            $table->timestamps();

            $table->foreign('period_id')->references('id')->on('inst_periods')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_reqs_general', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('name');

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_reqs_special', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('name');

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->unsignedInteger('group')->nullable();
            $table->timestamps();
        });

        Schema::create('admission_committees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('name');
            $table->unsignedTinyInteger('az')->nullable();
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_committee_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('committee_id');
            $table->string('job');

            $table->foreign('committee_id')->references('id')->on('admission_committees')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_committee_members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('committee_id');
            $table->string('kd')->unique();
            $table->unsignedInteger('member_id');
            $table->timestamps();

            $table->unique(['committee_id', 'kd']);

            $table->foreign('committee_id')->references('id')->on('admission_committees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_committee_permissions', function (Blueprint $table) {
            $table->unsignedInteger('committee_id');
            $table->unsignedInteger('permission_id');

            $table->primary(['committee_id', 'permission_id'], 'admission_committee_permissions_primary');

            $table->foreign('committee_id', 'admission_committee_permissions_ifbk1')->references('id')->on('admission_committees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('permission_id', 'admission_committee_permissions_fbk2')->references('id')->on('admission_permissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_spendings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item');
            $table->float('amount', 24, 2)->nullable();
            $table->unsignedInteger('qty')->nullable();
            $table->string('unit')->nullable();
            $table->string('shop')->nullable();
            $table->unsignedInteger('committee_id')->nullable();
            $table->string('buyer')->nullable();
            $table->timestamp('payed_at')->nullable();
            $table->timestamps();

            $table->foreign('committee_id')->references('id')->on('admission_committee_members')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('required')->default(1);
            $table->string('required_message')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->unsignedTinyInteger('key');
            $table->string('description')->nullable();
            $table->boolean('required')->default(1);
            $table->string('required_message')->nullable();
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('name');
            $table->time('start_time');
            $table->time('end_time');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('name');
            $table->float('minimal')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_test_dates', function (Blueprint $table) {
            $table->unsignedTinyInteger('admission_id');
            $table->date('date');

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_payment_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('kd');
            $table->string('name')->nullable();

            $table->unique(['admission_id', 'kd']);

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_payment_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_id');
            $table->string('name');
            $table->float('amount', 24, 2);
            $table->unsignedInteger('category_id')->nullable();
            $table->boolean('minimum')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('admission_payments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('admission_payment_categories')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_registrants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('admission_id');
            $table->string('kd');
            $table->unsignedInteger('user_id');
            $table->string('avatar')->nullable();
            $table->unsignedInteger('payment_id')->nullable();
            $table->date('test_at')->nullable();
            $table->unsignedInteger('session_id')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('tested_at')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('paid_off_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['admission_id', 'kd']);

            $table->foreign('admission_id')->references('id')->on('admissions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('admission_payments')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('admission_sessions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_registrant_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('registrant_id');
            $table->unsignedInteger('test_id');
            $table->float('value')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('committee_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['registrant_id', 'test_id']);

            $table->foreign('registrant_id')->references('id')->on('admission_registrants')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('test_id')->references('id')->on('admission_tests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('committee_id')->references('id')->on('admission_committee_members')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_registrant_files', function (Blueprint $table) {
            $table->unsignedInteger('registrant_id');
            $table->unsignedInteger('file_id');
            $table->string('file');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->primary(['registrant_id', 'file_id']);

            $table->foreign('registrant_id')->references('id')->on('admission_registrants')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('admission_files')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('admission_registrant_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd')->unique();
            $table->unsignedInteger('registrant_id');
            $table->string('payer')->nullable();
            $table->boolean('cash')->default(1);
            $table->text('value');
            $table->float('amount', 24, 2);
            $table->string('description')->nullable();
            $table->unsignedInteger('committee_id');
            $table->timestamp('payed_at');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('registrant_id')->references('id')->on('admission_registrants')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('committee_id')->references('id')->on('admission_committee_members')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admission_registrant_transactions');
        Schema::dropIfExists('admission_registrant_files');
        Schema::dropIfExists('admission_registrant_tests');
        Schema::dropIfExists('admission_registrants');
        Schema::dropIfExists('admission_payment_items');
        Schema::dropIfExists('admission_payment_categories');
        Schema::dropIfExists('admission_payments');
        Schema::dropIfExists('admission_test_dates');
        Schema::dropIfExists('admission_tests');
        Schema::dropIfExists('admission_sessions');
        Schema::dropIfExists('admission_files');
        Schema::dropIfExists('admission_spendings');
        Schema::dropIfExists('admission_committee_permissions');
        Schema::dropIfExists('admission_committee_members');
        Schema::dropIfExists('admission_committee_jobs');
        Schema::dropIfExists('admission_committees');
        Schema::dropIfExists('admission_permissions');
        Schema::dropIfExists('admission_reqs_special');
        Schema::dropIfExists('admission_reqs_general');
        Schema::dropIfExists('admissions');
    }
}
