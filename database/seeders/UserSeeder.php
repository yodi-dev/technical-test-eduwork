<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'awan',
            'email' => 'awan@mail.com',
            'password' => Hash::make('secret12'),
            'phone_number' => '0812434343434',
            'phone_number' => '0812434343434',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
