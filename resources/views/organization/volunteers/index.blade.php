@extends('layouts.organization')

@section('title', 'Manage Volunteers')

@section('content')
{{-- Thêm biến kickModalOpen vào x-data --}}
<div id="volunteers-manager-area" class="container mx-auto px-4 py-6" 
     x-data="{ 
        contactModalOpen: false, 
        contactId: null, 
        contactName: '', 
        subject: '', 
        message: '',
        viewMode: localStorage.getItem('volunteersViewMode') || 'grid',
        kickModalOpen: false,
        kickId: null,
        kickName: ''
     }"
     x-init="$watch('viewMode', val => localStorage.setItem('volunteersViewMode', val))">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Volunteers</h1>
            <p class="text-gray-600 mt-1">Manage volunteers who have joined your opportunities</p>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="bg-white border border-gray-300 rounded-lg p-1 flex items-center shadow-sm">
                <button @click="viewMode = 'grid'" 
                        :class="{ 'bg-gray-100 text-green-600': viewMode === 'grid', 'text-gray-500 hover:text-gray-700': viewMode !== 'grid' }"
                        class="p-2 rounded transition-colors" title="Grid View">
                    <i class="fas fa-th-large"></i>
                </button>
                <button @click="viewMode = 'list'" 
                        :class="{ 'bg-gray-100 text-green-600': viewMode === 'list', 'text-gray-500 hover:text-gray-700': viewMode !== 'list' }"
                        class="p-2 rounded transition-colors" title="List View">
                    <i class="fas fa-list"></i>
                </button>
            </div>

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 flex items-center gap-2 shadow-sm h-full">
                    <i class="fas fa-download text-gray-500"></i>
                    <span class="hidden sm:inline">Export</span>
                    <i class="fas fa-chevron-down text-xs ml-1"></i>
                </button>
                <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50 py-1" style="display: none;" x-cloak>
                    <a href="{{ route('organization.volunteers.export', array_merge(request()->all(), ['type' => 'top100'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">
                        <i class="fas fa-file-excel w-5 text-green-600"></i> Top 100 Volunteers
                    </a>
                    <a href="{{ route('organization.volunteers.export', array_merge(request()->all(), ['type' => 'all'])) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600">
                        <i class="fas fa-database w-5 text-blue-600"></i> All Volunteers
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Volunteers</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Active Now</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Hours</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['total_hours']) }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Avg Rating</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ number_format($stats['avg_rating'], 1) }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="bg-white rounded-lg shadow mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <select name="opportunity" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Opportunities</option>
                        @foreach($opportunities as $opp)
                        <option value="{{ $opp->opportunity_id }}" {{ request('opportunity') == $opp->opportunity_id ? 'selected' : '' }}>
                            {{ Str::limit($opp->title, 30) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">Filter</button>
                    <a href="{{ route('organization.volunteers.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-center">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($volunteers->count() > 0)
            
            {{-- === VIEW 1: GRID VIEW (CARD) === --}}
            <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($volunteers as $volunteer)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition relative flex flex-col">
                    {{-- Header --}}
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ $volunteer->avatar_url ? asset('storage/' . $volunteer->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($volunteer->first_name) }}" 
                             class="w-16 h-16 rounded-full object-cover border border-gray-100">
                        <div class="flex-1 overflow-hidden">
                            <h3 class="font-semibold text-gray-800 text-lg truncate" title="{{ $volunteer->first_name }} {{ $volunteer->last_name }}">
                                {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                            </h3>
                            @if($volunteer->volunteerProfile && $volunteer->volunteerProfile->occupation)
                            <p class="text-sm text-gray-600 truncate">{{ $volunteer->volunteerProfile->occupation }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Mini Stats --}}
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-blue-50 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-blue-600">{{ $volunteer->opportunities_count ?? 0 }}</p>
                            <p class="text-xs text-gray-600">Opps</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-3 text-center">
                            <p class="text-xl font-bold text-purple-600">
                                {{ $volunteer->volunteerProfile->total_volunteer_hours ?? 0 }}
                            </p>
                            <p class="text-xs text-gray-600">Hours</p>
                        </div>
                    </div>

                    {{-- Rating --}}
                    @if($volunteer->volunteerProfile)
                    <div class="flex items-center justify-center gap-2 mb-4 pb-4 border-b border-gray-200">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-xs {{ $i <= ($volunteer->volunteerProfile->volunteer_rating ?? 0) ? '' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 font-medium">
                            {{ number_format($volunteer->volunteerProfile->volunteer_rating ?? 0, 1) }}
                        </span>
                    </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex gap-2 mt-auto pt-2">
                        <a href="{{ route('organization.volunteers.show', $volunteer->user_id) }}" 
                           class="flex-1 py-2 text-center bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm rounded-lg transition font-medium">
                            Profile
                        </a>
                        <button @click="contactModalOpen = true; contactId = {{ $volunteer->user_id }}; contactName = '{{ $volunteer->first_name }} {{ $volunteer->last_name }}'"
                                class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition"
                                title="Send Email">
                            <i class="fas fa-envelope"></i>
                        </button>
                        {{-- NÚT KICK --}}
                        <button @click="kickModalOpen = true; kickId = {{ $volunteer->user_id }}; kickName = '{{ $volunteer->first_name }} {{ $volunteer->last_name }}'"
                                class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 text-sm rounded-lg transition"
                                title="Remove Volunteer">
                            <i class="fas fa-user-times"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- === VIEW 2: LIST VIEW (TABLE) === --}}
            <div x-show="viewMode === 'list'" class="overflow-x-auto" x-cloak>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volunteer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stats</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($volunteers as $volunteer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200" 
                                         src="{{ $volunteer->avatar_url ? asset('storage/' . $volunteer->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($volunteer->first_name) }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $volunteer->first_name }} {{ $volunteer->last_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $volunteer->volunteerProfile->occupation ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $volunteer->email }}</div>
                                <div class="text-sm text-gray-500">{{ $volunteer->phone ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    {{ $volunteer->volunteerProfile->total_volunteer_hours ?? 0 }}h
                                </span>
                                <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $volunteer->opportunities_count ?? 0 }} ops
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-yellow-400 text-xs">
                                    <span class="text-gray-600 mr-1 text-sm">{{ number_format($volunteer->volunteerProfile->volunteer_rating ?? 0, 1) }}</span>
                                    <i class="fas fa-star"></i>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('organization.volunteers.show', $volunteer->user_id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button @click="contactModalOpen = true; contactId = {{ $volunteer->user_id }}; contactName = '{{ $volunteer->first_name }} {{ $volunteer->last_name }}'" 
                                        class="text-green-600 hover:text-green-900 mr-3" title="Send Email">
                                    <i class="fas fa-envelope"></i>
                                </button>
                                {{-- NÚT KICK --}}
                                <button @click="kickModalOpen = true; kickId = {{ $volunteer->user_id }}; kickName = '{{ $volunteer->first_name }} {{ $volunteer->last_name }}'" 
                                        class="text-red-600 hover:text-red-900" title="Remove Volunteer">
                                    <i class="fas fa-user-times"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $volunteers->withQueryString()->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users-slash text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No volunteers yet</h3>
                <p class="text-gray-600 mb-4">Volunteers will appear here once they join your opportunities</p>
            </div>
        @endif
    </div>

    {{-- Contact Modal --}}
    <div x-show="contactModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="contactModalOpen = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-envelope text-green-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Contact <span x-text="contactName"></span>
                            </h3>
                            <div class="mt-2">
                                <form id="contactForm" class="space-y-4" @submit.prevent="sendEmail">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Subject</label>
                                        <input type="text" x-model="subject" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Interview Invitation...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Message</label>
                                        <textarea x-model="message" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Write your message here..."></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="sendEmail()"
                            id="btn-send-email"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Send Email
                    </button>
                    <button type="button" 
                            @click="contactModalOpen = false" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Kick Confirmation Modal --}}
    <div x-show="kickModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="kickModalOpen = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Remove <span x-text="kickName"></span>?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to remove this volunteer from your organization? 
                                    This will cancel their active participation in your opportunities.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="removeVolunteer()"
                            id="btn-confirm-kick"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Confirm Remove
                    </button>
                    <button type="button" 
                            @click="kickModalOpen = false" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function sendEmail() {
        const container = document.getElementById('volunteers-manager-area');
        if (!container) return;

        const data = Alpine.$data(container);

        if(!data.subject || !data.subject.trim() || !data.message || !data.message.trim()) {
            showToast('Please fill in all fields', 'error');
            return;
        }

        const btn = document.getElementById('btn-send-email');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

        fetch('{{ route("organization.volunteers.contact") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                volunteer_id: data.contactId,
                subject: data.subject,
                message: data.message
            })
        })
        .then(response => response.json())
        .then(result => {
            if(result.success) {
                showToast(result.message, 'success');
                data.contactModalOpen = false;
                data.subject = '';
                data.message = '';
            } else {
                showToast(result.message, 'error');
            }
        })
        .catch(error => {
            console.error(error);
            showToast('Something went wrong', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }

    function removeVolunteer() {
        const container = document.getElementById('volunteers-manager-area');
        const data = Alpine.$data(container);
        const btn = document.getElementById('btn-confirm-kick');
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

        // Gọi route remove (sử dụng route name trong blade hoặc hardcode nếu cần)
        const url = `/organization/volunteers/${data.kickId}/remove`;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(result => {
            if(result.success) {
                showToast(result.message, 'success');
                setTimeout(() => location.reload(), 1000); 
            } else {
                showToast(result.message, 'error');
            }
        })
        .catch(error => {
            console.error(error);
            showToast('Something went wrong', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Confirm Remove';
            data.kickModalOpen = false;
        });
    }
</script>
@endpush