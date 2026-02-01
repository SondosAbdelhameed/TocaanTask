<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'High-End Laptop', 'price' => 1200.00],
            ['name' => 'Wireless Mouse', 'price' => 25.50],
            ['name' => 'Mechanical Keyboard', 'price' => 85.00],
            ['name' => 'Gaming Monitor 27"', 'price' => 350.00],
            ['name' => 'Noise Cancelling Headphones', 'price' => 199.99],
            ['name' => 'USB-C Hub Adapter', 'price' => 45.00],
            ['name' => 'Webcam HD 1080p', 'price' => 65.00],
            ['name' => 'External Hard Drive 2TB', 'price' => 90.00],
            ['name' => 'Smartphone Pro Max', 'price' => 1099.00],
            ['name' => 'Tablet Air', 'price' => 599.00],
            ['name' => 'Bluetooth Speaker', 'price' => 55.00],
            ['name' => 'Smart Watch Series 9', 'price' => 399.00],
            ['name' => 'Ergonomic Office Chair', 'price' => 250.00],
            ['name' => 'Desk Lamp LED', 'price' => 35.00],
            ['name' => 'Wireless Charger Pad', 'price' => 20.00],
            ['name' => 'Gaming Pad Large', 'price' => 15.00],
            ['name' => 'Microphone Condenser', 'price' => 120.00],
            ['name' => 'Graphics Tablet', 'price' => 150.00],
            ['name' => 'Portable Power Bank', 'price' => 40.00],
            ['name' => 'Router WiFi 6', 'price' => 180.00],
            ['name' => 'E-Book Reader', 'price' => 130.00],
            ['name' => 'Action Camera 4K', 'price' => 299.00],
            ['name' => 'Laptop Stand Aluminum', 'price' => 45.99],
            ['name' => 'Fitness Tracker', 'price' => 49.00],
            ['name' => 'VR Headset', 'price' => 499.00],
        ];

        DB::table('products')->insert($products);
    }
}
