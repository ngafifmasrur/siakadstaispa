<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTanggalKedatanganToAdmissionRegistrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admission_registrants', function (Blueprint $table) {
            $table->date('tanggal_kedatangan')->nullable(true)->after('status_wawancara'); 
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
