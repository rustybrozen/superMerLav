<x-a-layout>
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Quản Lý Danh Mục</h1>
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

        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 shadow-sm">
            <h2 class="text-lg font-semibold mb-4">Thêm Danh Mục</h2>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên</label>
                    <input name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        required />
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh (tùy chọn)</label>
                    <input type="file" name="image" accept="image/*" class="w-full" />
                    @error('image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center gap-2">
                    <input id="is_active_create" type="checkbox" name="is_active" value="1" checked
                        class="rounded" />
                    <label for="is_active_create" class="text-sm">Kích hoạt</label>
                </div>
                <button
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">Tạo</button>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hình ảnh</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tên</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kích hoạt</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $cat)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap">{{ $cat->id }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if ($cat->image)
                                        <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}"
                                            class="h-12 w-12 object-cover rounded-lg border border-gray-200" />
                                    @else
                                        <span class="text-gray-400 italic">Không có</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <form action="{{ route('admin.categories.update', $cat) }}" method="POST"
                                        enctype="multipart/form-data" class="space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <input name="name" value="{{ old('name', $cat->name) }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                            required />
                                        <div class="flex items-center gap-2">
                                            <input id="is_active_{{ $cat->id }}" type="checkbox" name="is_active"
                                                value="1" {{ $cat->is_active ? 'checked' : '' }}
                                                class="rounded" />
                                            <label for="is_active_{{ $cat->id }}" class="text-sm">Kích
                                                hoạt</label>
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-1">Thay hình ảnh (tùy
                                                chọn)</label>
                                            <input type="file" name="image" accept="image/*" class="w-full" />
                                        </div>
                                        <button
                                            class="px-4 py-2 border border-green-600 text-green-600 hover:bg-green-600 hover:text-white rounded">Lưu</button>
                                    </form>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $cat->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $cat->is_active ? 'Có' : 'Không' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.categories.toggle', $cat) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors 
    {{ $cat->is_active
        ? 'border border-red-600 text-red-600 hover:bg-red-600 hover:text-white'
        : ' bg-green-600  hover:bg-green-700 text-white' }}">
                                            {{ $cat->is_active ? 'Tắt' : 'Bật' }}
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-folder-open text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-lg font-medium">Chưa có danh mục</p>
                                        <p class="text-sm">Không tìm thấy danh mục nào</p>
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
