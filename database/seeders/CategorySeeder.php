<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $categories = [
            ['name' => 'Rau Củ Quả', 'is_active' => true, 'image' => 'https://placehold.co/400x300/22c55e/ffffff?text=Rau+C%E1%BB%A7+Qu%E1%BA%A3', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Thịt Cá Hải Sản', 'is_active' => true, 'image' => 'https://placehold.co/400x300/0ea5e9/ffffff?text=Th%E1%BB%8Bt+C%C3%A1+H%E1%BA%A3i+S%E1%BA%A3n', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Đồ Khô - Gạo Mì', 'is_active' => true, 'image' => 'https://placehold.co/400x300/f59e0b/ffffff?text=%C4%90%E1%BB%93+Kh%C3%B4', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sữa - Trứng', 'is_active' => true, 'image' => 'https://placehold.co/400x300/f43f5e/ffffff?text=S%E1%BB%AFa+Tr%E1%BB%A9ng', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Đồ Uống', 'is_active' => true, 'image' => 'https://placehold.co/400x300/3b82f6/ffffff?text=%C4%90%E1%BB%93+U%E1%BB%91ng', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gia Vị - Dầu Ăn', 'is_active' => true, 'image' => 'https://placehold.co/400x300/16a34a/ffffff?text=Gia+V%E1%BB%8B', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bánh Kẹo', 'is_active' => true, 'image' => 'https://placehold.co/400x300/ec4899/ffffff?text=B%C3%A1nh+K%E1%BA%B9o', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Đồ Gia Dụng', 'is_active' => true, 'image' => 'https://placehold.co/400x300/64748b/ffffff?text=%C4%90%E1%BB%93+Gia+D%E1%BB%A5ng', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('categories')->insert($categories);
    }
}
