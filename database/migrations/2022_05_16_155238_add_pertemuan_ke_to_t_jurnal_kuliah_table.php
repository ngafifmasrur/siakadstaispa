<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPertemuanKeToTJurnalKuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_jurnal_kuliah', function (Blueprint $table) {
            $table->integer('pertemuan_ke')->nullable()->after('topik');
            $table->enum('status', ['Hadir', 'Sakit', 'Ijin', 'Alpa'])->nullable()->after('topik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_jurnal_kuliah', function (Blueprint $table) {
            $table->dropColumn([
                'pertemuan_ke',
                'status'
            ]);
        });
    }
}
