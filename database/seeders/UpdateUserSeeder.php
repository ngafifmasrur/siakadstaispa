<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UpdateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'name' => 'bendahara',
                'description' => 'Akun Bendahara',
            ],
        ];
        
        \App\Models\Role::insert($role);

        $role_bendahara = Role::where('name', 'bendahara')->first();
        $bendahara = new User();
        $bendahara->name = 'Bendahara';
        $bendahara->email = 'bendahara@staispa.ac.id';
        $bendahara->password = bcrypt('secret');
        $bendahara->role_id =  $role_bendahara->id;
        $bendahara->save();
        $bendahara->roles()->attach($role_bendahara);

    }
}
