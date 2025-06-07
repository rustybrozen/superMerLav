<?php

// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Electronics',
                'is_active' => true,
                'image' => 'https://placehold.co/400x300/2563eb/ffffff?text=Electronics',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Clothing & Fashion',
                'is_active' => true,
                'image' => 'https://placehold.co/400x300/dc2626/ffffff?text=Fashion',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Home & Garden',
                'is_active' => true,
                'image' => 'https://placehold.co/400x300/16a34a/ffffff?text=Home+Garden',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Books & Media',
                'is_active' => true,
                'image' => 'https://placehold.co/400x300/7c3aed/ffffff?text=Books+Media',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sports & Outdoors',
                'is_active' => true,
                'image' => 'https://placehold.co/400x300/ea580c/ffffff?text=Sports',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Beauty & Personal Care',
                'is_active' => true,
                'image' => 'https://placehold.co/400x300/ec4899/ffffff?text=Beauty',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Toys & Games',
                'is_active' => false, // One inactive category for testing
                'image' => 'https://placehold.co/400x300/f59e0b/ffffff?text=Toys+Games',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Food & Beverages',
                'is_active' => true,
                'image' => 'https://placehold.co/400x300/84cc16/ffffff?text=Food+Drinks',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}