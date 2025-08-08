<x-layout>
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm text-center">
            
                <h5 class="mt-4 text-lg font-semibold text-gray-900">Địa Chỉ Của Chúng Tôi</h5>
                <p class="text-gray-600 mt-2">365 Phố Mini Market, Việt Nam</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm text-center">
                
                <h5 class="mt-4 text-lg font-semibold text-gray-900">Điện Thoại</h5>
                <p class="text-gray-600 mt-2">+84 123 456 789</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm text-center">
                
                <h5 class="mt-4 text-lg font-semibold text-gray-900">Email</h5>
                <p class="text-gray-600 mt-2">contact@minimarket.com</p>
            </div>
        </div>

        <div class="mt-12 max-w-3xl mx-auto">
            <h2 class="text-center text-2xl font-bold text-gray-900 mb-6">Gửi Tin Nhắn Cho Chúng Tôi</h2>
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <form action="" method="" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ và Tên</label>
                            <input type="text" id="name" name="name" placeholder="Nhập tên của bạn"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Địa Chỉ Email</label>
                            <input type="email" id="email" name="email" placeholder="Nhập email của bạn"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                        </div>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Tin Nhắn</label>
                        <textarea id="message" name="message" rows="5" placeholder="Viết tin nhắn của bạn ở đây"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                            Gửi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout>
