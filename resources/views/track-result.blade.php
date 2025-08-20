<x-layout :title="'Chi tiết đơn hàng'">
    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h1 class="text-2xl font-bold text-gray-900">
                  Chi Tiết Đơn Hàng
                </h1>
                <span class="text-sm text-gray-500">
                    Cập nhật lúc {{ now()->format('H:i d/m/Y') }}
                </span>
            </div>

            <div class="p-6 space-y-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Thông Tin Đơn Hàng</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Mã đơn hàng:</span>
                            <span class="font-semibold text-green-600">{{ $trackingId }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Trạng thái đơn hàng:</span>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                    'processing' => 'bg-purple-100 text-purple-800',
                                    'shipped' => 'bg-indigo-100 text-indigo-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800'
                                ];
                                $statusLabels = [
                                    'pending' => 'Chờ xử lý',
                                    'confirmed' => 'Đã xác nhận',
                                    'processing' => 'Đang xử lý',
                                    'shipped' => 'Đã gửi',
                                    'delivered' => 'Đã giao',
                                    'cancelled' => 'Đã hủy'
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$order_status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$order_status] ?? ucfirst($order_status) }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Thanh toán:</span>
                            <span class="text-gray-800">
                                {{ ucfirst($payment_status) }}
                            </span>
                        </div>

                        

                        <div class="flex justify-between">
                            <span class="text-gray-600">Tổng tiền:</span>
                            <span class="font-bold text-green-600">{{ number_format($total_price, 0, ',', '.') }}₫</span>
                        </div>
                    </div>
                </div>

              
            </div>
        </div>
    </div>
</x-layout>
