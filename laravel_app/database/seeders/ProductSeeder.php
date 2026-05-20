<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if dummy farmer exists, if not create one
        $farmer = User::firstOrCreate(
            ['email' => 'farmer@krishisheba.com'],
            [
                'name' => 'রহিম মিয়া',
                'nid' => '1234567890',
                'role' => 'farmer',
                'password' => Hash::make('password'),
            ]
        );

        $products = [
            [
                'name' => 'দেশী লাল টমেটো',
                'price' => 45.00,
                'image_url' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=500&auto=format&fit=crop&q=60',
                'stock_quantity' => 100,
            ],
            [
                'name' => 'ডায়মন্ড আলু',
                'price' => 30.00,
                'image_url' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=500&auto=format&fit=crop&q=60',
                'stock_quantity' => 200,
            ],
            [
                'name' => 'ক্যাপসিকাম',
                'price' => 550.00,
                'image_url' => 'https://images.unsplash.com/photo-1601648764658-cf37e8c89b70?w=500&auto=format&fit=crop&q=60',
                'stock_quantity' => 50,
            ],
            [
                'name' => 'রাজশাহী ফজলি আম',
                'price' => 120.00,
                'image_url' => 'https://img.magnific.com/premium-photo/ripe-mango-isolated-white-background_38013-3722.jpg?w=2000',
                'stock_quantity' => 150,
            ]
        ];

        foreach ($products as $product) {
            Product::create([
                'farmer_id' => $farmer->id,
                'name' => $product['name'],
                'price' => $product['price'],
                'image_url' => $product['image_url'],
                'stock_quantity' => $product['stock_quantity'],
            ]);
        }
    }
}
