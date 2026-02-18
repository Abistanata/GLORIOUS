<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get products and customers
        $products = Product::take(5)->get();
        $customers = User::where('role', 'Customer')->take(5)->get();

        // If no customers exist, create some
        if ($customers->isEmpty()) {
            $customers = collect();
            for ($i = 1; $i <= 5; $i++) {
                $customers->push(User::create([
                    'name' => 'Customer ' . $i,
                    'username' => 'customer' . $i,
                    'email' => 'customer' . $i . '@example.com',
                    'phone' => '628123456789' . $i,
                    'password' => bcrypt('password123'),
                    'role' => 'Customer',
                ]));
            }
        }

        // If no products exist, skip
        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductSeeder first.');
            return;
        }

        // Create 5 positive reviews
        $positiveReviews = [
            [
                'rating' => 5,
                'comment' => 'Produk sangat bagus! Kualitas sesuai dengan harga. Pengiriman cepat dan packing rapi. Sangat puas dengan pelayanan Glorious Computer.',
            ],
            [
                'rating' => 5,
                'comment' => 'Laptop yang saya beli dalam kondisi sangat baik. Performa sesuai ekspektasi dan harga sangat terjangkau. Recommended!',
            ],
            [
                'rating' => 4,
                'comment' => 'Produk berkualitas tinggi dengan harga yang kompetitif. Pelayanan customer service sangat responsif dan membantu.',
            ],
            [
                'rating' => 5,
                'comment' => 'Sangat puas dengan pembelian di sini. Produk original dan bergaransi. Akan belanja lagi di sini!',
            ],
            [
                'rating' => 4,
                'comment' => 'Barang sesuai deskripsi, kondisi sangat baik. Proses transaksi mudah dan cepat. Terima kasih Glorious Computer!',
            ],
        ];

        // Create reviews for products
        foreach ($products as $index => $product) {
            if ($index >= count($positiveReviews)) {
                break;
            }

            $customer = $customers[$index % $customers->count()];
            $reviewData = $positiveReviews[$index];

            Review::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'user_id' => $customer->id,
                ],
                [
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'],
                ]
            );
        }

        $this->command->info('Created ' . count($positiveReviews) . ' positive reviews.');
    }
}
