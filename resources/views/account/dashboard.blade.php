<x-layout :title="'Dashboard'">
    <div class="container mx-auto px-4 py-8">
        {{-- Welcome message --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    Xin chào, {{ Auth::user()->fullname ?? Auth::user()->username }}! 👋
                </h1>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Đăng xuất
                    </button>
                </form>
            </div>

            {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"> --}}
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- User Info Card --}}
                <div class="bg-blue-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-4">Thông tin tài khoản</h3>
                    <div class="space-y-2 text-sm">
                        <p><span class="font-medium">Họ và tên:</span> {{ Auth::user()->fullname }}</p>
                        <p><span class="font-medium">Email:</span> {{ Auth::user()->email ?? 'Chưa cập nhật' }}</p>
                        <p><span class="font-medium">Điện thoại:</span> {{ Auth::user()->phone ?? 'Chưa cập nhật' }}</p>
                        <p><span class="font-medium">Địa chỉ:</span> {{ Auth::user()->address ?? 'Chưa cập nhật' }}</p>
                    </div>
                </div>

                {{-- Orders Card --}}
                <div class="bg-green-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-4">Đơn hàng</h3>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ Auth::user()->orders->count() }}</div>
                        <p class="text-sm text-green-700">Tổng đơn hàng</p>
                    </div>
                </div>

                {{-- Reviews Card --}}
                {{-- <div class="bg-yellow-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-4">Đánh giá</h3>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ Auth::user()->reviews->count() }}</div>
                        <p class="text-sm text-yellow-700">Đánh giá đã viết</p>
                    </div>
                </div> --}}
            </div>

            {{-- Quick Actions --}}
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Thao tác nhanh</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition duration-200">
                        Xem đơn hàng
                    </a>
                    <a href="{{ route('profile.show') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg transition duration-200">
                        Cập nhật thông tin
                    </a>
                    <a href="{{ route('cart') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-lg transition duration-200">
                        Giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>