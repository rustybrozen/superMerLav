<x-layout :title="'Đăng Nhập'">
    <div class="w-full max-w-md mx-auto bg-white p-6 rounded-2xl shadow-md my-10">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Đăng nhập</h2>
        
        {{-- Display success messages --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Display validation errors --}}
        {{-- @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="login" class="block text-sm font-medium text-gray-700">Tên đăng nhập hoặc Email</label>
                <input id="login" name="login" type="text" required 
                    value="{{ old('login') }}"
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300 @error('login') border-red-500 @enderror" />
                @error('login')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                <input id="password" name="password" type="password" required
                    class="mt-1 block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300 @error('password') border-red-500 @enderror" />
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Đăng nhập
            </button>
            
            <p class="mt-2 text-center text-sm text-gray-600">
                Chưa có tài khoản? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Đăng ký ngay</a>
            </p>
        </form>
    </div>
</x-layout>