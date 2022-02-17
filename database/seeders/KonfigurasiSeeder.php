<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\m_konfigurasi;

class KonfigurasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $konfigFeeder = [
            [
                'variable' => 'url_feeder_pd_dikti',
                'value' => 'http://108.136.218.38:8082/ws/sandbox2.php'
            ],
            [
                'variable' => 'username_feeder_pd_dikti',
                'value' => '213191'
            ],
            [
                'variable' => 'password_feeder_pd_dikti',
                'value' => '59652749'
            ]
        ];

        m_konfigurasi::insert($konfigFeeder);

        $this->call([
            KonfigurasiGlobalSeeder::class,
            KonfigurasiGlobalProdiSeeder::class,
        ]);
    }
}
