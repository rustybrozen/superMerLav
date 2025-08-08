<x-layout :title="'Chi tiết đơn hàng'">
    <div class="max-w-7xl mx-auto py-8">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h1 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-receipt mr-2 text-green-600"></i>Chi Tiết Đơn Hàng
                </h1>
                <span class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Cập nhật lúc {{ now()->format('H:i d/m/Y') }}
                </span>
            </div>

            <div class="p-6 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Thông Tin Đơn Hàng</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Mã đơn hàng:</span>
                                <span class="font-semibold text-green-600">{{ $order->tracking_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ngày đặt:</span>
                                <span class="text-gray-800">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Trạng thái:</span>
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
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$order->order_status] ?? ucfirst($order->order_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Thanh toán:</span>
                                <span class="text-gray-800">
                                    {{ $order->payment_method === 'cod' ? 'COD (Thanh toán khi nhận hàng)' : 'Thẻ tín dụng' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Thông Tin Khách Hàng</h2>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-gray-600">Tên:</span>
                                <p class="font-medium text-gray-800 mt-1">{{ $order->getCustomerName() }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Email:</span>
                                <p class="text-gray-800 mt-1">{{ $order->getCustomerEmail() }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Số điện thoại:</span>
                                <p class="text-gray-800 mt-1">{{ $order->getCustomerPhone() }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Địa chỉ giao hàng:</span>
                                <p class="text-gray-800 mt-1">{{ $order->getFullShippingAddress() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Sản Phẩm Đã Đặt</h2>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 text-sm font-medium text-gray-600 grid grid-cols-12 gap-4">
                            <div class="col-span-6">Sản phẩm</div>
                            <div class="col-span-2 text-center">Đơn giá</div>
                            <div class="col-span-2 text-center">Số lượng</div>
                            <div class="col-span-2 text-right">Thành tiền</div>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach ($order->orderDetails as $detail)
                                <div class="px-6 py-4 grid grid-cols-12 gap-4 items-center text-sm">
                                    <div class="col-span-6 flex items-center gap-4">
                                        <img src="{{ $detail->product && $detail->product->image ? asset('/' . $detail->product->image) : 'https://placehold.co/60x60' }}" class="w-16 h-16 object-cover rounded-lg">
                                        <div>
                                            <div class="font-medium text-gray-800">{{ $detail->product_name }}</div>
                                            @if ($detail->product && $detail->product->category)
                                                <div class="text-gray-500 text-xs">{{ $detail->product->category->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-span-2 text-center font-medium text-gray-800">{{ number_format($detail->price_at_purchase, 0, ',', '.') }}₫</p>
                                    <div class="col-span-2 text-center font-medium text-gray-800">{{ $detail->quantity }}</div>
                                    <div class="col-span-2 text-right font-semibold text-gray-900">{{ number_format($detail->price_at_purchase * $detail->quantity, 0, ',', '.') }}₫</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tổng Kết Đơn Hàng</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tạm tính:</span>
                            <span class="font-medium">{{ number_format($order->orderDetails->sum(fn($d) => $d->price_at_purchase * $d->quantity), 0, ',', '.') }}₫</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí vận chuyển:</span>
                            <span class="font-medium">{{ number_format($order->shipping_fee ?? 0) }}₫</span>
                        </div>
                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Giảm giá:</span>
                                <span class="font-medium">-{{ number_format($order->discount_amount) }}₫</span>
                            </div>
                        @endif
                        <div class="border-t border-gray-300 pt-3">
                            <div class="flex justify-between text-base font-bold text-gray-900">
                                <span>Tổng cộng:</span>
                                <span class="text-green-600">{{ number_format($order->total_amount) }}₫</span>
                            </div>
                        </div>
                    </div>
                      <div class="flex justify-center">
                    <a href="{{ route('order.all') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>Quay Lại
                    </a>
                </div>
                </div>

            
            </div>
        </div>
    </div>
</x-layout>
