<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$inst_id = 1;
    	$now = now();
        $year = 1986;
        $looper = date('Y') + 1 - $year;

        DB::table('insts')->insert([
        	'short_name'	=> 'MASPA',
        	'name'	=> 'MA Sunan Pandanaran',
        	'long_name'	=> 'Madrasah Aliyah Sunan Pandanaran',
        	'created_at' => $now,
        	'updated_at' => $now,
        ]);

        $periods = [];
        for ($i=0; $i <= $looper ; $i++) { 
            $periods[] = [
                'id' => $i+1,
                'inst_id' => $inst_id,
                'name' => ($i+$year).'-'.($i+1+$year),
                'year' => ($i+$year)
            ];
        }
        DB::table('inst_periods')->insert($periods);

        $period_semeters = [];
        foreach ($periods as $period) { 
            if ($period['id'] <= $looper) {
                $period_semeters[] = [
                    'period_id' => $period['id'],
                    'open' => 0,
                    'name' => 'GASAL'
                ];
                $period_semeters[] = [
                    'period_id' => $period['id'],
                    'open' => 0,
                    'name' => 'GENAP'
                ];
            } else {
                $period_semeters[] = [
                    'period_id' => $period['id'],
                    'open'  => 1,
                    'name' => 'GASAL'
                ];
            }
        }
        DB::table('inst_period_semesters')->insert($period_semeters);
    }
}
