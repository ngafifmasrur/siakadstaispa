<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsSamanToAdmissionRegistrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admission_registrants', function (Blueprint $table) {
            $table->integer('is_saman')->default(0)->after('special'); // 0 bukan sama, 1 saman
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admission_registrants', function (Blueprint $table) {

        });
    }
}
