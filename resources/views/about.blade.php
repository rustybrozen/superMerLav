<x-layout>
    <div class="max-w-7xl mx-auto px-4 py-12 space-y-16">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="order-2 md:order-1 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Chào Mừng Đến Với Siêu Thị Của Chúng Tôi</h1>
                <p class="text-gray-600 leading-relaxed">
                    Khám phá các sản phẩm chất lượng cao với giá cả phải chăng. Chúng tôi cung cấp đa dạng thực phẩm tươi sống, hàng tiêu dùng và nhu yếu phẩm hàng ngày cho gia đình bạn.
                </p>
            </div>
            <div class="order-1 md:order-2 flex justify-center">
                <img src="https://i.pinimg.com/originals/f3/e5/70/f3e570ab505ac1ba962e6004a0c36e5d.jpg" 
                     alt="Siêu Thị Nhỏ" 
                     class="rounded-lg shadow-sm max-w-full">
            </div>
        </div>

        <div>
            <h2 class="text-center text-2xl font-bold text-gray-900 mb-8">Câu Chuyện Của Chúng Tôi</h2>
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <p class="text-gray-600 mb-4">
                    Tại <strong>Siêu Thị Nhỏ</strong>, chúng tôi tin vào việc mang đến những sản phẩm an toàn, tươi ngon và đảm bảo chất lượng cho khách hàng. Từ những ngày đầu, chúng tôi đã phục vụ cộng đồng với niềm đam mê và sự tận tâm.
                </p>
                <p class="text-gray-600">
                    Với sự phát triển của mình, chúng tôi đã trở thành một địa điểm tin cậy, cung cấp đầy đủ mọi sản phẩm gia đình bạn cần từ rau củ, thịt cá đến các nhu yếu phẩm hàng ngày. Sứ mệnh của chúng tôi là cung cấp những sản phẩm chất lượng, đáp ứng nhu cầu thiết yếu hàng ngày của mọi gia đình.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="flex justify-center">
                <img src="https://th.bing.com/th/id/R.7ac9c9a30557369479700e7769dc0ce2?rik=ausa7rLNY8aHqw&pid=ImgRaw&r=0" 
                     alt="Sản Phẩm Tươi Ngon" 
                     class="rounded-lg shadow-sm max-w-full">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center md:text-left">Chúng Tôi Cung Cấp Gì</h2>
                <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                    <li>Thực phẩm tươi sống: Rau củ, trái cây, thịt và hải sản</li>
                    <li>Đồ gia dụng và nhu yếu phẩm hàng ngày</li>
                    <li>Thực phẩm đóng hộp và các món ăn nhẹ</li>
                    <li>Sản phẩm dành cho trẻ em và đồ dùng vệ sinh</li>
                </ul>
                <p class="text-gray-600">
                    Tất cả sản phẩm đều được chọn lọc kỹ lưỡng để đảm bảo bạn nhận được sự hài lòng cao nhất. Chúng tôi cam kết cung cấp sản phẩm chất lượng với giá cả hợp lý.
                </p>
            </div>
        </div>

        <div>
            <h2 class="text-center text-2xl font-bold text-gray-900 mb-8">Giá Trị Của Chúng Tôi</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center">
                    <h4 class="text-green-700 font-semibold mb-3">Chất Lượng</h4>
                    <p class="text-gray-600">
                        Chúng tôi cam kết mang đến những sản phẩm tốt nhất cho khách hàng, từ thực phẩm tươi sạch đến hàng tiêu dùng chất lượng cao.
                    </p>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center">
                    <h4 class="text-green-700 font-semibold mb-3">Giá Trị</h4>
                    <p class="text-gray-600">
                        Chúng tôi tin vào việc mang đến sản phẩm với mức giá hợp lý, đảm bảo khách hàng luôn nhận được giá trị tốt nhất cho từng đồng chi tiêu.
                    </p>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center">
                    <h4 class="text-green-700 font-semibold mb-3">Cộng Đồng</h4>
                    <p class="text-gray-600">
                        Chúng tôi xem khách hàng như những người bạn đồng hành, cùng nhau xây dựng cộng đồng phát triển và bền vững.
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Tham Gia Cùng Chúng Tôi</h2>
            <p class="text-gray-600 mb-6">
                Hãy đến và trải nghiệm mua sắm tại siêu thị của chúng tôi. Chúng tôi luôn sẵn sàng phục vụ bạn với những sản phẩm tươi ngon và dịch vụ tận tâm.
            </p>
            <a href="{{ route('shop') }}" 
               class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                Mua Ngay
            </a>
        </div>

    </div>
</x-layout>
