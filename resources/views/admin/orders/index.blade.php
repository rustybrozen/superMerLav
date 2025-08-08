<x-a-layout>
    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Quản Lý Đơn Hàng</h1>
            <div class="text-sm text-gray-500">
                <i class="fas fa-clock mr-1"></i>
                Cập nhật lúc {{ now()->format('H:i d/m/Y') }}
            </div>
        </div>

   
        @if (session('ok'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('ok') }}
            </div>
        @endif


        <div class="mb-8 grid grid-cols-1 md:grid-cols-1 gap-6">
       
            
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm md:col-span-2">
                <p class="text-sm font-medium text-gray-600 mb-4">Đơn Hàng Mới Nhất (Đơn Chờ Xử Lý : {{ $pendingCount }})</p>
                
                <div class="flex flex-wrap gap-2">
                    @forelse($latestPending as $o)
                        <a href="{{ route('admin.orders.show', $o) }}"
                            class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-colors">
                            #{{ $o->order_number }} • {{ $o->created_at->diffForHumans() }}
                        </a>
                    @empty
                        <span class="text-gray-500 text-sm italic">Không có đơn hàng chờ xử lý</span>
                    @endforelse
                </div>
            </div>
        </div>

       
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 shadow-sm">
            <form method="GET" class="flex flex-col lg:flex-row lg:items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm Kiếm</label>
                    <input type="text" name="q" value="{{ $q ?? '' }}"
                        placeholder="Nhập mã đơn, tên khách hàng, email, số điện thoại..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                </div>

                <div class="lg:w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trạng Thái</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Tất cả trạng thái</option>
                        @foreach (['pending' => 'Chờ xử lý', 'confirmed' => 'Đã xác nhận', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'] as $key => $label)
                            <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Tìm Kiếm
                    </button>
                    @if (($q ?? '') !== '' || ($status ?? '') !== '')
                        <a href="{{ route('admin.orders.index') }}" 
                           class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                            <i class="fas fa-times mr-2"></i>Xóa
                        </a>
                    @endif
                </div>
            </form>
        </div>

      
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đơn Hàng</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày Tạo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách Hàng</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản Phẩm</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng Tiền</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng Thái</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thanh Toán</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $o)
                            <tr class="{{ $o->order_status === 'pending' ? 'bg-yellow-50' : 'hover:bg-gray-50' }} transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="font-semibold text-gray-900">#{{ $o->order_number }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $o->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm">
                                        @if ($o->user)
                                            <div class="font-medium text-gray-900">{{ $o->user->fullname ?? $o->user->username }}</div>
                                            <div class="text-gray-500">{{ $o->user->email }}</div>
                                        @else
                                            <div class="font-medium text-gray-900">{{ $o->guest_name }}</div>
                                            <div class="text-gray-500">{{ $o->guest_email }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $o->total_items }} sản phẩm
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="font-semibold text-gray-900">{{ number_format($o->total_price) }}₫</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
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
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$o->order_status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$o->order_status] ?? ucfirst($o->order_status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
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
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $paymentColors[$o->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $paymentLabels[$o->payment_status] ?? ucfirst($o->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    @php $locked = in_array($o->order_status, ['cancelled','delivered']); @endphp
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('admin.orders.show', $o) }}"
                                            class="inline-flex items-center px-3 py-1 rounded-lg bg-green-100 hover:bg-green-200 text-green-800 text-xs font-medium transition-colors">
                                            <i class="fas fa-eye mr-1"></i>Xem
                                        </a>
                                        
                                    
                                        <form action="{{ route('admin.orders.updateStatus', $o) }}" method="POST" class="flex gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <select name="order_status" class="text-xs border border-gray-300 rounded px-2 py-1 {{ $locked ? 'bg-gray-100 cursor-not-allowed' : '' }}" {{ $locked ? 'disabled' : '' }}>
                                                @foreach (['pending' => 'Chờ xử lý', 'confirmed' => 'Đã xác nhận', 'processing' => 'Đang xử lý', 'shipped' => 'Đã gửi', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'] as $key => $label)
                                                    <option value="{{ $key }}" {{ $o->order_status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-2 py-1 text-xs rounded {{ $locked ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-600 hover:bg-gray-700 text-white' }} transition-colors" {{ $locked ? 'disabled' : '' }}>
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </form>

                                      
                                        <form action="{{ route('admin.orders.updatePaymentStatus', $o) }}" method="POST" class="flex gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <select name="payment_status" class="text-xs border border-gray-300 rounded px-2 py-1">
                                                @foreach (['pending' => 'Chờ TT', 'completed' => 'Đã TT', 'failed' => 'Thất bại', 'refunded' => 'Hoàn tiền'] as $key => $label)
                                                    <option value="{{ $key }}" {{ $o->payment_status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-2 py-1 text-xs rounded bg-gray-600 hover:bg-gray-700 text-white transition-colors">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-lg font-medium">Không có đơn hàng nào</p>
                                        <p class="text-sm">Chưa có đơn hàng nào phù hợp với bộ lọc của bạn</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

      
        @if($orders->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-a-layout>