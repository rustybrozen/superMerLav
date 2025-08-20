<x-layout :title="'Trang Chủ'">



    <!-- Main Banner Carousel -->
    <div id="mainBanner" class="relative w-full h-96 overflow-hidden">
        <div class="carousel-item active relative w-full h-full">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30">
                <img src="https://theacsi.org/wp-content/uploads/2022/01/acsi-supermarket-industry-scaled.jpg"
                    class="w-full h-full object-cover" alt="Fresh Vegetables">
            </div>
            <div class="absolute inset-0 flex items-center justify-center text-center text-white">
                <div class="space-y-4 drop-shadow-[0_4px_6px_rgba(0,0,0,1)]">
                    <h1 class="text-5xl font-bold mb-4">Rau Củ Tươi Ngon</h1>
                    <p class="text-xl mb-6">Nhập khẩu trực tiếp từ các trang trại hữu cơ</p>
                    <button
                        class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg text-lg font-semibold transition duration-300 drop-shadow-md">
                        Mua Ngay
                    </button>
                </div>
            </div>
        </div>








    </div>

    <!-- Benefits Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="benefit-item text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-green-600 text-2xl"></i>
                    </div>
                    <h5 class="text-xl font-semibold mb-2">Giao Hàng Miễn Phí</h5>
                    <p class="text-gray-600">Cho đơn hàng từ 500.000đ</p>
                </div>
                <div class="benefit-item text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-medal text-green-600 text-2xl"></i>
                    </div>
                    <h5 class="text-xl font-semibold mb-2">Cam Kết Chất Lượng</h5>
                    <p class="text-gray-600">Hoàn tiền nếu không hài lòng</p>
                </div>
                <div class="benefit-item text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone-alt text-green-600 text-2xl"></i>
                    </div>
                    <h5 class="text-xl font-semibold mb-2">Hỗ Trợ 24/7</h5>
                    <p class="text-gray-600">Tư vấn miễn phí</p>
                </div>
                <div class="benefit-item text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sync text-green-600 text-2xl"></i>
                    </div>
                    <h5 class="text-xl font-semibold mb-2">Đổi Trả Dễ Dàng</h5>
                    <p class="text-gray-600">Trong vòng 24h</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vouchers Section -->
    {{-- <section class="py-16 bg-red-500">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-white mb-12">Mã Giảm Giá</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Voucher 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="flex">
                        <div class="w-1/3">
                            <img src="https://placehold.co/120x120/f59e0b/ffffff?text=30%"
                                class="w-full h-full object-cover" alt="Discount">
                        </div>
                        <div class="w-2/3 p-4">
                            <h5 class="font-bold text-lg mb-2">Mã: FRESH30</h5>
                            <p class="text-gray-700 mb-1">Giảm tới 30%</p>
                            <p class="text-gray-700 mb-2">Đơn tối thiểu 300.000 đ</p>
                            <p class="text-gray-500 text-sm mb-3">Hiệu lực từ 01-06-2025 tới 30-06-2025</p>
                            <button
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm font-semibold transition duration-300">
                                Áp dụng ngay
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Voucher 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="flex">
                        <div class="w-1/3">
                            <img src="https://placehold.co/120x120/ef4444/ffffff?text=50K"
                                class="w-full h-full object-cover" alt="Discount">
                        </div>
                        <div class="w-2/3 p-4">
                            <h5 class="font-bold text-lg mb-2">Mã: SAVE50K</h5>
                            <p class="text-gray-700 mb-1">Giảm 50.000 đ</p>
                            <p class="text-gray-700 mb-2">Đơn tối thiểu 500.000 đ</p>
                            <p class="text-gray-500 text-sm mb-3">Hiệu lực từ 01-06-2025 tới 15-06-2025</p>
                            <button
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm font-semibold transition duration-300">
                                Áp dụng ngay
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Voucher 3 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="flex">
                        <div class="w-1/3">
                            <img src="https://placehold.co/120x120/8b5cf6/ffffff?text=FREE"
                                class="w-full h-full object-cover" alt="Free Shipping">
                        </div>
                        <div class="w-2/3 p-4">
                            <h5 class="font-bold text-lg mb-2">Mã: FREESHIP</h5>
                            <p class="text-gray-700 mb-1">Miễn phí giao hàng</p>
                            <p class="text-gray-700 mb-2">Đơn tối thiểu 200.000 đ</p>
                            <p class="text-gray-500 text-sm mb-3">Luôn khả dụng</p>
                            <button
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm font-semibold transition duration-300">
                                Áp dụng ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Categories Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Danh Mục Sản Phẩm</h2>
            <div class="grid md:grid-cols-4 gap-6">
                <!-- Category 1 -->

                @if (count($categories) > 7)
                    @for ($i = 0; $i < 7; $i++)
                        <a href="{{ route(
                            'shop',
                            array_filter([
                                'category' => $categories[$i]->id,
                            ]),
                        ) }}"
                            class="block group cursor-pointer">
                            <div
                                class="relative bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden h-48 transition duration-300 group-hover:shadow-md">
                                <img src="{{ asset($categories[$i]->image) }}" alt="{{ $categories[$i]->name }}"
                                onerror="this.onerror=null;this.src='{{ asset('storage/' . 'default.jpg') }}';">
                                    class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-transparent group-hover:bg-black/20 transition"></div>
                                <div class="absolute inset-x-0 bottom-0 z-10 p-3">
                                    <h3
                                        class="bg-white/80 text-gray-900 text-base font-semibold px-3 py-1 rounded-lg shadow-sm truncate text-center">
                                        {{ $categories[$i]->name }}
                                    </h3>
                                </div>
                            </div>
                        </a>
                    @endfor
                    <div class="group cursor-pointer">
                        <a href="{{ route('shop') }}" class="block group cursor-pointer">
                            <div
                                class="bg-white rounded-lg shadow-md overflow-hidden h-48 relative transition duration-300 group-hover:shadow-lg">
                                <img src="https://placehold.co/300x200/22c55e/ffffff?text=Xem+them"
                                    class="w-full h-full object-cover" alt="Xem thêm">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                    <h3 class="text-white text-xl font-bold">Xem thêm danh mục khác</h3>
                                </div>
                            </div>
                        </a>

                    </div>
                @else
                    @forelse ($categories as $category)
                        <div class="group cursor-pointer">
                            <div
                                class="bg-white rounded-lg shadow-md overflow-hidden h-48 relative transition duration-300 group-hover:shadow-lg">
                                <img src="{{ $category->image }}" class="w-full h-full object-cover"
                                    alt="{{ $category->name }}">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                    <h3 class="text-white text-xl font-bold">{{ $category->name }}</h3>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                @endif



            </div>


        </div>
    </section>



    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex items-center  h-[300px] mx-auto">

                <div class="w-2/3 h-full">
                    <img src="https://png.pngtree.com/png-clipart/20210815/original/pngtree-farm-organic-food-supermarket-promotion-banner-png-image_6639477.jpg"
                        class="w-full h-full object-cover" alt="Advertisement">
                </div>

                <div class="p-6 w-1/3">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Khuyến Mãi Đặc Biệt</h3>
                    <p class="text-gray-600 text-sm mb-3">Tận dụng ngay cơ hội để nhận ưu đãi cực lớn từ chúng tôi. Đừng
                        bỏ lỡ!</p>
                    <a href="{{ route('shop') }}"
                        class="inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-300 text-sm">
                        Tìm Hiểu Ngay
                    </a>

                </div>
            </div>
        </div>
    </section>




    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Sản Phẩm Nổi Bật</h2>
            <div class="grid md:grid-cols-4 gap-6">


                @forelse ($products as $product)
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover"
                            alt="{{ $product->name }}"
                            onerror="this.onerror=null;this.src='{{ asset('storage/' . 'default.jpg') }}';">
                        <div class="p-4">
                            <h5 class="text-lg font-semibold mb-2">{{ $product->name }}</h5>
                            <p class="text-green-600 font-bold text-md mb-3">
                                {{ number_format($product->price, 0, ',', '.') }} ₫</p>
                            <a href="{{ route('detail', ['product' => $product->id]) }}" class="w-full">
                                <button
                                    class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold transition duration-300">
                                    Chi Tiết
                                </button>
                            </a>

                        </div>
                    </div>
                @empty
                @endforelse



            </div>

            <div class="text-center mt-8">
                <a href="{{ route('shop') }}"
                    class="bg-green-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-300">
                    Xem Thêm
                </a>
            </div>
        </div>
    </section>


</x-layout>
