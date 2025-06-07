<x-layout :title="'Profile'">
    <div class="container mx-auto px-4 max-w-7xl py-6 space-y-8">

        <div class="bg-white shadow-lg rounded-xl p-6 space-y-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-user-edit text-green-600"></i> Cập nhật hồ sơ
            </h2>

            <form method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @csrf

                <div class="flex flex-col">
                    <label for="fullname" class="text-sm font-medium text-gray-700">Họ và tên</label>
                    <input type="text" name="fullname" value="{{ old('fullname', $user->fullname) }}" placeholder="Nhập họ và tên"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('fullname') border-red-500 @enderror">
                    @error('fullname')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label for="phone" class="text-sm font-medium text-gray-700">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Nhập số điện thoại"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Nhập email"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label for="address" class="text-sm font-medium text-gray-700">Địa chỉ</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Nhập địa chỉ"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('address') border-red-500 @enderror">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition-colors duration-300">
                        <i class="fas fa-save mr-2"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-lg rounded-xl p-6 space-y-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-lock text-blue-600"></i> Đổi mật khẩu
            </h2>

            <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                @csrf

                <div class="flex flex-col">
                    <label for="current_password" class="text-sm font-medium text-gray-700">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" placeholder="Nhập mật khẩu hiện tại"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label for="new_password" class="text-sm font-medium text-gray-700">Mật khẩu mới</label>
                    <input type="password" name="new_password" placeholder="Nhập mật khẩu mới"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('new_password') border-red-500 @enderror">
                    @error('new_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label for="new_password_confirmation" class="text-sm font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                    <input type="password" name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('new_password_confirmation') border-red-500 @enderror">
                    @error('new_password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition-colors duration-300">
                        <i class="fas fa-key mr-2"></i> Đổi mật khẩu
                    </button>
                </div>
            </form>
        </div>

        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative shadow-md mt-4 transition-opacity duration-300">
                <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
            </div>
        @endif

    </div>
</x-layout>
