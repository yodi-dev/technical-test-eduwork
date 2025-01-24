<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'product_id' => 1,
            'amount' => 50000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
