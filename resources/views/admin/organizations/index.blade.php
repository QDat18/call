@extends('layouts.admin')

@section('title', 'Organizations Management')
@section('breadcrumb', 'Organizations')

@section('content')
    {{-- Sử dụng AlpineJS để quản lý trạng thái View và Selection --}}
    <div class="space-y-6" x-data="orgManagement()">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Organizations Management</h2>
                <p class="text-gray-600 mt-1">Manage and verify organizations</p>
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

                <button onclick="openEmailModal('organizations')"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition bg-white">
                    <i class="fas fa-envelope mr-2"></i>Email All
                </button>
                
                <button @click="exportSelected()"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    <span x-text="selected.length > 0 ? 'Export (' + selected.length + ')' : 'Export All'"></span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Verified</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['verified'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
            </div>

            {{-- BOX PENDING: Thêm Link Lối Tắt --}}
            <a href="{{ route('admin.organizations.index', ['status' => 'Pending']) }}" 
               class="block bg-white rounded-lg shadow-sm border border-yellow-200 p-6 hover:shadow-md hover:border-yellow-400 transition group cursor-pointer relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-yellow-500 text-white text-xs px-2 py-1 rounded-bl-lg opacity-0 group-hover:opacity-100 transition">
                    Filter
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 group-hover:text-yellow-700">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
            </a>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Rejected</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form action="{{ route('admin.organizations.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Search organizations...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">All Status</option>
                        <option value="Verified" {{ request('status') == 'Verified' ? 'selected' : '' }}>Verified</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">All Types</option>
                        <option value="NGO">NGO</option>
                        <option value="NPO">NPO</option>
                        <option value="Charity">Charity</option>
                        <option value="School">School</option>
                        <option value="Hospital">Hospital</option>
                    </select>
                </div>
                <div class="md:col-span-4 flex justify-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-filter mr-2"></i>Apply
                    </button>
                    <a href="{{ route('admin.organizations.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Reset</a>
                </div>
            </form>
        </div>

        <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($organizations as $org)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition relative group">
                    <div class="absolute top-3 right-3 z-10">
                        <input type="checkbox" value="{{ $org->org_id }}" x-model="selected" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    </div>

                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $org->logo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($org->organization_name) }}"
                                    class="w-12 h-12 rounded-full" alt="Logo">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ Str::limit($org->organization_name, 25) }}</h3>
                                    <p class="text-xs text-gray-500">{{ $org->organization_type }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full mr-6
                                {{ $org->verification_status == 'Verified' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $org->verification_status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $org->verification_status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $org->verification_status }}
                            </span>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-star w-4 mr-2 text-yellow-500"></i>
                                <span>{{ number_format($org->rating, 1) }} Rating</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-users w-4 mr-2 text-blue-500"></i>
                                <span>{{ $org->volunteer_count }} Volunteers</span>
                            </div>
                        </div>

                        <div class="flex space-x-2 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.organizations.show', $org->org_id) }}"
                                class="flex-1 px-3 py-2 text-center text-sm bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            <button onclick="openEmailModal('single', '{{ $org->user_id }}')" 
                                    class="px-3 py-2 text-gray-500 hover:text-indigo-600 border border-gray-200 rounded-lg hover:bg-gray-50" title="Send Email">
                                <i class="fas fa-envelope"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-3 bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <p class="text-lg font-medium text-gray-900">No organizations found</p>
                </div>
            @endforelse
        </div>

        <div x-show="viewMode === 'list'" class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" x-cloak>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                <input type="checkbox" @click="toggleAll" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organization</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stats</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($organizations as $org)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" value="{{ $org->org_id }}" x-model="selected" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $org->logo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($org->organization_name) }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($org->organization_name, 30) }}</div>
                                        <div class="text-sm text-gray-500">{{ $org->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $org->organization_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $org->verification_status == 'Verified' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $org->verification_status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $org->verification_status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $org->verification_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-col">
                                    <span>{{ $org->volunteer_count }} Vols</span>
                                    <span>{{ $org->total_opportunities }} Opps</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button onclick="openEmailModal('single', '{{ $org->user_id }}')" class="text-gray-400 hover:text-indigo-600" title="Email">
                                    <i class="fas fa-envelope"></i>
                                </button>
                                <a href="{{ route('admin.organizations.show', $org->org_id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($organizations->hasPages())
            <div class="flex justify-center mt-4">
                {{ $organizations->links() }}
            </div>
        @endif

    </div>

    @include('admin.partials.email-modal')

    @push('scripts')
        <script>
            function orgManagement() {
                return {
                    viewMode: localStorage.getItem('orgViewMode') || 'grid',
                    selected: [],
                    
                    init() {
                        this.$watch('viewMode', value => localStorage.setItem('orgViewMode', value));
                    },

                    toggleAll(e) {
                        if (e.target.checked) {
                            this.selected = @json($organizations->pluck('org_id'));
                        } else {
                            this.selected = [];
                        }
                    },

                    exportSelected() {
                        let url = '/admin/organizations/export';
                        const params = new URLSearchParams(window.location.search);
                        
                        if (this.selected.length > 0) {
                            // Nếu có chọn checkbox, truyền danh sách ID
                            params.set('org_ids', this.selected.join(','));
                        }
                        
                        window.location.href = url + '?' + params.toString();
                    }
                }
            }
        </script>
    @endpush
@endsection