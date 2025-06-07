<x-layout :title="'Cửa Hàng'">

    <div
        class="bg-gradient-to-r from-green-600 to-green-700 text-white text-center py-16 px-4 mx-4 mt-8 rounded-3xl shadow-lg">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 text-green-100">Chào Mừng Bạn Tới Fresh Mart</h1>
        <p class="text-lg text-green-50">Hãy lựa chọn những thứ bạn cần trong đây.</p>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar - Categories -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 sticky top-4">

                    <!-- Clear All Filters Button -->
                    @if (request()->has('category') || request()->has('min_price') || request()->has('max_price') || request()->has('q'))
                        <div class="mb-6 pb-4 border-b border-gray-200">
                            <a href="{{ route('shop', ['sort' => request('sort')]) }}"
                                class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Xóa tất cả bộ lọc
                            </a>
                        </div>
                    @endif

                    <!-- Price Range Filter -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                            Khoảng giá
                        </h4>

                        <form method="GET" action="{{ route('shop') }}" id="priceFilterForm">
                            <!-- Preserve ALL existing filters -->
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if (request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            @if (request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            <div class="space-y-3">
                                <div class="flex space-x-2">
                                    <div class="flex-1">
                                        <label class="block text-sm text-gray-600 mb-1">Từ</label>
                                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                                            placeholder="0"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                            min="0">
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm text-gray-600 mb-1">Đến</label>
                                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                                            placeholder="1000000"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                            min="0">
                                    </div>
                                </div>

                                <!-- Quick Price Range Buttons -->
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <button type="button" onclick="setPriceRange(0, 100000)"
                                        class="px-3 py-2 bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors">
                                        < 100k </button>
                                            <button type="button" onclick="setPriceRange(100000, 500000)"
                                                class="px-3 py-2 bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors">
                                                100k - 500k
                                            </button>
                                            <button type="button" onclick="setPriceRange(500000, 1000000)"
                                                class="px-3 py-2 bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors">
                                                500k - 1M
                                            </button>
                                            <button type="button" onclick="setPriceRange(1000000, null)"
                                                class="px-3 py-2 bg-gray-100 hover:bg-green-100 text-gray-700 hover:text-green-700 rounded-lg transition-colors">
                                                > 1M
                                            </button>
                                </div>

                                <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors font-medium text-sm">
                                    Áp dụng
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Filter -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            Danh mục
                            <button onclick="toggleCategories()"
                                class="ml-auto text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="categoryToggleIcon" class="w-4 h-4 transform transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </h4>

                        <!-- Search Categories -->
                        <div class="mb-3">
                            <div class="relative">
                                <input type="text" id="categorySearch" placeholder="Tìm danh mục..."
                                    class="w-full px-3 py-2 pl-9 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                    onkeyup="filterCategories()">
                                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div id="categoryList" class="space-y-2 max-h-64 overflow-y-auto">
                            <!-- All Categories -->
                            <div class="category-item">
                                <div
                                    class="{{ request()->has('category') ? 'hover:bg-green-50 text-green-700' : 'bg-green-600 text-white' }} rounded-lg cursor-pointer transition-colors">
                                    <a href="{{ route(
                                        'shop',
                                        array_filter([
                                            'sort' => request('sort'),
                                            'min_price' => request('min_price'),
                                            'max_price' => request('max_price'),
                                            'q' => request('q'),
                                        ]),
                                    ) }}"
                                        class="flex items-center p-3 {{ request()->has('category') ? 'text-green-700 hover:text-green-800' : 'text-white' }}">
                                        <div
                                            class="w-8 h-8 bg-green-500 rounded mr-3 flex items-center justify-center text-white text-sm font-bold">
                                            ALL
                                        </div>
                                        <span class="font-medium">Tất cả</span>
                                        <span
                                            class="ml-auto text-xs opacity-75">({{ $products->total() ?? 0 }})</span>
                                    </a>
                                </div>
                            </div>

                            @forelse ($categories as $category)
                                @php
                                    $isActive = request('category') == $category->id;
                                    $productCount = $category->products_count;
                                @endphp
                                <div class="category-item" data-category-name="{{ strtolower($category->name) }}">
                                    <div
                                        class="{{ $isActive ? 'bg-green-600 text-white' : 'hover:bg-green-50 text-green-700' }} rounded-lg cursor-pointer transition-colors group">
                                        <a href="{{ route(
                                            'shop',
                                            array_filter([
                                                'category' => $category->id,
                                                'sort' => request('sort'),
                                                'min_price' => request('min_price'),
                                                'max_price' => request('max_price'),
                                                'q' => request('q'),
                                            ]),
                                        ) }}"
                                            class="flex items-center p-3 {{ $isActive ? 'text-white' : 'text-green-700 group-hover:text-green-800' }}">
                                            <img src="https://placehold.co/30x30/4ade80/ffffff?text={{ urlencode(mb_substr($category->name, 0, 2)) }}"
                                                alt="{{ $category->name }}" class="w-8 h-8 rounded mr-3">
                                            <span class="font-medium flex-1">{{ $category->name }}</span>
                                            <span class="text-xs opacity-75">({{ $productCount }})</span>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-gray-500 text-center py-4">Không tìm thấy danh mục.</div>
                            @endforelse
                        </div>

                        <div id="noCategories" class="hidden text-gray-500 text-center py-4">
                            Không tìm thấy danh mục phù hợp.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Search and Filter Bar -->
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 mb-8">
                    <form method="GET" action="{{ route('shop') }}" class="flex flex-col md:flex-row gap-4">
                        <!-- Preserve existing filters in search form -->
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if (request('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if (request('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        @endif
                        @if (request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <div class="flex-1">
                            <input type="text" name="q"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition-all"
                                placeholder="Tìm kiếm sản phẩm hoặc danh mục..." value="{{ request('q') }}">
                        </div>

                        <div class="md:w-48">
                            <select name="sort" onchange="this.form.submit()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition-all">
                                <option value="">Sắp xếp theo</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá:
                                    Thấp đến Cao</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                    Giá: Cao đến Thấp</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên: A
                                    đến Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên:
                                    Z đến A</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors font-medium flex items-center gap-2">
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>
                    </form>

                    <!-- Show active filters -->
                    @if (request()->hasAny(['category', 'min_price', 'max_price', 'q']))
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex flex-wrap gap-2 items-center">
                                <span class="text-sm text-gray-600 font-medium">Bộ lọc đang áp dụng:</span>

                                @if (request('q'))
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Tìm kiếm: "{{ request('q') }}"
                                        <a href="{{ route(
                                            'shop',
                                            array_filter([
                                                'category' => request('category'),
                                                'min_price' => request('min_price'),
                                                'max_price' => request('max_price'),
                                                'sort' => request('sort'),
                                            ]),
                                        ) }}"
                                            class="ml-2 text-blue-600 hover:text-blue-800">×</a>
                                    </span>
                                @endif

                                @if (request('category'))
                                    @php
                                        $selectedCategory = $categories->find(request('category'));
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $selectedCategory->name ?? 'Danh mục' }}
                                        <a href="{{ route(
                                            'shop',
                                            array_filter([
                                                'q' => request('q'),
                                                'min_price' => request('min_price'),
                                                'max_price' => request('max_price'),
                                                'sort' => request('sort'),
                                            ]),
                                        ) }}"
                                            class="ml-2 text-green-600 hover:text-green-800">×</a>
                                    </span>
                                @endif

                                @if (request('min_price') || request('max_price'))
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Giá: {{ number_format(request('min_price', 0)) }}₫ -
                                        {{ number_format(request('max_price', 9999999)) }}₫
                                        <a href="{{ route(
                                            'shop',
                                            array_filter([
                                                'q' => request('q'),
                                                'category' => request('category'),
                                                'sort' => request('sort'),
                                            ]),
                                        ) }}"
                                            class="ml-2 text-purple-600 hover:text-purple-800">×</a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                    @forelse ($products as $product)
                        <div
                            class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 {{ $product->quantity <= 0 ? 'opacity-75' : '' }}">
                            <div class="relative">
                                <img src="{{ $product->quantity > 0
                                    ? 'https://placehold.co/300x280/4ade80/ffffff?text=' . urlencode($product->name)
                                    : 'https://placehold.co/300x280/6b7280/ffffff?text=Hết+Hàng' }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-72 object-cover {{ $product->quantity <= 0 ? 'grayscale' : '' }}">

                                @if ($product->quantity <= 0)
                                    <div
                                        class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        Hết hàng
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 flex flex-col">
                                <p
                                    class="{{ $product->quantity > 0 ? 'text-green-600' : 'text-gray-500' }} text-sm font-medium mb-2">
                                    {{ $product->category->name }}
                                </p>
                                <h5
                                    class="text-lg font-bold {{ $product->quantity > 0 ? 'text-gray-800' : 'text-gray-600' }} mb-3">
                                    {{ $product->name }}
                                </h5>
                                <p
                                    class="text-xl font-bold {{ $product->quantity > 0 ? 'text-green-600' : 'text-gray-500' }} mb-4">
                                    {{ number_format($product->price, 0, ',', '.') }}₫
                                </p>

                                @if ($product->quantity > 0)
                                    <a href="{{ route('detail', ['product' => $product->id]) }}"
                                        class="w-full bg-green-600 hover:bg-green-700 text-center text-white py-3 px-4 rounded-lg font-medium transition-colors">
                                        Xem ngay
                                    </a>
                                @else
                                    <button
                                        class="w-full bg-gray-400 text-white py-3 px-4 rounded-lg font-medium cursor-not-allowed"
                                        disabled>
                                        Hết hàng
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-500 py-12">
                            <div class="text-6xl mb-4">🔍</div>
                            <h3 class="text-xl font-semibold mb-2">Không tìm thấy sản phẩm nào</h3>
                            <p class="text-gray-400">
                                @if (request('q'))
                                    Thử tìm kiếm với từ khóa khác hoặc
                                    <a href="{{ route('shop') }}"
                                        class="text-green-600 hover:text-green-700 underline">xóa bộ lọc</a>
                                @else
                                    Hãy thử thay đổi bộ lọc của bạn
                                @endif
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                {{ $products->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <script>
        function setPriceRange(min, max) {
            document.querySelector('input[name="min_price"]').value = min || '';
            document.querySelector('input[name="max_price"]').value = max || '';
        }

        function filterCategories() {
            const searchTerm = document.getElementById('categorySearch').value.toLowerCase();
            const categoryItems = document.querySelectorAll('.category-item');
            let visibleCount = 0;

            categoryItems.forEach(item => {
                const categoryName = item.getAttribute('data-category-name') || '';
                const isAllCategory = !item.hasAttribute('data-category-name');

                if (isAllCategory || categoryName.includes(searchTerm)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            document.getElementById('noCategories').classList.toggle('hidden', visibleCount > 0);
        }

        function toggleCategories() {
            const categoryList = document.getElementById('categoryList');
            const icon = document.getElementById('categoryToggleIcon');

            if (categoryList.style.display === 'none') {
                categoryList.style.display = 'block';
                icon.style.transform = 'rotate(0deg)';
            } else {
                categoryList.style.display = 'none';
                icon.style.transform = 'rotate(-90deg)';
            }
        }

        // Auto-submit price filter when user stops typing
        let priceTimeout;
        document.querySelectorAll('input[name="min_price"], input[name="max_price"]').forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(priceTimeout);
                priceTimeout = setTimeout(() => {
                    document.getElementById('priceFilterForm').submit();
                }, 1000); // Wait 1 second after user stops typing
            });
        });

        // Preserve filters when sorting changes
        document.querySelector('select[name="sort"]').addEventListener('change', function() {
            // The form will automatically submit and preserve all hidden inputs
        });
    </script>
</x-layout>
