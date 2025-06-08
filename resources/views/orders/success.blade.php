<x-layout :title="'Đặt hàng thành công'">
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Success Header -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-8 text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-6xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Đặt hàng thành công!</h1>
                    <p class="text-green-100 text-lg">Cảm ơn bạn đã tin tưởng và mua sắm tại cửa hàng chúng tôi</p>
                </div>

                <!-- Order Information -->
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Order Details -->
                        <div class="space-y-4">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-receipt mr-2 text-green-600"></i>
                                Thông tin đơn hàng
                            </h2>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Mã đơn hàng:</span>
                                        <span class="font-bold text-green-600">{{ $order->tracking_number }}</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Ngày đặt:</span>
                                        <span class="text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Trạng thái:</span>
                                        <span
                                            class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                            @switch($order->order_status)
                                                @case('pending')
                                                    Chờ xác nhận
                                                @break

                                                @case('confirmed')
                                                    Đã xác nhận
                                                @break

                                                @case('shipped')
                                                    Đang giao hàng
                                                @break

                                                @case('delivered')
                                                    Đã giao hàng
                                                @break

                                                @default
                                                    Chờ xử lý
                                            @endswitch
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">Thanh toán:</span>
                                        <span class="text-gray-600">
                                            {{ $order->payment_method === 'cod' ? 'COD (Thanh toán khi nhận hàng)' : 'Thẻ tín dụng' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="space-y-4">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-user mr-2 text-green-600"></i>
                                Thông tin khách hàng
                            </h2>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-3">
                                    <div>
                                        <span class="font-medium text-gray-700">Tên:</span>
                                        <p class="text-gray-600 mt-1">{{ $order->getCustomerName() }}</p>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-700">Email:</span>
                                        <p class="text-gray-600 mt-1">{{ $order->getCustomerEmail() }}</p>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-700">Số điện thoại:</span>
                                        <p class="text-gray-600 mt-1">{{ $order->getCustomerPhone() }}</p>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-700">Địa chỉ giao hàng:</span>
                                        <p class="text-gray-600 mt-1">{{ $order->getFullShippingAddress() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-shopping-bag mr-2 text-green-600"></i>
                            Sản phẩm đã đặt
                        </h2>

                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                <div class="grid grid-cols-12 gap-4 font-medium text-gray-700">
                                    <div class="col-span-6">Sản phẩm</div>
                                    <div class="col-span-2 text-center">Đơn giá</div>
                                    <div class="col-span-2 text-center">Số lượng</div>
                                    <div class="col-span-2 text-right">Thành tiền</div>
                                </div>
                            </div>

                            <div class="divide-y divide-gray-200">
                                @foreach ($order->orderDetails as $detail)
                                    <div class="px-6 py-4">
                                        <div class="grid grid-cols-12 gap-4 items-center">
                                            <div class="col-span-6 flex items-center space-x-4">
                                                <img src="{{ $detail->product && $detail->product->image ? asset('storage/' . $detail->product->image) : 'https://placehold.co/60x60' }}"
                                                    alt="{{ $detail->product_name }}"
                                                    class="w-16 h-16 object-cover rounded-lg">
                                                <div>
                                                    <h3 class="font-semibold text-gray-800">{{ $detail->product_name }}
                                                    </h3>
                                                    @if ($detail->product && $detail->product->category)
                                                        <p class="text-sm text-gray-500">
                                                            {{ $detail->product->category->name }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-span-2 text-center">
                                                <span
                                                    class="font-semibold text-gray-800">{{ number_format($detail->price_at_purchase) }}
                                                    ₫</span>
                                            </div>

                                            <div class="col-span-2 text-center">
                                                <span
                                                    class="font-semibold text-gray-800">{{ $detail->quantity }}</span>
                                            </div>

                                            <div class="col-span-2 text-right">
                                                <span class="font-bold text-gray-900">
                                                    {{ number_format($detail->price_at_purchase * $detail->quantity) }}
                                                    ₫
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="mb-8">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-lg">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Tổng kết đơn hàng</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between text-gray-700">
                                    <span>Tạm tính:</span>
                                    <span
                                        class="font-semibold">{{ number_format($order->orderDetails->sum(function ($detail) {return $detail->price_at_purchase * $detail->quantity;})) }}
                                        ₫</span>
                                </div>

                                <div class="flex justify-between text-gray-700">
                                    <span>Phí vận chuyển:</span>
                                    <span class="font-semibold">{{ number_format($order->shipping_fee ?? 0) }} ₫</span>
                                </div>

                                @if ($order->discount_amount > 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>Giảm giá:</span>
                                        <span class="font-semibold">-{{ number_format($order->discount_amount) }}
                                            ₫</span>
                                    </div>
                                @endif

                                <div class="border-t border-gray-300 pt-3">
                                    <div class="flex justify-between text-xl font-bold text-gray-900">
                                        <span>Tổng cộng:</span>
                                        <span class="text-green-600">{{ number_format($order->total_amount) }} ₫</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="mb-8">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-blue-900 mb-4">
                                <i class="fas fa-info-circle mr-2"></i>
                                Bước tiếp theo
                            </h3>
                            <div class="space-y-3 text-blue-800">
                                <div class="flex items-start space-x-3">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                                    <p>Chúng tôi sẽ xác nhận đơn hàng của bạn trong vòng 1-2 giờ làm việc</p>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                                    <p>Đơn hàng sẽ được chuẩn bị và đóng gói cẩn thận</p>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                                    <p>Chúng tôi sẽ gửi email thông báo khi đơn hàng được giao cho đơn vị vận chuyển</p>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <span
                                        class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">4</span>
                                    <p>Theo dõi tình trạng đơn hàng bằng mã tracking: <span
                                            class="font-bold">{{ $order->tracking_number }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-8">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-yellow-900 mb-4">
                                <i class="fas fa-phone-alt mr-2"></i>
                                Cần hỗ trợ?
                            </h3>
                            <div class="text-yellow-800 space-y-2">
                                <p>Nếu bạn có bất kỳ câu hỏi nào về đơn hàng, vui lòng liên hệ với chúng tôi:</p>
                                <div class="flex flex-wrap gap-4 mt-3">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-phone text-green-600"></i>
                                        <span class="font-semibold">Hotline: 1900-xxxx</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-envelope text-green-600"></i>
                                        <span class="font-semibold">Email: support@example.com</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fab fa-facebook-messenger text-green-600"></i>
                                        <span class="font-semibold">Chat trực tuyến</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        {{-- <a href="{{ route('orders.track', $order->tracking_number) }}" 
                           class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors text-center">
                            <i class="fas fa-search mr-2"></i>
                            Theo dõi đơn hàng
                        </a> --}}

                        <a href="{{ route('home') }}"
                            class="px-8 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors text-center">
                            <i class="fas fa-home mr-2"></i>
                            Về trang chủ
                        </a>

                        <a href="{{ route('cart') }}"
                            class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors text-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
