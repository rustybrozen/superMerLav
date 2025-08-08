<x-layout :title="'Dashboard'">
    <div class="max-w-7xl mx-auto px-4 py-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-900">
                    Xin chào, {{ Auth::user()->fullname ?? Auth::user()->username }}
                </h1>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" 
                        class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-800 rounded-lg font-medium transition-colors">
                        <i class="fas fa-sign-out-alt mr-1"></i>Đăng xuất
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Thông tin tài khoản</p>
                            <div class="space-y-1 text-sm">
                                <p><span class="font-medium">Họ và tên:</span> {{ Auth::user()->fullname }}</p>
                                <p><span class="font-medium">Email:</span> {{ Auth::user()->email ?? 'Chưa cập nhật' }}</p>
                                <p><span class="font-medium">Điện thoại:</span> {{ Auth::user()->phone ?? 'Chưa cập nhật' }}</p>
                                <p><span class="font-medium">Địa chỉ:</span> {{ Auth::user()->address ?? 'Chưa cập nhật' }}</p>
                            </div>
                        </div>
                        <div class="p-3 bg-gray-100 rounded-full">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Đơn hàng</p>
                            <p class="text-3xl font-bold text-gray-900">{{ Auth::user()->orders->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <i class="fas fa-shopping-bag text-green-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Thao tác nhanh</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('order.all') }}" 
                       class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                        <i class="fas fa-receipt mr-1"></i>Xem đơn hàng
                    </a>
                    <a href="{{ route('profile.show') }}" 
                       class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                        <i class="fas fa-user-edit mr-1"></i>Cập nhật thông tin
                    </a>
                
                </div>
            </div>
        </div>
    </div>
</x-layout>
