<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            'username'   => 'admin',
            'fullname'   => 'Administrator',
            'password'   => Hash::make('admin'), 
            'email'      => 'admin@example.com',
            'address'    => 'Admin',
            'is_admin'   => 1,
            'is_disabled'=> 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);



        
    }
}
