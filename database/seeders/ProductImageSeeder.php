<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $images = [
            ['product_id' => 1, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 1, 'image_path' => '', 'is_primary' => false, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 2, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 3, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 3, 'image_path' => '', 'is_primary' => false, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 4, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 5, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 6, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 7, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 8, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 9, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 10, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 11, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 12, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 13, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 14, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 15, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 16, 'image_path' => '', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('product_images')->insert($images);
    }
}
