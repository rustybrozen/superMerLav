<x-layout :title="'Danh sách đơn hàng'">
    <div class="max-w-7xl mx-auto py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fas fa-list text-green-600"></i> Danh Sách Đơn Hàng
        </h1>

        @forelse ($orders as $order)
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

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <div>
                        <div class="font-semibold text-gray-900 text-lg">Mã đơn: #{{ $order->id }}</div>
                        <div class="text-sm text-gray-500">Ngày đặt: {{ $order->order_date->format('d/m/Y H:i') }}</div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusLabels[$order->order_status] ?? ucfirst($order->order_status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-1">
                        <p><span class="text-gray-600">Người nhận:</span> <span class="font-medium text-gray-900">{{ $order->user->fullname ?? '—' }}</span></p>
                        <p><span class="text-gray-600">SĐT:</span> <span class="text-gray-900">{{ $order->user->phone ?? 'Không có' }}</span></p>
                    </div>
                    <div class="space-y-1">
                        <p><span class="text-gray-600">Phương thức thanh toán:</span> <span class="text-gray-900">{{ $order->payment_method ?? 'Chưa chọn' }}</span></p>
                        <p><span class="text-gray-600">Thành tiền:</span> <span class="font-semibold text-green-600">{{ number_format($order->total_price, 0, ',', '.') }}₫</p>
                    </div>
                </div>

                <div class="mt-4">
                    <h3 class="font-semibold mb-2 text-gray-800 flex items-center gap-1">
                        <i class="fas fa-shopping-cart text-green-600"></i> Sản phẩm đã đặt
                    </h3>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            @foreach ($order->orderDetails as $detail)
                                <div class="px-4 py-3 flex justify-between items-center bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $detail->product->name }}</div>
                                        <div class="text-xs text-gray-500">Phân loại: {{ $detail->product->category->name ?? 'Không rõ' }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-900">x{{ $detail->quantity }}</div>
                                        <div class="text-sm font-semibold text-gray-800">{{ number_format($detail->price_at_purchase, 0, ',', '.') }}₫ x {{ $detail->quantity }} = {{ number_format($detail->price_at_purchase * $detail->quantity, 0, ',', '.') }}₫</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-2 mb-10 flex justify-end">
                    <a href="{{ route('order.details', ['order' => $order->id]) }}" class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded-lg transition-colors">
                        <i class="fas fa-eye mr-1"></i> Xem Chi Tiết
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center text-gray-500">
                <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                <p>Không có đơn hàng nào được tìm thấy</p>
            </div>
        @endforelse
    </div>
</x-layout>
