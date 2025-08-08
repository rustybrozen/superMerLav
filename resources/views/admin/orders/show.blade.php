<x-a-layout>
    <div class="max-w-7xl mx-auto space-y-6">

        @if(session('ok'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('ok') }}
            </div>
        @endif

      
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <h1 class="text-3xl font-bold text-gray-900">Đơn Hàng #{{ $order->order_number }}</h1>

            @php
                $locked = in_array($order->order_status, ['cancelled','delivered']);
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

            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex gap-2">
                @csrf
                @method('PATCH')
                <select name="order_status"
                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm {{ $locked ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                    {{ $locked ? 'disabled' : '' }}>
                    @foreach ($statusLabels as $key => $label)
                        <option value="{{ $key }}" {{ $order->order_status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="px-4 py-2 text-sm rounded {{ $locked ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-600 hover:bg-gray-700 text-white' }} transition-colors"
                    {{ $locked ? 'disabled' : '' }}>
                    <i class="fas fa-save mr-1"></i>Cập nhật
                </button>
            </form>
        </div>

     
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm space-y-4 md:col-span-2">
                <div>
                    <p class="text-sm font-medium text-gray-600">Khách Hàng</p>
                    <div class="mt-1">
                        @if($order->user)
                            <div class="font-medium text-gray-900">{{ $order->user->fullname ?? $order->user->username }}</div>
                            <div class="text-gray-500 text-sm">{{ $order->user->email }} • {{ $order->user->phone }}</div>
                        @else
                            <div class="font-medium text-gray-900">{{ $order->guest_name }}</div>
                            <div class="text-gray-500 text-sm">{{ $order->guest_email }} • {{ $order->guest_phone }}</div>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Địa Chỉ Giao Hàng</p>
                    <p class="text-sm mt-1">{{ $order->getFullShippingAddress() }}</p>
                    @if($order->shipping_notes)
                        <p class="text-sm text-gray-500 mt-1">Ghi chú: {{ $order->shipping_notes }}</p>
                    @endif
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Ngày Tạo</p>
                    <p class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    @php
                        $paymentColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'failed' => 'bg-red-100 text-red-800',
                            'refunded' => 'bg-gray-100 text-gray-800'
                        ];
                        $paymentLabels = [
                            'pending' => 'Chờ thanh toán',
                            'completed' => 'Đã thanh toán',
                            'failed' => 'Thất bại',
                            'refunded' => 'Đã hoàn tiền'
                        ];
                    @endphp
                    <p class="text-sm text-gray-600">Thanh Toán</p>
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $paymentLabels[$order->payment_status] ?? ucfirst($order->payment_status) }}
                    </span>
                    @if($order->payment_method)
                        <span class="text-sm text-gray-500">• {{ $order->payment_method }}</span>
                    @endif
                </div>
                @if($order->tracking_number)
                    <div>
                        <p class="text-sm text-gray-600">Mã Vận Chuyển</p>
                        <p class="text-sm">{{ $order->tracking_number }}</p>
                    </div>
                @endif
            </div>
        </div>

      
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <p class="font-semibold mb-3">Sản Phẩm</p>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Sản phẩm</th>
                            <th class="px-4 py-2 text-right">Giá</th>
                            <th class="px-4 py-2 text-center">SL</th>
                            <th class="px-4 py-2 text-right">Tạm tính</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->orderDetails as $d)
                            <tr>
                                <td class="px-4 py-2">{{ $d->product_name ?? ($d->product->name ?? 'Sản phẩm #'.$d->product_id) }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($d->price_at_purchase) }}₫</td>
                                <td class="px-4 py-2 text-center">{{ $d->quantity }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($d->price_at_purchase * $d->quantity) }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2"></div>
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm space-y-2">
                <div class="flex justify-between text-sm"><span>Tạm tính</span><span>{{ number_format($order->subtotal) }}₫</span></div>
                <div class="flex justify-between text-sm"><span>Giảm giá</span><span>-{{ number_format($order->discount_amount) }}₫</span></div>
                <div class="flex justify-between text-sm"><span>Phí vận chuyển</span><span>{{ number_format($order->shipping_fee) }}₫</span></div>
                <div class="h-px bg-gray-200 my-2"></div>
                <div class="flex justify-between font-semibold text-lg"><span>Tổng cộng</span><span>{{ number_format($order->total_price) }}₫</span></div>
            </div>
        </div>
    </div>
</x-a-layout>
