<x-layout :title="'Đăng Nhập'">
    <div class="w-[500px] mx-auto py-10">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Đăng nhập</h2>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="login" class="block text-sm font-medium text-gray-700">Tên đăng nhập hoặc Email</label>
                    <input id="login" name="login" type="text" required value="{{ old('login') }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('login') border-red-500 @enderror" />
                    @error('login')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                    <input id="password" name="password" type="password" required
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition-colors">
                    Đăng nhập
                </button>

                <p class="mt-2 text-center text-sm text-gray-600">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-medium">Đăng ký ngay</a>
                </p>
            </form>
        </div>
    </div>
</x-layout>
