<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $productImages = [
            // iPhone 15 Pro Max (product_id: 1)
            [
                'product_id' => 1,
                'image_path' => 'https://placehold.co/800x800/1e40af/ffffff?text=iPhone+Front',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 1,
                'image_path' => 'https://placehold.co/800x800/1e40af/ffffff?text=iPhone+Back',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 1,
                'image_path' => 'https://placehold.co/800x800/1e40af/ffffff?text=iPhone+Side',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // MacBook Air M3 (product_id: 2)
            [
                'product_id' => 2,
                'image_path' => 'https://placehold.co/800x800/374151/ffffff?text=MacBook+Open',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'image_path' => 'https://placehold.co/800x800/374151/ffffff?text=MacBook+Closed',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Sony Headphones (product_id: 3)
            [
                'product_id' => 3,
                'image_path' => 'https://placehold.co/800x800/000000/ffffff?text=Headphones+Front',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'image_path' => 'https://placehold.co/800x800/000000/ffffff?text=Headphones+Side',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'image_path' => 'https://placehold.co/800x800/000000/ffffff?text=Headphones+Case',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Denim Jacket (product_id: 4)
            [
                'product_id' => 4,
                'image_path' => 'https://placehold.co/800x800/1e3a8a/ffffff?text=Jacket+Front',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 4,
                'image_path' => 'https://placehold.co/800x800/1e3a8a/ffffff?text=Jacket+Back',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // T-Shirt (product_id: 5)
            [
                'product_id' => 5,
                'image_path' => 'https://placehold.co/800x800/ffffff/000000?text=T-Shirt+White',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 5,
                'image_path' => 'https://placehold.co/800x800/000000/ffffff?text=T-Shirt+Black',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 5,
                'image_path' => 'https://placehold.co/800x800/dc2626/ffffff?text=T-Shirt+Red',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Security Camera (product_id: 6)
            [
                'product_id' => 6,
                'image_path' => 'https://placehold.co/800x800/374151/ffffff?text=Camera+Main',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 6,
                'image_path' => 'https://placehold.co/800x800/374151/ffffff?text=Camera+Box',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Plant Pots (product_id: 7)
            [
                'product_id' => 7,
                'image_path' => 'https://placehold.co/800x800/22c55e/ffffff?text=Pots+Set',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 7,
                'image_path' => 'https://placehold.co/800x800/22c55e/ffffff?text=Large+Pot',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Programming Book (product_id: 8)
            [
                'product_id' => 8,
                'image_path' => 'https://placehold.co/800x800/7c3aed/ffffff?text=Book+Cover',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 8,
                'image_path' => 'https://placehold.co/800x800/7c3aed/ffffff?text=Book+Back',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Tennis Racket (product_id: 9)
            [
                'product_id' => 9,
                'image_path' => 'https://placehold.co/800x800/ea580c/ffffff?text=Racket+Full',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 9,
                'image_path' => 'https://placehold.co/800x800/ea580c/ffffff?text=Racket+Case',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Yoga Mat (product_id: 10)
            [
                'product_id' => 10,
                'image_path' => 'https://placehold.co/800x800/06b6d4/ffffff?text=Yoga+Mat',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Face Serum (product_id: 11)
            [
                'product_id' => 11,
                'image_path' => 'https://placehold.co/800x800/ec4899/ffffff?text=Serum+Bottle',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 11,
                'image_path' => 'https://placehold.co/800x800/ec4899/ffffff?text=Serum+Box',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Coffee Beans (product_id: 12)
            [
                'product_id' => 12,
                'image_path' => 'https://placehold.co/800x800/92400e/ffffff?text=Coffee+Bag',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 12,
                'image_path' => 'https://placehold.co/800x800/92400e/ffffff?text=Coffee+Beans',
                'is_primary' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Green Tea (product_id: 13)
            [
                'product_id' => 13,
                'image_path' => 'https://placehold.co/800x800/16a34a/ffffff?text=Tea+Package',
                'is_primary' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('product_images')->insert($productImages);
    }
}