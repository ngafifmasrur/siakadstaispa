<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'description' => 'Admin to manage the site',
            ],
            [
                'name' => 'mahasiswa',
                'description' => 'Akun Mahasiswa',
            ],
            [
                'name' => 'dosen',
                'description' => 'Akun Dosen',
            ],
        ];
        
        \App\Models\Role::insert($data);
    }
}
