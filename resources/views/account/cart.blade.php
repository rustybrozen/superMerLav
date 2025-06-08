<x-layout :title="'Giỏ Hàng'">
    <meta name="user-authenticated" content="{{ auth()->check() ? 'true' : 'false' }}">
    @if (auth()->check())
        <meta name="full-name" content="{{ auth()->user()->fullname }}">
        <meta name="user-email" content="{{ auth()->user()->email }}">
        <meta name="user-phone" content="{{ auth()->user()->phone ?? '' }}">
        <meta name="user-address" content="{{ auth()->user()->address ?? '' }}">
    @endif
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">

                @if (!$cart || $cartItems->isEmpty())
                    <div class="text-center py-16">
                        <div class="mb-8">
                            <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                            <h1 class="text-3xl font-bold text-gray-800 mb-4">Giỏ hàng trống</h1>
                            <p class="text-gray-600 mb-6">Chưa có sản phẩm nào trong giỏ hàng của bạn</p>
                        </div>
                        <a href="{{ route('shop') }}"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
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
                                <span class="text-lg text-gray-600 font-medium" id="cart-count">{{ $cart->total_items }}
                                    món đồ</span>
                            </div>

                            <hr class="border-gray-200 mb-8">

                            <!-- Cart Items -->
                            <div class="space-y-6" id="cart-items">
                                @foreach ($cartItems as $item)
                                    <div class="flex flex-col md:flex-row items-center gap-4 p-4 bg-gray-50 rounded-lg cart-item"
                                        data-product-id="{{ $item->product_id }}">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/120x120' }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-20 h-20 md:w-24 md:h-24 object-cover rounded-lg shadow-sm">
                                        </div>

                                        <div class="flex-1 text-center md:text-left space-y-2">
                                            <p class="text-sm text-gray-500 font-medium">
                                                {{ $item->product->category->name ?? 'Sản phẩm' }}</p>
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}
                                            </h3>
                                            <p class="text-green-600 font-bold">
                                                {{ number_format($item->price_at_add) }}
                                                ₫</p>

                                            @if ($item->price_changed)
                                                <div class="text-xs text-orange-600">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Giá đã thay đổi: {{ number_format($item->product->price) }} ₫
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button
                                                    class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors quantity-btn"
                                                    data-action="decrease" data-product-id="{{ $item->product_id }}">
                                                    <i class="fas fa-minus text-sm"></i>
                                                </button>
                                                <input type="number" value="{{ $item->quantity }}" min="1"
                                                    class="w-16 text-center border-0 focus:ring-0 focus:outline-none bg-transparent quantity-input"
                                                    data-product-id="{{ $item->product_id }}">
                                                <button
                                                    class="px-3 py-2 text-gray-600 hover:bg-gray-100 transition-colors quantity-btn"
                                                    data-action="increase" data-product-id="{{ $item->product_id }}">
                                                    <i class="fas fa-plus text-sm"></i>
                                                </button>
                                            </div>

                                            <div class="text-right">
                                                <p class="text-lg font-bold text-gray-800 item-subtotal">
                                                    {{ number_format($item->subtotal) }} ₫</p>
                                            </div>

                                            <button
                                                class="text-red-500 hover:text-red-700 transition-colors p-2 remove-item"
                                                data-product-id="{{ $item->product_id }}">
                                                <i class="fas fa-trash text-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Continue Shopping -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <a href="{{ route('shop') }}"
                                    class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold transition-colors">
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
                                <select
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="express">Giao hàng hỏa tốc - Miễn phí</option>
                                </select>
                            </div>

                            <!-- Delivery Address -->
                            <!-- Delivery Address -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-3">Thông tin giao hàng</h3>

                                @auth
                                    <!-- Authenticated User - Read Only Display -->
                                    <div class="space-y-4">
                                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                            <div class="flex items-center text-blue-700 mb-3">
                                                <i class="fas fa-user mr-2"></i>
                                                <span class="font-medium">Thông tin của bạn:</span>
                                            </div>

                                            <div class="space-y-2 text-gray-700">
                                                <div class="flex items-start">
                                                    <i class="fas fa-map-marker-alt mr-2 mt-1 text-gray-500"></i>
                                                    <div>
                                                        <span class="font-medium">Địa chỉ:</span>
                                                        <p class="mt-1">
                                                            {{ auth()->user()->address ?? 'Chưa có địa chỉ được lưu' }}</p>
                                                    </div>
                                                </div>

                                                <div class="flex items-center">
                                                    <i class="fas fa-phone mr-2 text-gray-500"></i>
                                                    <span class="font-medium">SĐT:</span>
                                                    <span
                                                        class="ml-2">{{ auth()->user()->phone ?? 'Chưa có số điện thoại' }}</span>
                                                </div>

                                                <div class="flex items-center">
                                                    <i class="fas fa-envelope mr-2 text-gray-500"></i>
                                                    <span class="font-medium">Email:</span>
                                                    <span
                                                        class="ml-2">{{ auth()->user()->email ?? 'Chưa có email' }}</span>
                                                </div>
                                            </div>

                                            <div class="mt-3 pt-3 border-t border-blue-200">
                                                <a href="{{ route('profile.show') }}"
                                                    class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Chỉnh sửa trong hồ sơ cá nhân
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Guest User - Editable Form -->
                                    <div class="space-y-4">
                                        <div class="p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                            <div class="flex items-center text-orange-700 mb-2">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                <span class="font-medium">Người dùng là khách</span>
                                            </div>
                                            <p class="text-gray-700 text-sm">Vui lòng nhập đầy đủ thông tin để chúng tôi có
                                                thể liên hệ và giao hàng</p>
                                        </div>

                                        <form id="guest-info-form" class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-user mr-1"></i>
                                                    Họ và tên *
                                                </label>
                                                <input type="text" id="guest-full-name-input" required
                                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                    placeholder="Nhập họ và tên của bạn...">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-envelope mr-1"></i>
                                                    Email *
                                                </label>
                                                <input type="email" id="guest-email-input" required
                                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                    placeholder="Nhập email của bạn...">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-phone mr-1"></i>
                                                    Số điện thoại *
                                                </label>
                                                <input type="tel" id="guest-phone-input" required
                                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                    placeholder="Nhập số điện thoại...">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    Địa chỉ giao hàng *
                                                </label>
                                                <textarea rows="3" id="guest-address-input" required
                                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"
                                                    placeholder="Nhập địa chỉ giao hàng chi tiết..."></textarea>
                                            </div>

                                            <button type="submit"
                                                class="w-full px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                                <i class="fas fa-save mr-2"></i>
                                                Lưu thông tin giao hàng
                                            </button>
                                        </form>

                                        <!-- Current saved info display for guests -->
                                        <div id="guest-info-display" class="hidden space-y-3">
                                            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                                <div class="flex items-center text-green-700 mb-3">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    <span class="font-medium">Thông tin đã lưu:</span>
                                                </div>

                                                <div class="space-y-2 text-gray-700 text-sm">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-envelope mr-2 text-gray-500"></i>
                                                        <span class="font-medium">Email:</span>
                                                        <span class="ml-2" id="current-guest-email"></span>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <i class="fas fa-phone mr-2 text-gray-500"></i>
                                                        <span class="font-medium">SĐT:</span>
                                                        <span class="ml-2" id="current-guest-phone"></span>
                                                    </div>

                                                    <div class="flex items-start">
                                                        <i class="fas fa-map-marker-alt mr-2 mt-1 text-gray-500"></i>
                                                        <div>
                                                            <span class="font-medium">Địa chỉ:</span>
                                                            <p class="mt-1" id="current-guest-address"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" id="edit-guest-info"
                                                    class="mt-3 inline-flex items-center text-green-600 hover:text-green-700 font-medium text-sm">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Chỉnh sửa thông tin
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endauth
                            </div>

                            <!-- Voucher Code -->
                            {{-- <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-3">Mã giảm giá</h3>
                                <form class="space-y-3" id="voucher-form">
                                    <input type="text"
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        placeholder="Nhập mã giảm giá" id="voucher-input">
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                        Áp dụng
                                    </button>
                                </form>
                                <div class="hidden mt-2 p-2 bg-green-100 text-green-700 rounded text-sm font-medium"
                                    id="voucher-success">
                                    ✓ Áp dụng mã giảm giá thành công!
                                </div>
                            </div> --}}

                            <hr class="border-gray-300 my-6">

                            <!-- Order Summary -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center text-lg">
                                    <span class="font-semibold text-gray-700">Sản phẩm: <span
                                            id="summary-count">{{ $cart->total_items }}</span></span>
                                    <span class="font-bold text-gray-800"
                                        id="summary-subtotal">{{ number_format($cart->total) }} ₫</span>
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
                                    <span class="font-bold text-green-600 text-2xl"
                                        id="summary-total">{{ number_format($cart->total) }} ₫</span>
                                </div>
                            </div>

                            <hr class="border-gray-300 my-6">

                            <!-- Payment Method -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-700 mb-4">Hình thức thanh toán</h3>
                                <div class="space-y-3">
                                    <label
                                        class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="payment" value="cod" checked
                                            class="mr-3 text-green-600 focus:ring-green-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                                            <span class="font-medium">Thanh toán COD</span>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="payment" value="online"
                                            class="mr-3 text-green-600 focus:ring-green-500">
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
                                        <input type="text"
                                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                            placeholder="Nhập tên chủ thẻ">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Số thẻ</label>
                                        <input type="text"
                                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                            placeholder="1234 5678 9012 3456">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Ngày hết
                                                hạn</label>
                                            <input type="text"
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                placeholder="MM/YY">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                            <input type="text"
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                placeholder="123">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <button
                                class="w-full bg-green-600 text-white font-bold text-lg py-4 rounded-lg hover:bg-green-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <i class="fas fa-credit-card mr-2"></i>
                                Thanh toán ngay
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {


            const paymentInputs = document.querySelectorAll('input[name="payment"]');
            const cardDetails = document.getElementById('card-details');
            const guestInfoForm = document.getElementById('guest-info-form');
            const editGuestInfoBtn = document.getElementById('edit-guest-info');
            const checkoutBtn = document.querySelector('.w-full.bg-green-600');



            if (guestInfoForm) {
                guestInfoForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    updateGuestInfo();
                });
            }

            if (editGuestInfoBtn) {
                editGuestInfoBtn.addEventListener('click', function() {
                    showEditForm();
                });
            }

            const isGuest = !document.querySelector('meta[name="user-authenticated"]');
            const isAuth = document.querySelector('meta[name="user-authenticated"]');
            if (isGuest) {
                loadGuestInfo();
            }

            paymentInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value === 'online') {
                        cardDetails.classList.remove('hidden');
                    } else {
                        cardDetails.classList.add('hidden');
                    }
                });
            });

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

            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const productId = this.dataset.productId;
                    const quantity = Math.max(1, parseInt(this.value) || 1);
                    this.value = quantity;
                    updateCartItem(productId, quantity);
                });
            });

            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    removeCartItem(productId);
                });
            });


            checkoutBtn.addEventListener('click', function(e) {
                e.preventDefault();

                processCheckout();
            });



            function updateGuestInfo() {
                const emailInput = document.querySelector('#guest-email-input');
                const phoneInput = document.querySelector('#guest-phone-input');
                const addressInput = document.querySelector('#guest-address-input');
                const fullNameInput = document.querySelector('#guest-full-name-input');

                if (!emailInput || !phoneInput || !addressInput || !fullNameInput) {
                    console.error('Missing input elements');
                    showNotification('Không tìm thấy các trường nhập liệu!', 'error');
                    return;
                }

                const email = emailInput.value ? emailInput.value.trim() : '';
                const phone = phoneInput.value ? phoneInput.value.trim() : '';
                const address = addressInput.value ? addressInput.value.trim() : '';
                const fullName = fullNameInput.value ? fullNameInput.value.trim() : '';

                console.log('Input values:', {
                    email,
                    phone,
                    address,
                    fullName
                });

                if (!email || !phone || !address || !fullName) {
                    console.log('Validation failed - empty fields');
                    showNotification('Vui lòng nhập đầy đủ thông tin!', 'error');
                    return;
                }

                if (!isValidEmail(email)) {
                    showNotification('Email không hợp lệ!', 'error');
                    return;
                }

                if (!isValidPhone(phone)) {
                    showNotification('Số điện thoại không hợp lệ!', 'error');
                    return;
                }

                const submitBtnInfo = guestInfoForm.querySelector('button[type="submit"]');
                const originalText = submitBtnInfo.innerHTML; // 🎯 Fixed: Use submitBtnInfo instead of submitBtn
                submitBtnInfo.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang lưu...';
                submitBtnInfo.disabled = true;

                const dataToSend = {
                    email: email,
                    phone: phone,
                    address: address,
                    fullname: fullName
                };

                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    showNotification('Lỗi bảo mật, vui lòng tải lại trang!', 'error');
                    submitBtnInfo.innerHTML = originalText;
                    submitBtnInfo.disabled = false;
                    return;
                }

                fetch('/cart/guest-info', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        },
                        body: JSON.stringify(dataToSend)
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            showNotification(data.message, 'success');
                            showGuestInfo(data.data);
                            hideEditForm();
                        } else {
                            showNotification(data.message || 'Có lỗi xảy ra!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Có lỗi xảy ra khi lưu thông tin!', 'error');
                    })
                    .finally(() => {
                        submitBtnInfo.innerHTML = originalText;
                        submitBtnInfo.disabled = false;
                    });
            }

            function loadGuestInfo() {
                fetch('/cart/guest-info')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && !data.user_authenticated) {
                            const {
                                email,
                                phone,
                                address,
                                fullname
                            } = data.data;
                            if (email && phone && address && fullname) {
                                const emailInput = document.getElementById('guest-email-input');
                                const phoneInput = document.getElementById('guest-phone-input');
                                const addressInput = document.getElementById('guest-address-input');
                                const fullNameInput = document.getElementById('guest-full-name-input');

                                if (emailInput) emailInput.value = email;
                                if (phoneInput) phoneInput.value = phone;
                                if (addressInput) addressInput.value = address;
                                if (fullNameInput) fullNameInput.value = fullname;

                                showGuestInfo(data.data);
                                hideEditForm();
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error loading guest info:', error);
                    });
            }

            function showGuestInfo(data) {
                const guestInfoDisplay = document.getElementById('guest-info-display');
                const currentEmail = document.getElementById('current-guest-email');
                const currentPhone = document.getElementById('current-guest-phone');
                const currentAddress = document.getElementById('current-guest-address');
                const currentFullName = document.getElementById('guest-full-name-input');
                if (guestInfoDisplay && currentEmail && currentPhone && currentAddress && currentFullName) {
                    currentEmail.textContent = data.email;
                    currentPhone.textContent = data.phone;
                    currentAddress.textContent = data.address;
                    currentFullName.textContent = data.fullname;
                    guestInfoDisplay.classList.remove('hidden');
                }
            }

            function showEditForm() {
                const form = document.getElementById('guest-info-form');
                const display = document.getElementById('guest-info-display');

                if (form && display) {
                    form.classList.remove('hidden');
                    display.classList.add('hidden');
                }
            }

            function hideEditForm() {
                const form = document.getElementById('guest-info-form');
                if (form) {
                    form.classList.add('hidden');
                }
            }

            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function isValidPhone(phone) {
                const phoneRegex = /^[0-9+\-\s()]{8,15}$/;
                return phoneRegex.test(phone);
            }

            function updateCartItem(productId, quantity) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');

                fetch('/cart/update', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const cartItem = document.querySelector(`[data-product-id="${productId}"]`);
                            const subtotalElement = cartItem.querySelector('.item-subtotal');
                            if (data.item_subtotal) {
                                subtotalElement.textContent = data.item_subtotal + ' ₫';
                            }
                            updateCartDisplay(data);
                            showNotification(data.message, 'success');
                        } else {
                            showNotification(data.message || 'Có lỗi xảy ra!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Có lỗi xảy ra!', 'error');
                    });
            }

            function removeCartItem(productId) {
                if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) return;

                const csrfToken = document.querySelector('meta[name="csrf-token"]');

                fetch('/cart/remove', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const cartItem = document.querySelector(`[data-product-id="${productId}"]`);
                            cartItem.remove();
                            updateCartDisplay(data);
                            showNotification(data.message, 'success');

                            if (data.cart_count === 0) {
                                location.reload();
                            }
                        } else {
                            showNotification(data.message || 'Có lỗi xảy ra!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Có lỗi xảy ra!', 'error');
                    });
            }

            function updateCartDisplay(data) {
                const cartCountElement = document.getElementById('cart-count');
                const summaryCountElement = document.getElementById('summary-count');
                const summarySubtotalElement = document.getElementById('summary-subtotal');
                const summaryTotalElement = document.getElementById('summary-total');

                if (cartCountElement) cartCountElement.textContent = `${data.cart_count} món đồ`;
                if (summaryCountElement) summaryCountElement.textContent = data.cart_count;
                if (summarySubtotalElement) summarySubtotalElement.textContent = `${data.cart_total} ₫`;
                if (summaryTotalElement) summaryTotalElement.textContent = `${data.cart_total} ₫`;
            }

            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
                notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 10);

                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 300);
                }, 3000);
            }

            async function processCheckout() {


                const originalText = checkoutBtn.innerHTML;

                checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang xử lý...';
                checkoutBtn.disabled = true;

                try {
                    console.log('Validating customer info...');
                    const customerInfo = await validateCustomerInfo();
                    if (!customerInfo.valid) {
                        showNotification(customerInfo.message, 'error');
                        return;
                    }

                    console.log('Validating payment method...');
                    const paymentInfo = validatePaymentMethod();
                    if (!paymentInfo.valid) {
                        showNotification(paymentInfo.message, 'error');
                        return;
                    }

                    console.log('Validating cart stock...');
                    const stockCheck = await validateCartStock();
                    if (!stockCheck.valid) {
                        showNotification(stockCheck.message, 'error');
                        if (stockCheck.cartUpdated) {
                            location.reload();
                        }
                        return;
                    }

                    console.log('Creating order...');
                    const orderData = {
                        customer_info: customerInfo.data,
                        payment_method: paymentInfo.method,
                        payment_details: paymentInfo.details
                    };

                    const order = await createOrder(orderData);

                    if (order.success) {
                        console.log('Order created successfully, redirecting...');
                        window.location.href = `/order/success/${order.order_id}`;
                    } else {
                        showNotification(order.message || 'Có lỗi xảy ra khi tạo đơn hàng!', 'error');
                    }

                } catch (error) {
                    console.error('Checkout error:', error);
                    showNotification('Có lỗi xảy ra trong quá trình thanh toán!', 'error');
                } finally {
                    checkoutBtn.innerHTML = originalText;
                    checkoutBtn.disabled = false;
                }
            }

            async function validateCustomerInfo() {
                try {
                    const userAuthenticatedMeta = document.querySelector('meta[name="user-authenticated"]');
                    const isAuthenticated = userAuthenticatedMeta && userAuthenticatedMeta.getAttribute(
                        'content') === 'true';

                    if (isAuthenticated) {
                        
                        const userNameMeta = document.querySelector('meta[name="full-name"]');
                        const userEmailMeta = document.querySelector('meta[name="user-email"]');
                        const userPhoneMeta = document.querySelector('meta[name="user-phone"]');
                        const userAddressMeta = document.querySelector('meta[name="user-address"]');

                        const userInfo = {
                            name: userNameMeta ? userNameMeta.getAttribute('content') : '',
                            email: userEmailMeta ? userEmailMeta.getAttribute('content') : '',
                            phone: userPhoneMeta ? userPhoneMeta.getAttribute('content') : '',
                            address: userAddressMeta ? userAddressMeta.getAttribute('content') : ''
                        };

                        // Check for missing required fields
                        if (!userInfo.name || !userInfo.email || !userInfo.phone || !userInfo.address) {
                            const missingFields = [];

                            if (!userInfo.name) missingFields.push('tên');
                            if (!userInfo.email) missingFields.push('email');
                            if (!userInfo.phone) missingFields.push('số điện thoại');
                            if (!userInfo.address) missingFields.push('địa chỉ');

                            return {
                                valid: false,
                                message: `Vui lòng cập nhật ${missingFields.join(', ')} trong hồ sơ cá nhân trước khi thanh toán!`
                            };
                        }

                        return {
                            valid: true,
                            data: userInfo
                        };
                    } else {
                        // Handle guest user info
                        try {
                            const emailInput = document.querySelector('#guest-email-input');
                            const phoneInput = document.querySelector('#guest-phone-input');
                            const addressInput = document.querySelector('#guest-address-input');
                            const fullNameInput = document.querySelector('#guest-full-name-input');
                            const csrfToken = document.querySelector('meta[name="csrf-token"]');

                            // Check if CSRF token exists
                            if (!csrfToken) {
                                return {
                                    valid: false,
                                    message: 'Không thể xác thực yêu cầu. Vui lòng tải lại trang!'
                                };
                            }

                            const response = await fetch('/cart/guest-info', {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                                },
                                body: JSON.stringify({
                                    fullname: fullNameInput?.value?.trim() || '',
                                    email: emailInput?.value?.trim() || '',
                                    phone: phoneInput?.value?.trim() || '',
                                    address: addressInput?.value?.trim() || ''
                                })
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }

                            const data = await response.json();

                            if (!data.success) {
                                return {
                                    valid: false,
                                    message: data.message || 'Có lỗi xảy ra khi lưu thông tin khách hàng!'
                                };
                            }

                            // Validate required fields from response
                            if (!data.data?.fullname || !data.data?.email || !data.data?.phone || !data.data
                                ?.address) {
                                const missingFields = [];

                                if (!data.data?.fullname) missingFields.push('họ tên');
                                if (!data.data?.email) missingFields.push('email');
                                if (!data.data?.phone) missingFields.push('số điện thoại');
                                if (!data.data?.address) missingFields.push('địa chỉ');

                                return {
                                    valid: false,
                                    message: `Vui lòng điền đầy đủ ${missingFields.join(', ')} trước khi thanh toán!`
                                };
                            }

                            return {
                                valid: true,
                                data: {
                                    name: data.data.fullname,
                                    email: data.data.email,
                                    phone: data.data.phone,
                                    address: data.data.address
                                }
                            };
                        } catch (error) {
                            console.error('Guest info validation error:', error);
                            return {
                                valid: false,
                                message: 'Không thể lấy thông tin khách hàng. Vui lòng kiểm tra kết nối và thử lại!'
                            };
                        }
                    }
                } catch (error) {
                    console.error('Customer validation error:', error);
                    return {
                        valid: false,
                        message: 'Có lỗi xảy ra khi kiểm tra thông tin khách hàng!'
                    };
                }
            }

            function validatePaymentMethod() {
                const selectedPayment = document.querySelector('input[name="payment"]:checked');

                if (!selectedPayment) {
                    return {
                        valid: false,
                        message: 'Vui lòng chọn phương thức thanh toán!'
                    };
                }

                const paymentMethod = selectedPayment.value;

                if (paymentMethod === 'online') {
                    const cardHolderInput = document.querySelector(
                        '#card-details input[placeholder="Nhập tên chủ thẻ"]');
                    const cardNumberInput = document.querySelector(
                        '#card-details input[placeholder="1234 5678 9012 3456"]');
                    const expiryDateInput = document.querySelector('#card-details input[placeholder="MM/YY"]');
                    const cvvInput = document.querySelector('#card-details input[placeholder="123"]');

                    const cardHolder = cardHolderInput ? cardHolderInput.value.trim() : '';
                    const cardNumber = cardNumberInput ? cardNumberInput.value.trim() : '';
                    const expiryDate = expiryDateInput ? expiryDateInput.value.trim() : '';
                    const cvv = cvvInput ? cvvInput.value.trim() : '';

                    if (!cardHolder || !cardNumber || !expiryDate || !cvv) {
                        return {
                            valid: false,
                            message: 'Vui lòng điền đầy đủ thông tin thẻ tín dụng!'
                        };
                    }

                    if (cardNumber.replace(/\s/g, '').length < 13) {
                        return {
                            valid: false,
                            message: 'Số thẻ không hợp lệ!'
                        };
                    }

                    if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
                        return {
                            valid: false,
                            message: 'Ngày hết hạn phải có định dạng MM/YY!'
                        };
                    }

                    if (!/^\d{3,4}$/.test(cvv)) {
                        return {
                            valid: false,
                            message: 'Mã CVV không hợp lệ!'
                        };
                    }

                    return {
                        valid: true,
                        method: 'online',
                        details: {
                            card_holder: cardHolder,
                            card_number: cardNumber.replace(/\s/g, '').substr(-4),
                            expiry_date: expiryDate
                        }
                    };
                }

                return {
                    valid: true,
                    method: 'cod',
                    details: null
                };
            }

            async function validateCartStock() {
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    const response = await fetch('/cart/validate-stock', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        }
                    });

                    console.log('Stock validation response:', response);
                    const data = await response.json();

                    if (!data.success) {
                        return {
                            valid: false,
                            message: data.message || 'Có lỗi xảy ra khi kiểm tra tồn kho!',
                            cartUpdated: data.cart_updated || false
                        };
                    }

                    return {
                        valid: true,
                        message: 'Tất cả sản phẩm đều có sẵn!'
                    };

                } catch (error) {
                    console.error('Stock validation error:', error);
                    return {
                        valid: false,
                        message: 'Không thể kiểm tra tồn kho. Vui lòng thử lại!'
                    };
                }
            }

            async function createOrder(orderData) {
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    const response = await fetch('/checkout/process', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        },
                        body: JSON.stringify(orderData)
                    });

                    const data = await response.json();
                    return data;

                } catch (error) {
                    console.error('Create order error:', error);
                    return {
                        success: false,
                        message: 'Có lỗi xảy ra khi tạo đơn hàng!'
                    };
                }
            }
        });
    </script>
</x-layout>
