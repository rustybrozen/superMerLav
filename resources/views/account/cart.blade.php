<x-layout :title="'Giỏ Hàng'">
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Empty Cart State -->
                @if(!$cart || $cartItems->isEmpty())
                    <div class="text-center py-16">
                        <div class="mb-8">
                            <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                            <h1 class="text-3xl font-bold text-gray-800 mb-4">Giỏ hàng trống</h1>
                            <p class="text-gray-600 mb-6">Chưa có sản phẩm nào trong giỏ hàng của bạn</p>
                        </div>
                        <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-store mr-2"></i>
                            Tới cửa hàng
                        </a>
                    </div>
                @else
                    <!-- Cart with Items -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
                        <!-- Cart Items Section -->
                        <div class="lg:col-span-2 p-6 lg:p-8">
                            <!-- Header -->
                            <div class="flex justify-between items-center mb-8">
                                <h1 class="text-3xl font-bold text-gray-800">Giỏ hàng</h1>
                                <span class="text-lg text-gray-600 font-medium" id="cart-count">{{ $cart->total_items }} món đồ</span>
                            </div>

                            <hr class="border-gray-200 mb-8">

                            <!-- Cart Items -->
                            <div class="space-y-6" id="cart-items">
                                @foreach($cartItems as $item)
                                <div class="flex flex-col md:flex-row items-center gap-4 p-4 bg-gray-50 rounded-lg cart-item" data-product-id="{{ $item->product_id }}">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/120x120' }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-20 h-20 md:w-24 md:h-24 object-cover rounded-lg shadow-sm">
                                    </div>
                                    
                                    <div class="flex-1 text-center md:text-left space-y-2">
                                        <p class="text-sm text-gray-500 font-medium">{{ $item->product->category->name ?? 'Sản phẩm' }}</p>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                        <p class="text-green-600 font-bold">{{ number_format($item->price_at_add) }} ₫</p>
                                        
                                        @if($item->price_changed)
                                            <div class="text-xs text-orange-600">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Giá đã thay đổi: {{ number_format($item->product->price) }} ₫
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors quantity-btn" 
                                                    data-action="decrease" data-product-id="{{ $item->product_id }}">
                                                <i class="fas fa-minus text-sm"></i>
                                            </button>
                                            <input type="number" value="{{ $item->quantity }}" min="1"
                                                   class="w-16 text-center border-0 focus:ring-0 focus:outline-none bg-transparent quantity-input"
                                                   data-product-id="{{ $item->product_id }}">
                                            <button class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors quantity-btn" 
                                                    data-action="increase" data-product-id="{{ $item->product_id }}">
                                                <i class="fas fa-plus text-sm"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-gray-800 item-subtotal">{{ number_format($item->subtotal) }} ₫</p>
                                        </div>
                                        
                                        <button class="text-red-500 hover:text-red-700 transition-colors p-2 remove-item" 
                                                data-product-id="{{ $item->product_id }}">
                                            <i class="fas fa-trash text-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Continue Shopping -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <a href="{{ route('shop') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Quay lại cửa hàng
                                </a>
                            </div>
                        </div>

                        <!-- Checkout Summary Section -->
                        <div class="bg-gray-100 p-6 lg:p-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Thống kê</h2>

                            <!-- Shipping Method -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-3">Hình thức giao hàng</h3>
                                <select class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="express">Giao hàng hỏa tốc - Miễn phí</option>
                                </select>
                            </div>

                            <!-- Delivery Address -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-3">Địa chỉ giao hàng</h3>
                                <form class="space-y-3">
                                    <textarea rows="3" 
                                              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"
                                              placeholder="Nhập địa chỉ giao hàng của bạn...">{{ auth()->user()->address ?? '' }}</textarea>
                                    <button type="submit" 
                                            class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                        Cập nhật địa chỉ
                                    </button>
                                </form>
                            </div>

                            <!-- Voucher Code -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-3">Mã giảm giá</h3>
                                <form class="space-y-3" id="voucher-form">
                                    <input type="text" 
                                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           placeholder="Nhập mã giảm giá"
                                           id="voucher-input">
                                    <button type="submit" 
                                            class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                        Áp dụng
                                    </button>
                                </form>
                                <div class="hidden mt-2 p-2 bg-green-100 text-green-700 rounded text-sm font-medium" id="voucher-success">
                                    ✓ Áp dụng mã giảm giá thành công!
                                </div>
                            </div>

                            <hr class="border-gray-300 my-6">

                            <!-- Order Summary -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-lg">
                                    <span class="font-semibold text-gray-700">Sản phẩm: <span id="summary-count">{{ $cart->total_items }}</span></span>
                                    <span class="font-bold text-gray-800" id="summary-subtotal">{{ number_format($cart->total) }} ₫</span>
                                </div>
                                
                                <div class="flex justify-between items-center text-lg">
                                    <span class="font-semibold text-gray-700">Giảm giá:</span>
                                    <span class="font-bold text-green-600" id="summary-discount">0 ₫</span>
                                </div>
                                
                                <div class="flex justify-between items-center text-lg">
                                    <span class="font-semibold text-gray-700">Phí vận chuyển:</span>
                                    <span class="font-bold text-green-600">Miễn phí</span>
                                </div>
                                
                                <hr class="border-gray-300">
                                
                                <div class="flex justify-between items-center text-xl">
                                    <span class="font-bold text-gray-800">Tổng cộng:</span>
                                    <span class="font-bold text-green-600 text-2xl" id="summary-total">{{ number_format($cart->total) }} ₫</span>
                                </div>
                            </div>

                            <hr class="border-gray-300 my-6">

                            <!-- Payment Method -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-4">Hình thức thanh toán</h3>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="payment" value="cod" checked class="mr-3 text-green-600 focus:ring-green-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                                            <span class="font-medium">Thanh toán COD</span>
                                        </div>
                                    </label>
                                    
                                    <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="payment" value="online" class="mr-3 text-green-600 focus:ring-green-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-credit-card text-blue-600 mr-2"></i>
                                            <span class="font-medium">Thanh toán qua Visa / Mastercard</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Card Details (Hidden by default) -->
                            <div id="card-details" class="hidden mb-6 p-4 bg-white rounded-lg border border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-700 mb-4">Thông tin thẻ</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên chủ thẻ</label>
                                        <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Nhập tên chủ thẻ">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Số thẻ</label>
                                        <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="1234 5678 9012 3456">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Ngày hết hạn</label>
                                            <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="MM/YY">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                            <input type="text" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="123">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <button class="w-full bg-green-600 text-white font-bold text-lg py-4 rounded-lg hover:bg-green-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <i class="fas fa-credit-card mr-2"></i>
                                Thanh toán ngay
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cart JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Payment method toggle
            const paymentInputs = document.querySelectorAll('input[name="payment"]');
            const cardDetails = document.getElementById('card-details');
            
            paymentInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value === 'online') {
                        cardDetails.classList.remove('hidden');
                    } else {
                        cardDetails.classList.add('hidden');
                    }
                });
            });

            // Quantity buttons
            document.querySelectorAll('.quantity-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const action = this.dataset.action;
                    const input = document.querySelector(`input[data-product-id="${productId}"]`);
                    let quantity = parseInt(input.value);

                    if (action === 'increase') {
                        quantity++;
                    } else if (action === 'decrease' && quantity > 1) {
                        quantity--;
                    }

                    input.value = quantity;
                    updateCartItem(productId, quantity);
                });
            });

            // Quantity input change
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.dataset.productId;
                    const quantity = Math.max(1, parseInt(this.value) || 1);
                    this.value = quantity;
                    updateCartItem(productId, quantity);
                });
            });

            // Remove item buttons
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    removeCartItem(productId);
                });
            });

            // AJAX functions
            function updateCartItem(productId, quantity) {
                fetch('{{ route("cart.update") }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartDisplay(data);
                        showNotification(data.message, 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Có lỗi xảy ra!', 'error');
                });
            }

            function removeCartItem(productId) {
                if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) return;

                fetch('{{ route("cart.remove") }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[data-product-id="${productId}"]`).remove();
                        updateCartDisplay(data);
                        showNotification(data.message, 'success');
                        
                        // Check if cart is empty
                        if (data.cart_count === 0) {
                            location.reload();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Có lỗi xảy ra!', 'error');
                });
            }

            function updateCartDisplay(data) {
                document.getElementById('cart-count').textContent = `${data.cart_count} món đồ`;
                document.getElementById('summary-count').textContent = data.cart_count;
                document.getElementById('summary-subtotal').textContent = `${data.cart_total} ₫`;
                document.getElementById('summary-total').textContent = `${data.cart_total} ₫`;
            }

            function showNotification(message, type) {
                // Simple notification - you can enhance this
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                }`;
                notification.textContent = message;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });
    </script>
</x-layout>