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
            ['product_id' => 1, 'image_path' => 'https://placehold.co/800x800/22c55e/ffffff?text=Rau+Muong+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 1, 'image_path' => 'https://placehold.co/800x800/16a34a/ffffff?text=Rau+Muong+2', 'is_primary' => false, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 2, 'image_path' => 'https://placehold.co/800x800/f97316/ffffff?text=Ca+Chua+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 3, 'image_path' => 'https://placehold.co/800x800/0ea5e9/ffffff?text=Ca+Hoi+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 3, 'image_path' => 'https://placehold.co/800x800/0284c7/ffffff?text=Ca+Hoi+2', 'is_primary' => false, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 4, 'image_path' => 'https://placehold.co/800x800/fca5a5/111827?text=Uc+Ga+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 5, 'image_path' => 'https://placehold.co/800x800/f59e0b/ffffff?text=Gao+ST25+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 6, 'image_path' => 'https://placehold.co/800x800/f97316/ffffff?text=Mi+Goi+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 7, 'image_path' => 'https://placehold.co/800x800/93c5fd/111827?text=Sua+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 8, 'image_path' => 'https://placehold.co/800x800/fde68a/111827?text=Trung+Ga+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 9, 'image_path' => 'https://placehold.co/800x800/3b82f6/ffffff?text=Nuoc+Suoi+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 10, 'image_path' => 'https://placehold.co/800x800/c4b5fd/111827?text=Tra+Sua+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 11, 'image_path' => 'https://placehold.co/800x800/facc15/111827?text=Dau+An+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 12, 'image_path' => 'https://placehold.co/800x800/16a34a/ffffff?text=Nuoc+Mam+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 13, 'image_path' => 'https://placehold.co/800x800/f472b6/111827?text=Banh+Quy+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 14, 'image_path' => 'https://placehold.co/800x800/0f172a/ffffff?text=Keo+Socola+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 15, 'image_path' => 'https://placehold.co/800x800/64748b/ffffff?text=Giay+Lau+Bep+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],

            ['product_id' => 16, 'image_path' => 'https://placehold.co/800x800/10b981/ffffff?text=Rua+Chen+1', 'is_primary' => true, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('product_images')->insert($images);
    }
}
