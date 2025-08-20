<x-layout :title="'Chi tiết sản phẩm'">
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container mx-auto px-4 max-w-7xl">


            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">

               
                    <div class="space-y-4">
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden shadow-md">
                            <img src="{{ asset('storage/'.$product->images->first()->image_path ?? 'default.jpg') }}"
                             onerror="this.onerror=null;this.src='{{ asset('storage/' . 'default.jpg') }}';"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                id="mainProductImage">
                        </div>

                        @if ($product->images->count() > 1)
                            <div class="flex space-x-3 overflow-x-auto pb-2">
                                @foreach ($product->images as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}"
                                     onerror="this.onerror=null;this.src='{{ asset('storage/' . 'default.jpg') }}';"
                                        class="w-16 h-16 rounded-lg object-cover cursor-pointer ring-2 ring-transparent hover:ring-green-300 opacity-75 hover:opacity-100 transition-all flex-shrink-0"
                                        onclick="changeMainImage('{{ asset($image->image_path) }}')">
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Product Information Section --}}
                    <div class="space-y-6">
                        {{-- Breadcrumb --}}
                        <nav class="flex text-sm text-gray-500">
                            <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors">Trang chủ</a>
                            <span class="mx-2">/</span>
                            <span class="text-green-600 font-medium">{{ $product->category->name ?? 'Khác' }}</span>
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
                            {{ $product->category->name ?? 'Khác' }}
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


                                </form>

  <form action="{{ route('cart.buy') }}" method="POST" class="contents">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            class="flex-1 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl">
                                            <i class="fas fa-bolt"></i>
                                            <span>Mua ngay</span>
                                        </button>
                                    </form>


                                </div>
                           
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

            </div>
        </div>


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

                            alert.classList.remove('hidden');

                            addToCartButton.disabled = true;
                            addToCartButton.classList.add('disabled:opacity-25');




                            setTimeout(() => {
                                alert.classList.add('hidden');
                                addToCartButton.disabled = false;

                                addToCartButton.classList.remove('disabled:opacity-25');

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


        </script>
</x-layout>
