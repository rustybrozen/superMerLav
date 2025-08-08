<x-layout :title="'Đăng Ký'">
    <div class="w-[500px] mx-auto py-10">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Đăng ký tài khoản</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Tên đăng nhập *</label>
                    <input id="username" name="username" type="text" required value="{{ old('username') }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('username') border-red-500 @enderror" />
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Họ và tên *</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('phone') border-red-500 @enderror" />
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                    <input id="address" name="address" type="text" value="{{ old('address') }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('address') border-red-500 @enderror" />
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu *</label>
                    <input id="password" name="password" type="password" required
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Tối thiểu 6 ký tự</p>
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition-colors">
                    Đăng ký
                </button>

                <p class="mt-2 text-center text-sm text-gray-600">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-medium">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
</x-layout>
