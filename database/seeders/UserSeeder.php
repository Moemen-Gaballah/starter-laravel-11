<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        DB::table('users')->truncate();
        DB::table('users')->insert([[
            'name' => 'Moemen Gaballa',
            'email' => 'moemengaballa@gmail.com',
            'password' => '12345678',
            'email_verified_at' => Carbon::now()
        ],[
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'email_verified_at' => Carbon::now()
        ]]);
    }
}
