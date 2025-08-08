<x-a-layout :title="'Profile'">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Quản Lý Hồ Sơ</h1>
            <div class="text-sm text-gray-500">
                <i class="fas fa-clock mr-1"></i>
                Cập nhật lúc {{ now()->format('H:i d/m/Y') }}
            </div>
        </div>

        @if (session('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-user-edit text-green-600"></i>
                    Cập Nhật Hồ Sơ
                </h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @csrf

                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-700 mb-2">Họ và Tên</label>
                        <input type="text" name="fullname" value="{{ old('fullname', $user->fullname) }}" 
                            placeholder="Nhập họ và tên"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('fullname') border-red-500 @enderror">
                        @error('fullname')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                            placeholder="Nhập email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="lg:col-span-2">
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>Lưu Thay Đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-lock text-green-600"></i>
                    Đổi Mật Khẩu
                </h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mật Khẩu Hiện Tại</label>
                        <input type="password" name="current_password" placeholder="Nhập mật khẩu hiện tại"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Mật Khẩu Mới</label>
                        <input type="password" name="new_password" placeholder="Nhập mật khẩu mới"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Xác Nhận Mật Khẩu Mới</label>
                        <input type="password" name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('new_password_confirmation') border-red-500 @enderror">
                        @error('new_password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                            <i class="fas fa-key mr-2"></i>Đổi Mật Khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-a-layout>