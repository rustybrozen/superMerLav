<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // Electronics (category_id: 1)
            [
                'name' => 'iPhone 15 Pro Max',
                'short_desc' => 'Latest flagship smartphone with titanium design',
                'long_desc' => 'The iPhone 15 Pro Max features a stunning titanium design, A17 Pro chip, advanced camera system with 5x telephoto zoom, and USB-C connectivity. Perfect for professionals and tech enthusiasts.',
                'price' => 1199000, // $1199 in cents
                'quantity' => 25,
                'category_id' => 1,
                'image' => 'https://placehold.co/500x500/1e40af/ffffff?text=iPhone+15+Pro',
                'in_price' => 950000,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'MacBook Air M3',
                'short_desc' => 'Ultra-thin laptop with M3 chip',
                'long_desc' => 'The new MacBook Air with M3 chip delivers incredible performance in an impossibly thin design. Features up to 18 hours of battery life, stunning Liquid Retina display, and silent fanless operation.',
                'price' => 1299000,
                'quantity' => 15,
                'category_id' => 1,
                'image' => 'https://placehold.co/500x500/374151/ffffff?text=MacBook+Air+M3',
                'in_price' => 1050000,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'short_desc' => 'Premium noise-cancelling wireless headphones',
                'long_desc' => 'Industry-leading noise cancellation with two processors controlling 8 microphones. 30-hour battery life, crystal clear hands-free calling, and premium comfort for all-day wear.',
                'price' => 39900,
                'quantity' => 50,
                'category_id' => 1,
                'image' => 'https://placehold.co/500x500/000000/ffffff?text=Sony+WH1000XM5',
                'in_price' => 28000,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Clothing & Fashion (category_id: 2)
            [
                'name' => 'Classic Denim Jacket',
                'short_desc' => 'Vintage-style blue denim jacket',
                'long_desc' => 'Timeless denim jacket crafted from premium cotton denim. Features classic button closure, chest pockets, and a comfortable regular fit. Perfect for layering in any season.',
                'price' => 8900,
                'quantity' => 30,
                'category_id' => 2,
                'image' => 'https://placehold.co/500x500/1e3a8a/ffffff?text=Denim+Jacket',
                'in_price' => 4500,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Organic Cotton T-Shirt',
                'short_desc' => 'Sustainable basic tee in multiple colors',
                'long_desc' => 'Made from 100% organic cotton, this soft and breathable t-shirt is perfect for everyday wear. Available in various colors and sizes. Ethically produced and environmentally friendly.',
                'price' => 2500,
                'quantity' => 100,
                'category_id' => 2,
                'image' => 'https://placehold.co/500x500/ffffff/000000?text=Organic+T-Shirt',
                'in_price' => 1200,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Home & Garden (category_id: 3)
            [
                'name' => 'Smart Home Security Camera',
                'short_desc' => '4K wireless security camera with night vision',
                'long_desc' => 'Advanced 4K security camera with AI-powered motion detection, color night vision, two-way audio, and cloud storage. Easy wireless installation and smartphone app control.',
                'price' => 15900,
                'quantity' => 40,
                'category_id' => 3,
                'image' => 'https://placehold.co/500x500/374151/ffffff?text=Security+Camera',
                'in_price' => 9500,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ceramic Plant Pot Set',
                'short_desc' => 'Set of 3 decorative ceramic planters',
                'long_desc' => 'Beautiful set of three ceramic plant pots in different sizes. Features drainage holes and matching saucers. Perfect for indoor plants and adds a modern touch to any room.',
                'price' => 4500,
                'quantity' => 60,
                'category_id' => 3,
                'image' => 'https://placehold.co/500x500/22c55e/ffffff?text=Plant+Pots',
                'in_price' => 2200,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Books & Media (category_id: 4)
            [
                'name' => 'The Art of Programming',
                'short_desc' => 'Comprehensive guide to software development',
                'long_desc' => 'A complete guide covering fundamental programming concepts, best practices, and modern development methodologies. Suitable for beginners and experienced developers alike.',
                'price' => 5900,
                'quantity' => 75,
                'category_id' => 4,
                'image' => 'https://placehold.co/500x500/7c3aed/ffffff?text=Programming+Book',
                'in_price' => 2800,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Sports & Outdoors (category_id: 5)
            [
                'name' => 'Professional Tennis Racket',
                'short_desc' => 'Carbon fiber tennis racket for advanced players',
                'long_desc' => 'High-performance tennis racket made with premium carbon fiber. Designed for advanced players seeking power and control. Includes protective case and dampener.',
                'price' => 24900,
                'quantity' => 20,
                'category_id' => 5,
                'image' => 'https://placehold.co/500x500/ea580c/ffffff?text=Tennis+Racket',
                'in_price' => 15000,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Yoga Mat Premium',
                'short_desc' => 'Non-slip eco-friendly yoga mat',
                'long_desc' => 'Premium yoga mat made from natural rubber with excellent grip and cushioning. Non-toxic, eco-friendly, and perfect for all types of yoga practice. Includes carrying strap.',
                'price' => 7500,
                'quantity' => 45,
                'category_id' => 5,
                'image' => 'https://placehold.co/500x500/06b6d4/ffffff?text=Yoga+Mat',
                'in_price' => 3500,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Beauty & Personal Care (category_id: 6)
            [
                'name' => 'Organic Face Serum',
                'short_desc' => 'Anti-aging serum with vitamin C',
                'long_desc' => 'Powerful anti-aging serum with 20% vitamin C, hyaluronic acid, and natural botanicals. Reduces fine lines, brightens skin tone, and provides deep hydration.',
                'price' => 6800,
                'quantity' => 80,
                'category_id' => 6,
                'image' => 'https://placehold.co/500x500/ec4899/ffffff?text=Face+Serum',
                'in_price' => 3200,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Food & Beverages (category_id: 8)
            [
                'name' => 'Premium Coffee Beans',
                'short_desc' => 'Single-origin arabica coffee beans',
                'long_desc' => 'Premium single-origin arabica coffee beans from Colombian highlands. Medium roast with notes of chocolate and caramel. Perfect for espresso and drip coffee.',
                'price' => 2800,
                'quantity' => 120,
                'category_id' => 8,
                'image' => 'https://placehold.co/500x500/92400e/ffffff?text=Coffee+Beans',
                'in_price' => 1500,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Organic Green Tea',
                'short_desc' => 'Premium loose leaf green tea',
                'long_desc' => 'High-quality organic green tea leaves sourced from sustainable farms. Rich in antioxidants with a delicate, refreshing flavor. Perfect for daily wellness routine.',
                'price' => 1800,
                'quantity' => 90,
                'category_id' => 8,
                'image' => 'https://placehold.co/500x500/16a34a/ffffff?text=Green+Tea',
                'in_price' => 900,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

             // One inactive product for testing
            [
                'name' => 'Discontinued Gaming Mouse',
                'short_desc' => 'High-precision gaming mouse (discontinued)',
                'long_desc' => 'Professional gaming mouse with customizable RGB lighting and programmable buttons. This model has been discontinued.',
                'price' => 8900,
                'quantity' => 0,
                'category_id' => 1,
                'image' => 'https://placehold.co/500x500/6b7280/ffffff?text=Gaming+Mouse',
                'in_price' => 5000,
                'is_active' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}