<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                'name' => 'Product 1',
                'price' => 12.4,
                'qty' => 8,
                'image' => 'product1.jpg',
                'image_path' => 'http://127.0.0.1:8000/images/products/product1.jpeg',
            ],
            [
                'name' => 'Product 2',
                'price' => 45.02,
                'qty' => 12,
                'image' => 'product2.jpg',
                'image_path' => 'http://127.0.0.1:8000/images/products/product2.jpeg',
            ],
            [
                'name' => 'Product 3',
                'price' => 25.7,
                'qty' => 10,
                'image' => 'product3.jpg',
                'image_path' => 'http://127.0.0.1:8000/images/products/product3.jpeg',
            ],
        ]);
    }
}
