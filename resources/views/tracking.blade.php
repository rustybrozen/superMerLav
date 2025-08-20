<x-layout :title="'Theo dõi mã vận đơn'">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Theo dõi đơn hàng
                </h1>
                <p class="text-gray-600">Nhập mã đơn hàng và email để kiểm tra tình trạng vận chuyển</p>
            </div>
        </div>

        <form id="trackingForm" method="POST" action="{{ route('tracking.check') }}" class="space-y-6">
            @csrf

            <div>
                <label for="trackingId" class="block text-sm font-medium text-gray-700 mb-2">
                    Mã đơn hàng
                </label>
                <input type="text" id="trackingId" name="trackingId" placeholder="Nhập mã đơn hàng (VD: DH123456789)"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <input type="email" id="email" name="email" placeholder="Nhập email đã dùng khi đặt hàng"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
            </div>

            <!-- Submit -->
            <div class="text-right">
                <button type="submit"
                    class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Tra cứu
                </button>
            </div>
        </form>

    </div>
</x-layout>
