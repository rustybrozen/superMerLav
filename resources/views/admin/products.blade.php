<x-a-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Quản Lý Sản Phẩm</h1>
            <div class="text-sm text-gray-500">
                <i class="fas fa-clock mr-1"></i>
                Cập nhật lúc {{ now()->format('H:i d/m/Y') }}
            </div>
        </div>

        @if (session('ok'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>{{ session('ok') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm mb-10">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Thêm Sản Phẩm</h2>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                class="grid md:grid-cols-2 gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên sản phẩm</label>
                    <input name="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                        required value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                    <select name="category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">—</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả ngắn</label>
                    <input name="short_desc" class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                        value="{{ old('short_desc') }}">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả chi tiết</label>
                    <textarea name="long_desc" class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="3">{{ old('long_desc') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Giá bán</label>
                    <input name="price" type="number" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg" required value="{{ old('price') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Giá nhập</label>
                    <input name="in_price" type="number" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ old('in_price') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Số lượng</label>
                    <input name="quantity" type="number" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg" required
                        value="{{ old('quantity', 0) }}">
                </div>
                <div class="flex items-center gap-4">
                    <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="is_active"
                            value="1" checked> Hoạt động</label>
                    <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" name="hot"
                            value="1"> Nổi bật</label>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh (tối đa 5)</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full">
                    @error('images')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Ảnh đầu tiên sẽ là ảnh chính</p>
                </div>
                <div class="md:col-span-2">
                    <button
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">Tạo
                        mới</button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ảnh chính</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thông tin</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Danh mục</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Giá</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">SL</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $p)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">{{ $p->id }}</td>
                                <td class="px-4 py-3">
                                    <img src="{{ $p->image ? asset('storage/' . $p->image) : asset('storage/default.jpg') }}"
                                        onerror="this.onerror=null;this.src='{{ asset('storage/' . 'default.jpg') }}"
                                        class="h-12 w-12 object-cover rounded">
                                </td>
                                <td class="px-4 py-3 w-[320px]">
                                    <form action="{{ route('admin.products.update', $p) }}" method="POST"
                                        enctype="multipart/form-data" class="space-y-2">
                                        @csrf
                                        @method('PATCH')
                                        <input name="name" class="w-full px-2 py-1 border border-gray-300 rounded"
                                            value="{{ old('name', $p->name) }}" required>
                                        <input name="short_desc" class="w-full px-2 py-1 border border-gray-300 rounded"
                                            value="{{ old('short_desc', $p->short_desc) }}" placeholder="Mô tả ngắn">
                                        <textarea name="long_desc" class="w-full px-2 py-1 border border-gray-300 rounded" rows="2"
                                            placeholder="Mô tả chi tiết">{{ old('long_desc', $p->long_desc) }}</textarea>
                                        <div class="grid grid-cols-3 gap-2">
                                            <div>
                                                <label class="text-xs">Giá</label>
                                                <input name="price" type="number" min="0"
                                                    class="w-full px-2 py-1 border border-gray-300 rounded"
                                                    value="{{ old('price', $p->price) }}" required>
                                            </div>
                                            <div>
                                                <label class="text-xs">Giá nhập</label>
                                                <input name="in_price" type="number" min="0"
                                                    class="w-full px-2 py-1 border border-gray-300 rounded"
                                                    value="{{ old('in_price', $p->in_price) }}">
                                            </div>
                                            <div>
                                                <label class="text-xs">SL</label>
                                                <input name="quantity" type="number" min="0"
                                                    class="w-full px-2 py-1 border border-gray-300 rounded"
                                                    value="{{ old('quantity', $p->quantity) }}">
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 text-sm">
                                            <label class="inline-flex items-center gap-1"><input type="checkbox"
                                                    name="is_active" value="1"
                                                    {{ $p->is_active ? 'checked' : '' }}> Hoạt động</label>
                                            <label class="inline-flex items-center gap-1"><input type="checkbox"
                                                    name="hot" value="1" {{ $p->hot ? 'checked' : '' }}> Nổi
                                                bật</label>
                                        </div>
                                        <div class="border border-gray-200 rounded p-2">
                                            <div class="text-xs font-semibold mb-1">Hình ảnh
                                                ({{ $p->images->count() }}/5)
                                            </div>
                                            <div class="flex flex-wrap gap-3">
                                                @foreach ($p->images as $img)
                                                    <label class="inline-flex flex-col items-center gap-1 text-xs">
                                                        <img src="{{ asset('storage/' . $img->image_path) }}"
                                                            onerror="this.onerror=null;this.src='{{ asset('storage/' . 'default.jpg') }}"
                                                            class="h-16 w-16 object-cover rounded">

                                                        <span class="flex items-center gap-1">
                                                            <input type="checkbox" name="remove_image_ids[]"
                                                                value="{{ $img->id }}">
                                                            <span>Xóa</span>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            <div class="mt-2">
                                                <label class="text-xs text-gray-600">Thêm ảnh</label>
                                                <input type="file" name="images[]" multiple accept="image/*">
                                            </div>
                                        </div>
                                        <button
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs">Lưu</button>

                                </td>
                                <td class="px-4 py-3">
                                    <select name="category_id"
                                        class="px-2 py-1 border border-gray-300 rounded w-full">
                                        <option value="">— Không chọn —</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('category_id', $p->category_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                </form>
                                <td class="px-4 py-3 whitespace-nowrap">{{ number_format($p->price) }}₫</td>
                                <td class="px-4 py-3">{{ $p->quantity }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $p->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $p->is_active ? 'Hoạt động' : 'Ngưng' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.products.toggle', $p) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="px-3 py-1 rounded text-xs {{ $p->is_active ? 'bg-yellow-600 hover:bg-yellow-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                                            {{ $p->is_active ? 'Ngưng' : 'Kích hoạt' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-lg font-medium">Chưa có sản phẩm nào</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-a-layout>
