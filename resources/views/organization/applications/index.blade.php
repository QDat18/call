@extends('layouts.organization')

@section('title', 'Applications Management')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Applications Management</h1>
        <p class="text-gray-600 mt-1">Review and manage volunteer applications</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Under Review</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['under_review'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Accepted</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['accepted'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Rejected</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search volunteer name..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <!-- Status Filter -->
                <div>
                    <select name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Under Review" {{ request('status') == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                        <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="Withdrawn" {{ request('status') == 'Withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    </select>
                </div>

                <!-- Opportunity Filter -->
                <div>
                    <select name="opportunity" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Opportunities</option>
                        @foreach($opportunities as $opp)
                        <option value="{{ $opp->opportunity_id }}" {{ request('opportunity') == $opp->opportunity_id ? 'selected' : '' }}>
                            {{ Str::limit($opp->title, 40) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        Filter
                    </button>
                    <a href="{{ route('organization.applications.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Applications List -->
    <div class="bg-white rounded-lg shadow">
        @if($applications->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Volunteer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Opportunity
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Applied Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($applications as $application)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $application->volunteer->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($application->volunteer->first_name) }}" 
                                         alt="{{ $application->volunteer->first_name }}"
                                         class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $application->volunteer->first_name }} {{ $application->volunteer->last_name }}
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $application->volunteer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('organization.opportunities.show', $application->opportunity->opportunity_id) }}" 
                                   class="text-green-600 hover:text-green-700 hover:underline">
                                    {{ Str::limit($application->opportunity->title, 50) }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $application->applied_date->format('M d, Y') }}
                                <br>
                                <span class="text-xs text-gray-500">{{ $application->applied_date->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($application->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($application->status == 'Under Review') bg-blue-100 text-blue-800
                                    @elseif($application->status == 'Accepted') bg-green-100 text-green-800
                                    @elseif($application->status == 'Rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $application->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('organization.applications.show', $application->application_id) }}" 
                                       class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition">
                                        View
                                    </a>
                                    @if($application->status == 'Pending' || $application->status == 'Under Review')
                                    <button onclick="quickAccept({{ $application->application_id }})"
                                            class="px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-sm rounded-lg transition">
                                        Accept
                                    </button>
                                    <button onclick="quickReject({{ $application->application_id }})"
                                            class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-sm rounded-lg transition">
                                        Reject
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $applications->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No applications found</h3>
                <p class="text-gray-600 mb-4">
                    @if(request('status') || request('search') || request('opportunity'))
                        Try adjusting your filters or search criteria
                    @else
                        Applications will appear here once volunteers apply to your opportunities
                    @endif
                </p>
                @if(request('status') || request('search') || request('opportunity'))
                <a href="{{ route('organization.applications.index') }}" 
                   class="inline-flex items-center gap-2 text-green-600 hover:text-green-700">
                    Clear all filters
                </a>
                @endif
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function quickAccept(applicationId) {
    if (confirm('Are you sure you want to accept this application?')) {
        fetch(`/organization/applications/${applicationId}/accept`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to accept application');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    }
}

function quickReject(applicationId) {
    const reason = prompt('Please provide a reason for rejection (optional):');
    if (reason !== null) {
        fetch(`/organization/applications/${applicationId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ reason: reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to reject application');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    }
}
</script>
@endpush