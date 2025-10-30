@extends('layouts.organization')

@section('title', 'Manage Volunteers')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Volunteers</h1>
        <p class="text-gray-600 mt-1">Manage volunteers who have joined your opportunities</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Volunteers</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
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
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
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
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
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
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
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
                           placeholder="Search by name or email..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
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

                <!-- Status Filter -->
                <div>
                    <select name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        Filter
                    </button>
                    <a href="{{ route('organization.volunteers.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Volunteers List -->
    <div class="bg-white rounded-lg shadow">
        @if($volunteers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($volunteers as $volunteer)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                    <!-- Volunteer Header -->
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ $volunteer->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($volunteer->first_name) }}" 
                             alt="{{ $volunteer->first_name }}"
                             class="w-16 h-16 rounded-full object-cover">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 text-lg">
                                {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                            </h3>
                            @if($volunteer->volunteerProfile && $volunteer->volunteerProfile->occupation)
                            <p class="text-sm text-gray-600">{{ $volunteer->volunteerProfile->occupation }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-blue-50 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $volunteer->opportunities_count ?? 0 }}</p>
                            <p class="text-xs text-gray-600">Opportunities</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-purple-600">
                                {{ $volunteer->volunteerProfile->total_volunteer_hours ?? 0 }}
                            </p>
                            <p class="text-xs text-gray-600">Hours</p>
                        </div>
                    </div>

                    <!-- Rating -->
                    @if($volunteer->volunteerProfile)
                    <div class="flex items-center justify-center gap-2 mb-4 pb-4 border-b border-gray-200">
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= ($volunteer->volunteerProfile->volunteer_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}" 
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600">
                            {{ number_format($volunteer->volunteerProfile->volunteer_rating ?? 0, 1) }}
                        </span>
                    </div>
                    @endif

                    <!-- Skills -->
                    @if($volunteer->volunteerProfile && $volunteer->volunteerProfile->skills)
                    <div class="mb-4">
                        <p class="text-xs text-gray-600 mb-2">Skills</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach(array_slice(explode(',', $volunteer->volunteerProfile->skills), 0, 3) as $skill)
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">
                                {{ trim($skill) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="{{ route('organization.volunteers.show', $volunteer->user_id) }}" 
                           class="flex-1 px-4 py-2 text-center bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition">
                            View Profile
                        </a>
                        <button onclick="contactVolunteer({{ $volunteer->user_id }})"
                                class="px-4 py-2 border border-green-600 text-green-600 hover:bg-green-50 text-sm rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $volunteers->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No volunteers yet</h3>
                <p class="text-gray-600 mb-4">
                    @if(request('search') || request('opportunity') || request('status'))
                        Try adjusting your filters
                    @else
                        Volunteers will appear here once they join your opportunities
                    @endif
                </p>
                @if(request('search') || request('opportunity') || request('status'))
                <a href="{{ route('organization.volunteers.index') }}" 
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
function contactVolunteer(volunteerId) {
    // TODO: Implement contact functionality
    alert('Contact feature coming soon!');
}
</script>
@endpush