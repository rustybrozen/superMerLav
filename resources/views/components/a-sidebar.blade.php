@php
    $adminMenu = [
        ['label' => 'Doanh Thu', 'route' => 'admin.dashboard', 'icon' => 'fas fa-chart-line'],
        ['label' => 'Danh Mục', 'route' => 'admin.categories.index', 'icon' => 'fas fa-tags'],
        ['label' => 'Sản Phẩm', 'route' => 'admin.products.index', 'icon' => 'fas fa-box'],
        ['label' => 'Người Dùng', 'route' => 'admin.users.index', 'icon' => 'fas fa-users'],
        ['label' => 'Đơn Hàng', 'route' => 'admin.orders.index', 'icon' => 'fas fa-shopping-cart'],
    ];
@endphp

<div class="flex">

    <nav id="sidebar"
        class="bg-gradient-to-b from-green-600 to-green-700 w-64 min-h-screen fixed left-0 top-0 z-50 shadow-lg transform transition-transform duration-300 lg:translate-x-0 -translate-x-full">

        <div class="p-6 border-b border-green-500/30">
            <a href="{{ route('home') }}"
                class="text-white text-xl font-bold flex items-center gap-3 hover:text-green-100 transition-colors">
                <i class="fas fa-cogs text-2xl"></i>
                <span>Admin Panel</span>
            </a>
        </div>


        <div class="p-4">
            <ul class="space-y-2">
                @foreach ($adminMenu as $item)
                    <li>
                        <a href="{{ route($item['route']) }}"
                            class="flex items-center gap-3 text-white hover:bg-green-800 rounded-lg px-4 py-3 transition-all duration-200 group {{ request()->routeIs($item['route']) ? 'bg-green-800 shadow-md' : '' }}">
                            <i class="{{ $item['icon'] }} text-lg group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>


        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-green-500/30">
            @auth
                <div class="bg-green-800 rounded-lg p-4">
                    <div class="flex items-center gap-3 text-white mb-3">

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">
                                {{ Str::limit(Auth::user()->fullname ?? Auth::user()->username, 12) }}
                            </p>
                            <p class="text-xs text-green-200">Administrator</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <a href="{{ route('admin.profile.show') }}"
                            class="flex items-center gap-2 text-white hover:bg-green-700 rounded px-3 py-2 text-sm transition-colors">
                            <i class="fas fa-user-edit text-xs"></i>
                            <span>Cập nhật thông tin</span>
                        </a>

                        <form method="POST" action="{{ route('admin.logoutAdmin') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-2 text-white hover:bg-red-600 rounded px-3 py-2 text-sm transition-colors">
                                <i class="fas fa-sign-out-alt text-xs"></i>
                                <span>Đăng xuất</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="space-y-2">
                    <a href="{{ route('login') }}"
                        class="block bg-green-800 hover:bg-green-700 text-white px-4 py-3 rounded-lg text-center transition-colors">
                        <i class="fas fa-user mr-2"></i>Đăng Nhập
                    </a>
                    <a href="{{ route('register') }}"
                        class="block border border-green-200 hover:bg-green-200 hover:text-green-800 text-white px-4 py-3 rounded-lg text-center transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>Đăng Ký
                    </a>
                </div>
            @endauth
        </div>
    </nav>


    <button id="mobileMenuBtn"
        class="lg:hidden fixed top-4 left-4 z-50 bg-green-600 text-white p-3 rounded-lg shadow-lg hover:bg-green-700 transition-colors">
        <i class="fas fa-bars text-lg"></i>
    </button>


    <div id="overlay"
        class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"
        onclick="toggleSidebar()"></div>
</div>


@if (session('error'))
    <div class="lg:ml-64 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 relative shadow-sm" role="alert">
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

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }


    document.getElementById('mobileMenuBtn').addEventListener('click', toggleSidebar);


    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const mobileBtn = document.getElementById('mobileMenuBtn');

        if (window.innerWidth < 1024 &&
            !sidebar.contains(event.target) &&
            !mobileBtn.contains(event.target) &&
            !sidebar.classList.contains('-translate-x-full')) {
            toggleSidebar();
        }
    });
</script>
