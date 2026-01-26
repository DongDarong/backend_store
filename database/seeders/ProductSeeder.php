<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
    [
        'name' => 'T-Shirt',
        'description' => 'Cotton T-shirt',
        'price' => 15.00,
        'category_id' => 1
    ]
]);

    }
}
