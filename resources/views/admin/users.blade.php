<x-a-layout>
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Quản Lý Người Dùng</h1>
            <div class="text-sm text-gray-500">
                <i class="fas fa-clock mr-1"></i>
                Cập nhật lúc {{ now()->format('H:i d/m/Y') }}
            </div>
        </div>

        @if(session('ok'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>{{ session('ok') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 shadow-sm">
            <form method="GET" class="flex flex-col lg:flex-row lg:items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                    <input name="q" value="{{ $q ?? '' }}"
                        placeholder="Nhập username, tên, email, số điện thoại..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"/>
                </div>
                <div class="flex gap-3">
                    <button class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Tìm kiếm
                    </button>
                    @if(($q ?? '') !== '')
                        <a href="{{ route('admin.users.index') }}" 
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
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Họ tên</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SĐT</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vai trò</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tham gia</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $u)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap">{{ $u->id }}</td>
                                <td class="px-4 py-4 whitespace-nowrap font-medium text-gray-900">{{ $u->username }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $u->fullname ?? '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $u->phone ?? '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $u->email ?? '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $u->is_admin ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $u->is_admin ? 'Admin' : 'User' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $u->is_disabled ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $u->is_disabled ? 'Bị khóa' : 'Hoạt động' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $u->created_at?->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if(!$u->is_admin)
                                        <form action="{{ route('admin.users.toggle', $u) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="px-3 py-1 text-xs rounded {{ $u->is_disabled ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-yellow-500 hover:bg-yellow-600 text-white' }} transition-colors">
                                                {{ $u->is_disabled ? 'Mở khóa' : 'Khóa' }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-sm italic">Không thể chỉnh</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-user-slash text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-lg font-medium">Không có người dùng</p>
                                        <p class="text-sm">Không tìm thấy người dùng phù hợp với bộ lọc</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-a-layout>
