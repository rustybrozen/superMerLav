<!-- Navbar -->
<nav class="bg-gradient-to-r from-green-600 to-green-700 sticky top-0 z-50 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}"
                class="text-white text-2xl font-bold flex items-center gap-2 hover:text-green-100 transition-colors">
                <i class="fas fa-leaf text-green-200"></i>
                <span>Fresh Mart</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8">
                <ul class="flex items-center space-x-6 text-white font-medium">
                    <li>
                        <a href="{{ route('home') }}"
                            class="hover:text-green-200 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-green-200">
                            Trang Chủ
                        </a>
                    </li>
                    {{-- <li class="relative group">
                        <button
                            class="hover:text-green-200 flex items-center transition-colors py-2 px-1 border-b-2 border-transparent group-hover:border-green-200">
                            Danh Mục
                            <i
                                class="fas fa-chevron-down ml-1 text-xs transform group-hover:rotate-180 transition-transform"></i>
                        </button>
                        <ul
                            class="absolute left-0 top-full mt-1 bg-white text-gray-700 shadow-xl rounded-lg hidden group-hover:block min-w-[160px] overflow-hidden border border-gray-100">
                            <li><a href="{{ route('shop') }}"
                                    class="block px-4 py-3 hover:bg-green-50 hover:text-green-700 transition-colors">🥬
                                    Rau Củ</a></li>
                            <li><a href="shop.html?category_id=1"
                                    class="block px-4 py-3 hover:bg-green-50 hover:text-green-700 transition-colors">🥬
                                    Rau Củ</a></li>
                            <li><a href="{{ route('shop') }}"
                                    class="block px-4 py-3 hover:bg-green-50 hover:text-green-700 transition-colors">🍎
                                    Trái Cây</a></li>
                            <li><a href="{{ route('shop') }}"
                                    class="block px-4 py-3 hover:bg-green-50 hover:text-green-700 transition-colors">🥩
                                    Thịt Tươi</a></li>
                        </ul>
                    </li> --}}
                    <li>
                        <a href="{{ route('shop') }}"
                            class="hover:text-green-200 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-green-200">
                            Cửa Hàng
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}"
                            class="hover:text-green-200 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-green-200">
                            Về Chúng Tôi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}"
                            class="hover:text-green-200 transition-colors py-2 px-1 border-b-2 border-transparent hover:border-green-200">
                            Liên Hệ
                        </a>
                    </li>
                </ul>

                <!-- Right section -->
                <div class="flex items-center space-x-3">
                    @auth
                        <!-- If user is logged in -->
                        <div class="flex items-center space-x-3">
                            <!-- User greeting with dropdown -->
                            <div class="relative group">
                                <button
                                    class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all duration-200 shadow-sm">

                                    <span
                                        class="text-sm">{{ Str::limit(Auth::user()->fullname ?? Auth::user()->username, 15) }}</span>
                                    <i
                                        class="fas fa-chevron-down text-xs transform group-hover:rotate-180 transition-transform"></i>
                                </button>

                                <!-- User dropdown menu -->

                                <ul
                                    class="absolute right-0 top-full -mt-1 bg-white text-gray-700 shadow-lg rounded-xl hidden group-hover:block min-w-[220px] overflow-hidden border border-gray-200 z-50 ">

                                    <!-- Dashboard -->
                                    <li>
                                        <a href="{{ route('dashboard') }}"
                                            class="px-5 py-3 hover:bg-gray-50 transition-colors flex items-center gap-3">
                                            <i class="fas fa-tachometer-alt text-blue-500"></i>
                                            <span>Bảng điều khiển</span>
                                        </a>
                                    </li>

                                    <!-- Cập nhật thông tin -->
                                    <li>
                                        <a href="{{ route('profile.show') }}"
                                            class="px-5 py-3 hover:bg-gray-50 transition-colors flex items-center gap-3">
                                            <i class="fas fa-user-edit text-green-600"></i>
                                            <span>Cập nhật thông tin</span>
                                        </a>
                                    </li>

                                    <!-- Đơn hàng của tôi -->
                                    <li>
                                        <a href="#"
                                            class="px-5 py-3 hover:bg-gray-50 transition-colors flex items-center gap-3">
                                            <i class="fas fa-shopping-bag text-emerald-500"></i>
                                            <span>Đơn hàng của tôi</span>
                                        </a>
                                    </li>

                                    <!-- Quản trị (chỉ hiển thị nếu là admin) -->
                                    @if (Auth::user()->is_admin)
                                        <li class="border-t border-gray-100">
                                            <a href="#"
                                                class="px-5 py-3 hover:bg-gray-100 transition-colors flex items-center gap-3 text-red-600">
                                                <i class="fas fa-cogs"></i>
                                                <span>Trang quản trị</span>
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Đăng xuất -->
                                    <li class="border-t border-gray-100">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-left px-5 py-3 hover:bg-red-50 transition-colors flex items-center gap-3 text-red-600">
                                                <i class="fas fa-sign-out-alt"></i>
                                                <span>Đăng xuất</span>
                                            </button>
                                        </form>
                                    </li>

                                </ul>

                            </div>


                        </div>
                    @else
                        <!-- If user is NOT logged in -->
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}"
                                class="bg-green-800 hover:bg-green-900 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all duration-200 shadow-sm">
                                <i class="fas fa-user text-sm"></i>
                                <span>Đăng Nhập</span>
                            </a>
    
                        </div>
                    @endauth
                    <!-- Shopping cart -->
                    <a href="{{ route('cart') }}"
                        class="relative bg-green-800 hover:bg-green-900 text-white p-2 rounded-lg transition-all duration-200 shadow-sm">
                        <i class="fas fa-shopping-cart"></i>
                        {{-- @if (Auth::user()->activeCart && Auth::user()->activeCart->items->count() > 0)
                                    <span
                                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full min-w-[20px] h-5 flex items-center justify-center font-medium shadow-sm">
                                        {{ Auth::user()->activeCart->items->sum('quantity') }}
                                    </span>
                                @endif --}}
                    </a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <button class="text-white lg:hidden p-2 hover:bg-green-800 rounded-lg transition-colors"
                onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="lg:hidden hidden bg-green-800 mt-2 rounded-lg shadow-lg overflow-hidden">
            <ul class="py-2">
                <li><a href="{{ route('home') }}"
                        class="block px-4 py-3 text-white hover:bg-green-700 transition-colors">Trang Chủ</a></li>
                {{-- <li>
                    <button
                        class="w-full text-left px-4 py-3 text-white hover:bg-green-700 transition-colors flex items-center justify-between"
                        onclick="document.getElementById('mobileCategoryMenu').classList.toggle('hidden')">
                        Danh Mục
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    <ul id="mobileCategoryMenu" class="hidden bg-green-900 text-sm">
                        <li><a href="{{ route('shop') }}"
                                class="block px-8 py-2 text-white hover:bg-green-800 transition-colors">🥬 Rau Củ</a>
                        </li>
                        <li><a href="{{ route('shop') }}"
                                class="block px-8 py-2 text-white hover:bg-green-800 transition-colors">🍎 Trái Cây</a>
                        </li>
                        <li><a href="{{ route('shop') }}"
                                class="block px-8 py-2 text-white hover:bg-green-800 transition-colors">🥩 Thịt Tươi</a>
                        </li>
                    </ul>
                </li> --}}
                <li><a href="{{ route('shop') }}"
                        class="block px-4 py-3 text-white hover:bg-green-700 transition-colors">Cửa Hàng</a></li>
                <li><a href="" class="block px-4 py-3 text-white hover:bg-green-700 transition-colors">Về Chúng
                        Tôi</a></li>
                <li><a href="" class="block px-4 py-3 text-white hover:bg-green-700 transition-colors">Liên
                        Hệ</a></li>
            </ul>

            <!-- Mobile auth section -->
            <div class="border-t border-green-700 p-4">
                @auth
                    <div class="text-white text-sm mb-3">
                        Xin chào, {{ Auth::user()->fullname ?? Auth::user()->username }}! 👋
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('dashboard') }}"
                            class="block bg-green-700 hover:bg-green-600 text-white px-3 py-2 rounded transition-colors">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href=""
                            class="block bg-green-700 hover:bg-green-600 text-white px-3 py-2 rounded transition-colors">
                            <i class="fas fa-shopping-cart mr-2"></i>Giỏ hàng
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded transition-colors text-left">
                                <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                            </button>
                        </form>
                    </div>
                @else
                    <div class="space-y-2">
                        <a href="{{ route('login') }}"
                            class="block bg-green-700 hover:bg-green-600 text-white px-3 py-2 rounded text-center transition-colors">
                            <i class="fas fa-user mr-2"></i>Đăng Nhập
                        </a>
                        <a href="{{ route('register') }}"
                            class="block border border-green-200 hover:bg-green-200 hover:text-green-800 text-white px-3 py-2 rounded text-center transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>Đăng Ký
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Error message (keeping your original style) -->
@if (session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 relative shadow-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        <button class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-500 hover:text-red-700 transition-colors"
            onclick="this.parentElement.style.display='none';">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif
