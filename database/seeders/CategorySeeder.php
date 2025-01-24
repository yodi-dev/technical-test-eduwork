<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'code' => 'shoe1',
            'name' => 'Sepatu Pria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->insert([
            'code' => 'shoe2',
            'name' => 'Sepatu Wanita',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
