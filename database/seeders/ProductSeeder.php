<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'code' => 'ss01',
            'category_id' => 1,
            'name' => 'Sepatu satoe',
            'price' => 50000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
