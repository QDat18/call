@extends('layouts.admin')

@section('title', 'User Management')
@section('breadcrumb', 'Users')

@section('content')
    {{-- AlpineJS Data --}}
    <div class="space-y-6" x-data="userManagement()">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">User Management</h2>
                <p class="text-gray-600 mt-1">Manage all users, volunteers, and organizations</p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <div class="flex bg-gray-100 rounded-lg p-1 border border-gray-200">
                    <button @click="viewMode = 'grid'" 
                            :class="{ 'bg-white text-indigo-600 shadow-sm': viewMode === 'grid', 'text-gray-500 hover:text-gray-700': viewMode !== 'grid' }"
                            class="px-3 py-1.5 rounded-md text-sm font-medium transition-all flex items-center">
                        <i class="fas fa-th-large mr-2"></i> Grid
                    </button>
                    <button @click="viewMode = 'list'" 
                            :class="{ 'bg-white text-indigo-600 shadow-sm': viewMode === 'list', 'text-gray-500 hover:text-gray-700': viewMode !== 'list' }"
                            class="px-3 py-1.5 rounded-md text-sm font-medium transition-all flex items-center">
                        <i class="fas fa-list mr-2"></i> List
                    </button>
                </div>

                <button @click="emailSelected()" x-show="selected.length > 0" x-cloak
                        class="px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition flex items-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Email (<span x-text="selected.length"></span>)
                </button>

                <button @click="exportSelected()" 
                        class="px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg hover:bg-green-100 transition flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    <span x-text="selected.length > 0 ? 'Export (' + selected.length + ')' : 'Export All'"></span>
                </button>
                
                <a href="{{ route('admin.users.create') }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i>Add User
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Search by name, email...">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="user_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">All Types</option>
                        <option value="Volunteer" {{ request('user_type') == 'Volunteer' ? 'selected' : '' }}>Volunteer</option>
                        <option value="Organization" {{ request('user_type') == 'Organization' ? 'selected' : '' }}>Organization</option>
                        <option value="Admin" {{ request('user_type') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="md:col-span-4 flex justify-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-filter mr-2"></i>Apply
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Reset</a>
                </div>
            </form>
        </div>

        <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($users as $user)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition relative group">
                    <div class="absolute top-3 right-3 z-10">
                        <input type="checkbox" value="{{ $user->user_id }}" x-model="selected" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    </div>

                    <div class="p-6 text-center">
                        <div class="relative inline-block mb-3">
                            <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) . '&background=random' }}"
                                class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-gray-50" alt="Avatar">
                            <span class="absolute bottom-0 right-0 w-5 h-5 rounded-full border-2 border-white {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }}" title="{{ $user->is_active ? 'Active' : 'Inactive' }}"></span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h3>
                        <p class="text-sm text-gray-500 mb-3">{{ $user->email }}</p>
                        
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full mb-4
                            {{ $user->user_type == 'Volunteer' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $user->user_type == 'Organization' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $user->user_type == 'Admin' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $user->user_type }}
                        </span>

                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-4 bg-gray-50 p-3 rounded-lg">
                            <div class="text-center">
                                <div class="font-bold">{{ $user->created_at->format('M Y') }}</div>
                                <div class="text-xs text-gray-400">Joined</div>
                            </div>
                            <div class="text-center border-l border-gray-200">
                                <div class="font-bold">{{ $user->is_verified ? 'Yes' : 'No' }}</div>
                                <div class="text-xs text-gray-400">Verified</div>
                            </div>
                        </div>

                        <div class="flex justify-center space-x-2 pt-2">
                            <a href="{{ route('admin.users.show', $user->user_id) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->user_id) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button @click="emailSingleUser('{{ $user->user_id }}')" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-full transition">
                                <i class="fas fa-envelope"></i>
                            </button>
                            @if($user->is_active)
                                <button @click="toggleStatus('{{ $user->user_id }}', 'deactivate')" class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-full transition" title="Deactivate">
                                    <i class="fas fa-ban"></i>
                                </button>
                            @else
                                <button @click="toggleStatus('{{ $user->user_id }}', 'activate')" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-full transition" title="Activate">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-lg border border-gray-200">
                    <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500">No users found</p>
                </div>
            @endforelse
        </div>

        <div x-show="viewMode === 'list'" class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" x-cloak>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left w-10">
                                <input type="checkbox" @change="toggleAll" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <input type="checkbox" value="{{ $user->user_id }}" x-model="selected" class="w-4 h-4 rounded border-gray-300 text-indigo-600">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover" 
                                         src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name) }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->user_type == 'Volunteer' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $user->user_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                <button @click="emailSingleUser('{{ $user->user_id }}')" class="text-gray-500 hover:text-gray-700"><i class="fas fa-envelope"></i></button>
                                <a href="{{ route('admin.users.edit', $user->user_id) }}" class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-edit"></i></a>
                                <button @click="toggleStatus('{{ $user->user_id }}', 'deactivate')" class="text-orange-600 hover:text-orange-800"><i class="fas fa-ban"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-center mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>

    {{-- IMPORT MODALs & PARTIALS --}}
    @include('admin.partials.email-modal')

    {{-- Import Modal --}}
    <div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 max-w-2xl w-full mx-4">
             {{-- (Giữ nguyên form import cũ của bạn) --}}
        </div>
    </div>

    @push('scripts')
    <script>
        function userManagement() {
            return {
                viewMode: localStorage.getItem('userViewMode') || 'list',
                selected: [],
                
                init() {
                    this.$watch('viewMode', value => localStorage.setItem('userViewMode', value));
                },

                toggleAll(e) {
                    if (e.target.checked) {
                        this.selected = @json($users->pluck('user_id'));
                    } else {
                        this.selected = [];
                    }
                },

                // Helper gọi Email Modal cho 1 user
                emailSingleUser(id) {
                    if (typeof openEmailModal === 'function') {
                        openEmailModal('single', id);
                    }
                },
                
                // Helper gọi Email Modal cho danh sách đã chọn
                emailSelected() {
                    if (typeof openEmailModal === 'function') {
                        // Truyền danh sách ID dưới dạng chuỗi hoặc xử lý trong modal
                        // Ở đây ta tạm dùng 'selected' type và xử lý bên partial
                        // Lưu ý: Bạn cần sửa partial email-modal để nhận danh sách ID này nếu muốn gửi bulk thật
                        // Tạm thời alert hoặc mở modal basic
                         alert('Tính năng gửi email hàng loạt đang được cập nhật để nhận danh sách ID: ' + this.selected.join(', '));
                         // openEmailModal('selected', this.selected); 
                    }
                },

                // Helper Export
                exportSelected() {
                    let url = '/admin/users/export';
                    const params = new URLSearchParams(window.location.search);
                    
                    // Nếu có chọn, thêm tham số user_ids vào URL
                    if (this.selected.length > 0) {
                        params.set('user_ids', this.selected.join(','));
                    }
                    
                    // Chuyển hướng để tải file
                    window.location.href = url + '?' + params.toString();
                },

                // Helper Toggle Status
                toggleStatus(userId, action) {
                    const actionText = action === 'activate' ? 'activate' : 'deactivate';
                    if (confirm(`Are you sure you want to ${actionText} this user?`)) {
                        fetch(`/admin/users/${userId}/${action}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if(typeof showToast === 'function') showToast(`User ${actionText}d successfully`, 'success');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(() => alert('An error occurred'));
                    }
                }
            }
        }
    </script>
    @endpush
@endsection