<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('name', 'admin')->first();
        $role_dosen  = Role::where('name', 'dosen')->first();


            $admin = new User();
            $admin->name = 'Admin';
            $admin->email = 'admin_siakad@staispa.ac.id';
            $admin->password = bcrypt('secret');
            $admin->role_id =  $role_admin->id;
            $admin->save();
            $admin->roles()->attach($role_admin);
 
    }
}
