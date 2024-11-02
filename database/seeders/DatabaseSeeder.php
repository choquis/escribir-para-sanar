<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'mayte.herrera@hotmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Abcd1234;'),
            'remember_token' => Str::random(10)
        ]);
    }
}
