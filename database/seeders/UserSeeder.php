<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            'name' => 'Rendszergazda',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}