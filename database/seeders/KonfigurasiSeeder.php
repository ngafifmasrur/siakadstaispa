<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KonfigurasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            KonfigurasiGlobalSeeder::class,
            KonfigurasiGlobalProdiSeeder::class,
        ]);
    }
}
