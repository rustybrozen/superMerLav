<x-a-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-8">
    
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Tổng Quan</h1>
            <form method="GET" class="flex flex-col lg:flex-row lg:items-end gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Chế độ</label>
                    <select name="mode" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" onchange="this.form.submit()">
                        <option value="day"   {{ $mode==='day' ? 'selected' : '' }}>Hôm nay</option>
                        <option value="week"  {{ $mode==='week' ? 'selected' : '' }}>Tuần</option>
                        <option value="month" {{ $mode==='month' ? 'selected' : '' }}>Tháng</option>
                        <option value="year"  {{ $mode==='year' ? 'selected' : '' }}>Năm</option>
                        <option value="custom" {{ $mode==='custom' ? 'selected' : '' }}>Tùy chọn</option>
                    </select>
                </div>

                <div id="custom-range" class="flex items-center gap-2 {{ $mode==='custom' ? '' : 'hidden' }}">
                    <input type="date" name="from" value="{{ request('from') ?: $from->format('Y-m-d') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                    <span>→</span>
                    <input type="date" name="to" value="{{ request('to') ?: $to->format('Y-m-d') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                    <button class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">Lọc</button>
                </div>

                <script>
                    const sel = document.querySelector('select[name="mode"]');
                    const box = document.getElementById('custom-range');
                    sel?.addEventListener('change', () => {
                        if (sel.value === 'custom') {
                            box.classList.remove('hidden');
                        } else {
                            box.classList.add('hidden');
                        }
                    });
                </script>
            </form>
        </div>

       
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-600">Khách hàng (Đang hoạt động)</p>
                <p class="text-3xl font-bold text-gray-900">{{ $activeCustomers }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-600">Sản phẩm (Đang hoạt động)</p>
                <p class="text-3xl font-bold text-gray-900">{{ $activeProducts }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-600">Danh mục (Đang hoạt động)</p>
                <p class="text-3xl font-bold text-gray-900">{{ $activeCategories }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-600">Đơn chờ xử lý</p>
                <p class="text-3xl font-bold text-gray-900">{{ $pendingOrdersCount }}</p>
            </div>
        </div>

      
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-600">Số đơn (đã thanh toán)</p>
                <p class="text-3xl font-bold text-gray-900">{{ $ordersCount }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $from->format('d/m/Y') }} → {{ $to->format('d/m/Y') }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-600">Doanh thu</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($revenue) }}₫</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-600">Lợi nhuận (ước tính)</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($profit) }}₫</p>
            </div>
        </div>

      
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="font-semibold mb-3">Đơn hàng đã hoàn tất</div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày đặt</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Lợi nhuận</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $o)
                            @php
                                $profitOrder = 0;
                                foreach ($o->orderDetails as $d) {
                                    $profitOrder += ($d->price_at_purchase - ($d->product->in_price ?? 0)) * $d->quantity;
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 font-semibold text-gray-900">#{{ $o->order_number }}</td>
                                <td class="px-4 py-4 text-sm text-gray-600">{{ $o->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-4">
                                    @if($o->user)
                                        <div class="font-medium text-gray-900">{{ $o->user->fullname ?? $o->user->username }}</div>
                                    @else
                                        <div class="font-medium text-gray-900">{{ $o->guest_name }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-gray-600">{{ $o->total_items }}</td>
                                <td class="px-4 py-4 text-right font-semibold text-gray-900">{{ number_format($o->total_price) }}₫</td>
                                <td class="px-4 py-4 text-right font-semibold text-gray-900">{{ number_format($profitOrder) }}₫</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-lg font-medium">Không có đơn nào</p>
                                        <p class="text-sm">Chưa có đơn hàng nào phù hợp với bộ lọc</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-a-layout>
