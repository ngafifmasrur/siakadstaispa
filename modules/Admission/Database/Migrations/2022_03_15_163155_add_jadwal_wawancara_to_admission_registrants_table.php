<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJadwalWawancaraToAdmissionRegistrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admission_registrants', function (Blueprint $table) {
            $table->datetime('jadwal_wawancara')->nullable(true)->after('is_saman'); // 0 bukan sama, 1 saman
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
