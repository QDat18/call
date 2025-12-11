@extends('layouts.admin')

@section('title', 'User Management')
@section('breadcrumb', 'Users')

@section('content')
    {{-- AlpineJS Data --}}
    <div class="space-y-6" x-data="userManagement()">

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">User Management</h2>
                <p class="text-sm text-gray-500 mt-1">Manage system users, volunteers, and organizations.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex bg-white rounded-lg p-1 border border-gray-200 shadow-sm">
                    <button @click="viewMode = 'grid'" 
                            :class="{ 'bg-gray-100 text-indigo-600 font-semibold': viewMode === 'grid', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': viewMode !== 'grid' }"
                            class="px-3 py-2 rounded-md text-sm transition-all flex items-center" title="Grid View">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button @click="viewMode = 'list'" 
                            :class="{ 'bg-gray-100 text-indigo-600 font-semibold': viewMode === 'list', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': viewMode !== 'list' }"
                            class="px-3 py-2 rounded-md text-sm transition-all flex items-center" title="List View">
                        <i class="fas fa-list"></i>
                    </button>
                </div>

                <div class="flex gap-2" x-show="selected.length > 0" x-cloak x-transition>
                    <button @click="emailSelected()" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition shadow-sm text-sm font-medium">
                        <i class="fas fa-envelope mr-2"></i>
                        Email (<span x-text="selected.length"></span>)
                    </button>

                    <button @click="exportSelected()" 
                            class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded-lg hover:bg-green-100 transition shadow-sm text-sm font-medium">
                        <i class="fas fa-file-export mr-2"></i>
                        <span x-text="selected.length > 0 ? 'Export (' + selected.length + ')' : 'Export All'"></span>
                    </button>
                </div>
                
                <button type="button" onclick="exportDataGlobal()" 
                        x-show="selected.length === 0"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 shadow-sm transition text-sm">
                    <i class="fas fa-file-excel mr-2 text-green-600"></i> Xuất Excel
                </button>

                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white border border-transparent rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 transition shadow-md text-sm font-bold">
                    <i class="fas fa-plus mr-2"></i> Add User
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-5 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition shadow-sm placeholder-gray-400"
                        placeholder="Search by name, email or phone...">
                </div>

                <div class="md:col-span-3">
                    <select name="user_type" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm cursor-pointer">
                        <option value="">All User Types</option>
                        <option value="Volunteer" {{ request('user_type') == 'Volunteer' ? 'selected' : '' }}>Volunteer</option>
                        <option value="Organization" {{ request('user_type') == 'Organization' ? 'selected' : '' }}>Organization</option>
                        <option value="Admin" {{ request('user_type') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <select name="status" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm cursor-pointer">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                    </select>
                </div>

                <div class="md:col-span-2 flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition shadow-md text-sm font-medium">
                        Filter
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-sm" title="Reset Filters">
                        <i class="fas fa-undo-alt"></i>
                    </a>
                </div>
            </form>
        </div>

        <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" x-cloak x-transition>
            @forelse($users as $user)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-200 transition-all duration-300 relative group overflow-hidden">
                    <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity" :class="{'opacity-100': selected.includes('{{ $user->user_id }}')}">
                        <input type="checkbox" value="{{ $user->user_id }}" x-model="selected" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer shadow-sm">
                    </div>

                    <div class="p-6 flex flex-col items-center">
                        <div class="relative mb-4">
                            {{-- [FIX LỖI ẢNH & MÃ MÀU] --}}
                            <img src="{{ $user->avatar_url && !Str::contains($user->avatar_url, ['#', ' ']) && strlen($user->avatar_url) > 7 ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) . '&background=random' }}"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->first_name) }}&background=random';"
                                 class="w-20 h-20 rounded-full object-cover border-4 border-gray-50 shadow-sm" 
                                 alt="Avatar">
                            <span class="absolute bottom-1 right-1 w-4 h-4 rounded-full border-2 border-white {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 mb-1 text-center">{{ $user->first_name }} {{ $user->last_name }}</h3>
                        <p class="text-sm text-gray-500 mb-3 text-center truncate w-full px-4">{{ $user->email }}</p>
                        
                        <div class="flex gap-2 mb-6">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold border
                                {{ $user->user_type == 'Volunteer' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                {{ $user->user_type == 'Organization' ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}
                                {{ $user->user_type == 'Admin' ? 'bg-red-50 text-red-700 border-red-200' : '' }}">
                                {{ $user->user_type }}
                            </span>
                        </div>

                        <div class="flex gap-2 w-full justify-center">
                            <a href="{{ route('admin.users.show', $user->user_id) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"><i class="fas fa-eye"></i></a>
                            <button @click="emailSingleUser('{{ $user->user_id }}')" class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"><i class="fas fa-envelope"></i></button>
                            <a href="{{ route('admin.users.edit', $user->user_id) }}" class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition"><i class="fas fa-edit"></i></a>
                            <button @click="toggleStatus('{{ $user->user_id }}', '{{ $user->is_active ? 'deactivate' : 'activate' }}')" 
                                    class="p-2 rounded-lg transition {{ $user->is_active ? 'text-gray-500 hover:text-orange-600 hover:bg-orange-50' : 'text-gray-500 hover:text-green-600 hover:bg-green-50' }}">
                                <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 bg-white rounded-xl border border-dashed border-gray-300 text-center">
                    <p class="text-gray-500">No users found</p>
                </div>
            @endforelse
        </div>

        <div x-show="viewMode === 'list'" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-cloak x-transition>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left w-10">
                                <input type="checkbox" @change="toggleAll" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">User Info</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Joined</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50/80 transition duration-150 group">
                            <td class="px-6 py-4">
                                <input type="checkbox" value="{{ $user->user_id }}" x-model="selected" class="w-4 h-4 rounded border-gray-300 text-indigo-600 cursor-pointer">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 relative">
                                        {{-- [FIX LỖI ẢNH & MÃ MÀU CHO LIST VIEW] --}}
                                        <img src="{{ $user->avatar_url && !Str::contains($user->avatar_url, ['#', ' ']) && strlen($user->avatar_url) > 7 ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name) }}"
                                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->first_name) }}';" 
                                             class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white {{ $user->is_active ? 'bg-green-400' : 'bg-gray-400' }}"></span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                    {{ $user->user_type == 'Volunteer' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                    {{ $user->user_type == 'Organization' ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}
                                    {{ $user->user_type == 'Admin' ? 'bg-red-50 text-red-700 border-red-200' : '' }}">
                                    {{ $user->user_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($user->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $user->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <button @click="emailSingleUser('{{ $user->user_id }}')" class="text-gray-400 hover:text-blue-600 p-1"><i class="fas fa-envelope"></i></button>
                                    <a href="{{ route('admin.users.edit', $user->user_id) }}" class="text-gray-400 hover:text-indigo-600 p-1"><i class="fas fa-edit"></i></a>
                                    <button @click="toggleStatus('{{ $user->user_id }}', '{{ $user->is_active ? 'deactivate' : 'activate' }}')" class="p-1 text-gray-400 hover:text-orange-600"><i class="fas fa-ban"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
            <div class="flex justify-center mt-6">{{ $users->withQueryString()->links() }}</div>
        @endif
    </div>

    @include('admin.partials.email-modal')

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- [FIX LỖI JS: HÀM GLOBAL] ---
        function exportDataGlobal() {
            const queryString = window.location.search;
            const exportUrl = "{{ route('admin.users.export') }}" + queryString;
            window.location.href = exportUrl;
        }

        // Alpine Component
        function userManagement() {
            return {
                viewMode: localStorage.getItem('userViewMode') || 'list',
                selected: [],
                
                init() {
                    this.$watch('viewMode', value => localStorage.setItem('userViewMode', value));
                },

                toggleAll(e) {
                    this.selected = e.target.checked ? @json($users->pluck('user_id')) : [];
                },

                emailSingleUser(id) {
                    if (typeof openEmailModal === 'function') openEmailModal('single', id);
                },
                
                emailSelected() {
                    if (typeof openEmailModal === 'function') {
                         if(this.selected.length === 0) return alert('Please select users first');
                         // Logic gọi modal bulk (cần chỉnh sửa partials nếu muốn gửi list ID)
                         openEmailModal('bulk', this.selected[0]); 
                         // Note: Partial email hiện tại đang nhận 1 ID cho 'bulk', 
                         // bạn cần sửa partials để nhận mảng this.selected nếu muốn gửi thật
                    }
                },

                exportSelected() {
                    let url = '/admin/users/export';
                    const params = new URLSearchParams(window.location.search);
                    if (this.selected.length > 0) params.set('user_ids', this.selected.join(','));
                    window.location.href = url + '?' + params.toString();
                },

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
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) window.location.reload();
                            else alert(data.message);
                        })
                        .catch(() => alert('An error occurred'));
                    }
                }
            }
        }
    </script>
    @endpush
@endsection