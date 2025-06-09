{{-- resources/views/components/product-detail.blade.php --}}
<x-layout :title="'Chi tiết sản phẩm'">
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4 max-w-7xl">

            {{-- Main Product Section --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">

                    {{-- Product Images Section --}}
                    <div class="space-y-4">
                        {{-- Main Product Image --}}
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden shadow-md">
                            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=600&fit=crop"
                                alt="Fresh Organic Apples"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                id="mainProductImage">
                        </div>

                        {{-- Image Gallery Thumbnails --}}
                        <div class="flex space-x-3 overflow-x-auto pb-2">
                            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=150&h=150&fit=crop"
                                alt="Apple Image 1"
                                class="w-16 h-16 rounded-lg object-cover cursor-pointer ring-2 ring-green-500 opacity-100 hover:opacity-75 transition-opacity flex-shrink-0"
                                onclick="changeMainImage(this.src.replace('w=150&h=150', 'w=600&h=600'))">
                            <img src="https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?w=150&h=150&fit=crop"
                                alt="Apple Image 2"
                                class="w-16 h-16 rounded-lg object-cover cursor-pointer ring-2 ring-transparent hover:ring-green-300 opacity-75 hover:opacity-100 transition-all flex-shrink-0"
                                onclick="changeMainImage(this.src.replace('w=150&h=150', 'w=600&h=600'))">
                            <img src="https://images.unsplash.com/photo-1570913149827-d2ac84ab3f9a?w=150&h=150&fit=crop"
                                alt="Apple Image 3"
                                class="w-16 h-16 rounded-lg object-cover cursor-pointer ring-2 ring-transparent hover:ring-green-300 opacity-75 hover:opacity-100 transition-all flex-shrink-0"
                                onclick="changeMainImage(this.src.replace('w=150&h=150', 'w=600&h=600'))">
                        </div>
                    </div>

                    {{-- Product Information Section --}}
                    <div class="space-y-6">
                        {{-- Breadcrumb --}}
                        <nav class="flex text-sm text-gray-500">
                            <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors">Trang chủ</a>
                            <span class="mx-2">/</span>
                            <span class="text-green-600 font-medium">{{ $product->category->name }}</span>
                        </nav>

                        {{-- Product Title --}}
                        <h1 class="text-3xl font-bold text-green-700 leading-tight">
                            {{ $product->name }}
                        </h1>

                        {{-- Stock Information --}}
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600">Số lượng còn lại:</span>
                            <span
                                class="font-semibold text-gray-800 bg-gray-100 px-3 py-1 rounded-full">{{ $product->quantity }}</span>
                        </div>

                        {{-- Low Stock Warning --}}
                        {{-- Uncomment if stock is low --}}
                        {{-- <div class="bg-red-50 border-l-4 border-red-400 p-3 rounded">
              <p class="text-red-700 font-medium flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Sản phẩm sắp hết hàng
              </p>
            </div> --}}

                        {{-- Category --}}
                        <p class="text-gray-600 italic">
                            <i class="fas fa-tag mr-1"></i>
                            {{ $product->category->name }}
                        </p>

                        {{-- Price --}}
                        <div class="text-4xl font-bold text-green-600">
                            89.000 ₫
                        </div>

                        {{-- Short Description --}}
                        <p class="text-gray-700 leading-relaxed">
                            {{ $product->short_desc }}
                        </p>

                        {{-- Add to Cart Section --}}
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <form class="space-y-4">
                                <div class="flex items-center space-x-4">
                                    <label class="text-gray-700 font-medium">Số lượng:</label>
                                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                        <button type="button"
                                            class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors"
                                            onclick="decreaseQuantity()">
                                            <i class="fas fa-minus text-sm"></i>
                                        </button>
                                        <input type="number" id="quantityInput"
                                            class="w-16 text-center py-2 border-0 focus:ring-0 focus:outline-none"
                                            value="1" min="1" max="{{ $product->quantity }}">
                                        <button type="button"
                                            class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors"
                                            onclick="increaseQuantity()">
                                            <i class="fas fa-plus text-sm"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button id="add-to-cart-btn" type="button"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl"
                                        onclick="addToCart()">
                                        <i class="fas fa-cart-plus"></i>
                                        <span>Thêm vào giỏ hàng</span>
                                    </button>
                                    <button id="buy-now-btn" type="button"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl"
                                        onclick="buyNow()">
                                        <i class="fas fa-bolt"></i>
                                        <span>Mua ngay</span>
                                    </button>
                                </div>
                            </form>

                            {{-- Success Alert --}}
                            <div id="successAlert"
                                class="hidden mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <span>Sản phẩm đã được thêm vào giỏ hàng thành công!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Description --}}
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <h3 class="text-2xl font-bold text-green-700 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-3"></i>
                    Thông tin sản phẩm
                </h3>
                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-700 leading-relaxed text-lg">
                        {{ $product->long_desc }}
                    </p>
                    {{-- <p class="text-gray-700 leading-relaxed text-lg mt-4">
            <strong>Công dụng:</strong> Giàu vitamin C, chất xơ, giúp tăng cường hệ miễn dịch, 
            hỗ trợ tiêu hóa và duy trì sức khỏe tim mạch. Thích hợp cho mọi lứa tuổi.
          </p> --}}
                </div>
            </div>

            {{-- Review Form (Only for users who purchased) --}}
            {{-- <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <h3 class="text-2xl font-bold text-green-700 mb-6 text-center flex items-center justify-center">
          <i class="fas fa-star mr-3"></i>
          Hãy để lại đánh giá
        </h3>
        <form class="max-w-2xl mx-auto space-y-6">
        
          <div class="text-center">
            <div class="flex justify-center space-x-1 text-4xl">
              <input type="radio" name="rating" id="star5" value="5" class="hidden" required>
              <label for="star5" class="cursor-pointer text-gray-300 hover:text-yellow-400 transition-colors duration-200" onclick="setRating(5)">★</label>
              <input type="radio" name="rating" id="star4" value="4" class="hidden" required>
              <label for="star4" class="cursor-pointer text-gray-300 hover:text-yellow-400 transition-colors duration-200" onclick="setRating(4)">★</label>
              <input type="radio" name="rating" id="star3" value="3" class="hidden" required>
              <label for="star3" class="cursor-pointer text-gray-300 hover:text-yellow-400 transition-colors duration-200" onclick="setRating(3)">★</label>
              <input type="radio" name="rating" id="star2" value="2" class="hidden" required>
              <label for="star2" class="cursor-pointer text-gray-300 hover:text-yellow-400 transition-colors duration-200" onclick="setRating(2)">★</label>
              <input type="radio" name="rating" id="star1" value="1" class="hidden" required>
              <label for="star1" class="cursor-pointer text-gray-300 hover:text-yellow-400 transition-colors duration-200" onclick="setRating(1)">★</label>
            </div>
            <p class="text-gray-600 mt-2">Nhấp vào sao để đánh giá</p>
          </div>

         
          <div>
            <textarea 
              name="review_text" 
              rows="4" 
              maxlength="200"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none transition-all duration-200"
              placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."
              required
            ></textarea>
            <p class="text-sm text-gray-500 mt-1">Tối đa 200 ký tự</p>
          </div>

        
          <div class="text-center">
            <button 
              type="submit" 
              class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-8 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2 mx-auto"
            >
              <i class="fas fa-paper-plane"></i>
              <span>Gửi đánh giá</span>
            </button>
          </div>
        </form>
      </div> --}}

            {{-- Reviews Section --}}
            {{-- <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-2xl font-bold text-gray-800">Đánh giá khách hàng</h3>
          <div class="text-right">
            <p class="text-3xl font-bold text-yellow-500">4.8 ⭐</p>
            <p class="text-gray-600">Từ {{ $product->reviews->count() }} đánh giá</p>
          </div>
        </div>

     
        <div class="space-y-6">
      
          <div class="border-b border-gray-200 pb-6 last:border-b-0">
            <div class="flex items-start space-x-4">
              <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user text-green-600"></i>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between mb-2">
                  <h4 class="font-semibold text-gray-800">Nguyễn Văn An</h4>
                  <span class="text-sm text-gray-500">15-11-2024</span>
                </div>
                <div class="flex items-center mb-3">
                  <div class="flex text-yellow-400 text-lg">⭐⭐⭐⭐⭐</div>
                </div>
                <p class="text-gray-700 leading-relaxed">
                  Táo rất ngon, giòn và ngọt tự nhiên. Đóng gói cẩn thận, giao hàng nhanh. 
                  Sẽ mua lại lần sau!
                </p>
              </div>
            </div>
          </div>

   
          <div class="border-b border-gray-200 pb-6 last:border-b-0">
            <div class="flex items-start space-x-4">
              <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user text-pink-600"></i>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between mb-2">
                  <h4 class="font-semibold text-gray-800">Trần Thị Mai</h4>
                  <span class="text-sm text-gray-500">12-11-2024</span>
                </div>
                <div class="flex items-center mb-3">
                  <div class="flex text-yellow-400 text-lg">⭐⭐⭐⭐⭐</div>
                </div>
                <p class="text-gray-700 leading-relaxed">
                  Chất lượng táo tuyệt vời, ăn rất ngon và an toàn. 
                  Shop đóng gói kỹ càng, không bị dập nát gì cả.
                </p>
              </div>
            </div>
          </div>

      
          <div class="border-b border-gray-200 pb-6 last:border-b-0">
            <div class="flex items-start space-x-4">
              <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user text-blue-600"></i>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between mb-2">
                  <h4 class="font-semibold text-gray-800">Lê Hoàng Nam</h4>
                  <span class="text-sm text-gray-500">10-11-2024</span>
                </div>
                <div class="flex items-center mb-3">
                  <div class="flex text-yellow-400 text-lg">⭐⭐⭐⭐</div>
                </div>
                <p class="text-gray-700 leading-relaxed">
                  Táo tươi ngon, giá cả hợp lý. Giao hàng đúng hẹn. 
                  Chỉ tiếc là một vài quả hơi nhỏ so với mong đợi.
                </p>
              </div>
            </div>
          </div>
        </div>


        <div class="text-center mt-8">
          <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-lg transition-colors duration-200">
            Xem thêm đánh giá
          </button>
        </div>
      </div> --}}
        </div>
    </div>

    {{-- JavaScript for Interactive Features --}}
    <script>
        function changeMainImage(newSrc) {
            document.getElementById('mainProductImage').src = newSrc;


            document.querySelectorAll('.w-16.h-16').forEach(img => {
                img.className = img.className.replace('ring-green-500 opacity-100', 'ring-transparent opacity-75');
            });
            event.target.className = event.target.className.replace('ring-transparent opacity-75',
                'ring-green-500 opacity-100');
        }


        function increaseQuantity() {
            const input = document.getElementById('quantityInput');
            input.value = parseInt(input.value) + 1;
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantityInput');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }


        function setRating(rating) {
            const stars = document.querySelectorAll('label[for^="star"]');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });


            document.getElementById(`star${rating}`).checked = true;
        }


        function addToCart() {
            const productId = "{{ $product->id }}";
            const quantity = parseInt(document.getElementById('quantityInput').value);
          

            fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const alert = document.getElementById('successAlert');
                          const addToCartButton = document.getElementById('add-to-cart-btn');
            const buyNowButton = document.getElementById('buy-now-btn');
                        alert.classList.remove('hidden');

                        addToCartButton.disabled = true;
                        addToCartButton.classList.add('disabled:opacity-25');
                        buyNowButton.disabled = true;
                        buyNowButton.classList.add('disabled:opacity-25');

                     

                        setTimeout(() => {
                            alert.classList.add('hidden');
                            addToCartButton.disabled = false;
                            buyNowButton.disabled = false;
                            addToCartButton.classList.remove('disabled:opacity-25');
                            buyNowButton.classList.remove('disabled:opacity-25');
                        }, 3000);
                    } else {
                        alert('Có lỗi xảy ra khi thêm vào giỏ hàng!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Lỗi kết nối đến máy chủ!');
                });
        }


        function buyNow() {

            alert('Chức năng mua ngay - chuyển đến trang thanh toán');
        }
    </script>
</x-layout>
