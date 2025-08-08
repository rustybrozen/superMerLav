<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $products = [
            ['name' => 'Rau Muống Tươi 500g', 'short_desc' => 'Rau muống xanh giòn mỗi ngày', 'long_desc' => 'Rau muống tươi được thu hoạch trong ngày, phù hợp xào tỏi hoặc luộc chấm mắm.', 'price' => 18000, 'quantity' => 120, 'category_id' => 1, 'image' => 'https://placehold.co/500x500/22c55e/ffffff?text=Rau+Muong', 'in_price' => 12000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cà Chua 500g', 'short_desc' => 'Cà chua đỏ mọng', 'long_desc' => 'Cà chua chín tự nhiên, phù hợp làm salad, sốt hoặc nấu canh.', 'price' => 22000, 'quantity' => 150, 'category_id' => 1, 'image' => 'https://placehold.co/500x500/f97316/ffffff?text=Ca+Chua', 'in_price' => 15000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Phi Lê Cá Hồi 300g', 'short_desc' => 'Cá hồi Na Uy tươi', 'long_desc' => 'Phi lê cá hồi giàu omega-3, thích hợp áp chảo, nướng bơ tỏi.', 'price' => 165000, 'quantity' => 40, 'category_id' => 2, 'image' => 'https://placehold.co/500x500/0ea5e9/ffffff?text=Ca+Hoi', 'in_price' => 135000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Ức Gà 500g', 'short_desc' => 'Thịt ức gà tươi', 'long_desc' => 'Ức gà ít mỡ, giàu đạm, phù hợp eat clean, áp chảo, luộc.', 'price' => 52000, 'quantity' => 80, 'category_id' => 2, 'image' => 'https://placehold.co/500x500/fca5a5/ffffff?text=Uc+Ga', 'in_price' => 39000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Gạo ST25 5kg', 'short_desc' => 'Gạo thơm dẻo', 'long_desc' => 'Gạo ST25 hạt dài, thơm nhẹ, cho cơm dẻo và ngọt.', 'price' => 175000, 'quantity' => 60, 'category_id' => 3, 'image' => 'https://placehold.co/500x500/f59e0b/ffffff?text=Gao+ST25', 'in_price' => 145000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Mì Gói Tôm Chua Cay Thùng 30 gói', 'short_desc' => 'Tiện lợi mỗi ngày', 'long_desc' => 'Thùng mì tôm chua cay 30 gói, phù hợp dự trữ gia đình.', 'price' => 125000, 'quantity' => 70, 'category_id' => 3, 'image' => 'https://placehold.co/500x500/f97316/ffffff?text=Mi+Goi', 'in_price' => 98000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sữa Tươi Tiệt Trùng 1L', 'short_desc' => 'Sữa tươi giàu dinh dưỡng', 'long_desc' => 'Sữa tươi tiệt trùng 1 lít, thích hợp cho bữa sáng và làm bánh.', 'price' => 35000, 'quantity' => 100, 'category_id' => 4, 'image' => 'https://placehold.co/500x500/93c5fd/0f172a?text=Sua+Tuoi', 'in_price' => 27000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Trứng Gà Ta 10 Quả', 'short_desc' => 'Trứng gà ta tươi', 'long_desc' => 'Vỉ 10 trứng gà ta, lòng đỏ sánh, thơm.', 'price' => 42000, 'quantity' => 90, 'category_id' => 4, 'image' => 'https://placehold.co/500x500/fde68a/111827?text=Trung+Ga', 'in_price' => 32000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Nước Suối 500ml Lốc 12 Chai', 'short_desc' => 'Nước uống tinh khiết', 'long_desc' => 'Lốc 12 chai 500ml, tiện lợi du lịch, sinh hoạt.', 'price' => 48000, 'quantity' => 110, 'category_id' => 5, 'image' => 'https://placehold.co/500x500/3b82f6/ffffff?text=Nuoc+Suoi', 'in_price' => 36000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Trà Sữa Đóng Chai 350ml', 'short_desc' => 'Thức uống giải khát', 'long_desc' => 'Trà sữa đóng chai 350ml, vị ngọt dịu, uống lạnh ngon hơn.', 'price' => 19000, 'quantity' => 140, 'category_id' => 5, 'image' => 'https://placehold.co/500x500/c4b5fd/111827?text=Tra+Sua', 'in_price' => 12000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dầu Ăn 1L', 'short_desc' => 'Dầu thực vật tinh luyện', 'long_desc' => 'Dầu ăn 1 lít dùng chiên xào hằng ngày.', 'price' => 52000, 'quantity' => 85, 'category_id' => 6, 'image' => 'https://placehold.co/500x500/facc15/111827?text=Dau+An', 'in_price' => 41000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Nước Mắm 35 Độ Đạm 500ml', 'short_desc' => 'Đậm vị truyền thống', 'long_desc' => 'Nước mắm 35 độ đạm, hương vị đặc trưng, chấm và nấu đều ngon.', 'price' => 58000, 'quantity' => 70, 'category_id' => 6, 'image' => 'https://placehold.co/500x500/16a34a/ffffff?text=Nuoc+Mam', 'in_price' => 43000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bánh Quy Bơ 200g', 'short_desc' => 'Thơm bơ giòn tan', 'long_desc' => 'Bánh quy bơ vị truyền thống, dùng kèm trà rất hợp.', 'price' => 32000, 'quantity' => 150, 'category_id' => 7, 'image' => 'https://placehold.co/500x500/f472b6/111827?text=Banh+Quy+Bo', 'in_price' => 21000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kẹo Socola 100g', 'short_desc' => 'Ngọt ngào dễ chịu', 'long_desc' => 'Kẹo socola vị cacao, gói 100g, thích hợp làm quà.', 'price' => 27000, 'quantity' => 90, 'category_id' => 7, 'image' => 'https://placehold.co/500x500/0f172a/ffffff?text=Keo+Socola', 'in_price' => 18000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Giấy Lau Bếp 3 Cuộn', 'short_desc' => 'Thấm hút tốt', 'long_desc' => 'Giấy lau bếp 3 cuộn, tiện dụng cho nhà bếp.', 'price' => 39000, 'quantity' => 60, 'category_id' => 8, 'image' => 'https://placehold.co/500x500/64748b/ffffff?text=Giay+Lau+Bep', 'in_price' => 29000, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Nước Rửa Chén 750ml', 'short_desc' => 'Sạch nhờn, dịu tay', 'long_desc' => 'Nước rửa chén 750ml hương chanh, dễ tráng.', 'price' => 38000, 'quantity' => 0, 'category_id' => 8, 'image' => 'https://placehold.co/500x500/10b981/ffffff?text=Rua+Chen', 'in_price' => 26000, 'is_active' => false, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('products')->insert($products);
    }
}
