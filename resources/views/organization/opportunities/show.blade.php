@extends('layouts.organization')

@section('title', $opportunity->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('organization.opportunities.index') }}" 
           class="inline-flex items-center gap-2 text-green-600 hover:text-green-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Opportunities
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Opportunity Header -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $opportunity->title }}</h1>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                @if($opportunity->status == 'Active') bg-green-100 text-green-800
                                @elseif($opportunity->status == 'Paused') bg-yellow-100 text-yellow-800
                                @elseif($opportunity->status == 'Completed') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $opportunity->status }}
                            </span>
                            @if($opportunity->category)
                            <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">
                                {{ $opportunity->category->category_name }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('organization.opportunities.edit', $opportunity->opportunity_id) }}" 
                           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                            Edit
                        </a>
                        <button onclick="confirmDelete()" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Key Info -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">Volunteers Needed</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $opportunity->volunteers_needed }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">Registered</p>
                        <p class="text-2xl font-bold text-green-600">{{ $opportunity->volunteers_registered }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">Applications</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $opportunity->application_count }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">Views</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $opportunity->view_count }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Description</h3>
                    <div class="text-gray-700 whitespace-pre-line">{{ $opportunity->description }}</div>
                </div>

                <!-- Requirements -->
                @if($opportunity->requirements)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Requirements</h3>
                    <div class="text-gray-700 whitespace-pre-line">{{ $opportunity->requirements }}</div>
                </div>
                @endif

                <!-- Benefits -->
                @if($opportunity->benefits)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Benefits</h3>
                    <div class="text-gray-700 whitespace-pre-line">{{ $opportunity->benefits }}</div>
                </div>
                @endif

                <!-- Required Skills -->
                @if($opportunity->required_skills)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Required Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $opportunity->required_skills) as $skill)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ trim($skill) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Recent Applications -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Recent Applications</h2>
                    <a href="{{ route('organization.applications.index', ['opportunity' => $opportunity->opportunity_id]) }}" 
                       class="text-green-600 hover:text-green-700 text-sm font-medium">
                        View All →
                    </a>
                </div>

                @if($recentApplications && $recentApplications->count() > 0)
                <div class="space-y-4">
                    @foreach($recentApplications as $application)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4">
                            <img src="{{ $application->volunteer->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($application->volunteer->first_name . ' ' . $application->volunteer->last_name) }}" 
                                 alt="{{ $application->volunteer->first_name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $application->volunteer->first_name }} {{ $application->volunteer->last_name }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Applied {{ $application->applied_date->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($application->status == 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($application->status == 'Under Review') bg-blue-100 text-blue-800
                                @elseif($application->status == 'Accepted') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $application->status }}
                            </span>
                            <a href="{{ route('organization.applications.show', $application->application_id) }}" 
                               class="text-green-600 hover:text-green-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p>No applications yet</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Details Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Details</h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Location</p>
                            <p class="font-medium text-gray-800">{{ $opportunity->location ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Schedule Type</p>
                            <p class="font-medium text-gray-800">{{ $opportunity->schedule_type ?? 'Flexible' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Minimum Age</p>
                            <p class="font-medium text-gray-800">{{ $opportunity->min_age ?? 16 }} years old</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Experience Level</p>
                            <p class="font-medium text-gray-800">{{ $opportunity->experience_needed ?? 'No experience' }}</p>
                        </div>
                    </div>

                    @if($opportunity->application_deadline)
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Application Deadline</p>
                            <p class="font-medium text-gray-800">{{ date('M d, Y', strtotime($opportunity->application_deadline)) }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('organization.applications.index', ['opportunity' => $opportunity->opportunity_id]) }}" 
                       class="block w-full px-4 py-3 text-center bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        View All Applications
                    </a>
                    <a href="{{ route('organization.opportunities.edit', $opportunity->opportunity_id) }}" 
                       class="block w-full px-4 py-3 text-center border border-green-600 text-green-600 hover:bg-green-50 rounded-lg transition">
                        Edit Opportunity
                    </a>
                    @if($opportunity->status == 'Active')
                    <button onclick="pauseOpportunity()" 
                            class="block w-full px-4 py-3 text-center border border-yellow-600 text-yellow-600 hover:bg-yellow-50 rounded-lg transition">
                        Pause Opportunity
                    </button>
                    @elseif($opportunity->status == 'Paused')
                    <button onclick="activateOpportunity()" 
                            class="block w-full px-4 py-3 text-center border border-green-600 text-green-600 hover:bg-green-50 rounded-lg transition">
                        Activate Opportunity
                    </button>
                    @endif
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistics</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Views</span>
                        <span class="font-semibold text-gray-800">{{ $opportunity->view_count }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Applications</span>
                        <span class="font-semibold text-gray-800">{{ $opportunity->application_count }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Volunteers Registered</span>
                        <span class="font-semibold text-green-600">{{ $opportunity->volunteers_registered }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Spots Remaining</span>
                        <span class="font-semibold text-blue-600">
                            {{ max(0, $opportunity->volunteers_needed - $opportunity->volunteers_registered) }}
                        </span>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Fill Rate</span>
                            <span class="font-semibold text-purple-600">
                                {{ $opportunity->volunteers_needed > 0 ? round(($opportunity->volunteers_registered / $opportunity->volunteers_needed) * 100) : 0 }}%
                            </span>
                        </div>
                        <div class="mt-2 bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" 
                                 style="width: {{ $opportunity->volunteers_needed > 0 ? min(100, ($opportunity->volunteers_registered / $opportunity->volunteers_needed) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Delete Opportunity</h3>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this opportunity? This action cannot be undone.</p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" 
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Cancel
            </button>
            <form action="{{ route('organization.opportunities.destroy', $opportunity->opportunity_id) }}" 
                  method="POST" 
                  class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function pauseOpportunity() {
    if (confirm('Are you sure you want to pause this opportunity?')) {
        fetch('{{ route("organization.opportunities.pause", $opportunity->opportunity_id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to pause opportunity');
            }
        });
    }
}

function activateOpportunity() {
    if (confirm('Are you sure you want to activate this opportunity?')) {
        fetch('{{ route("organization.opportunities.activate", $opportunity->opportunity_id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to activate opportunity');
            }
        });
    }
}
</script>
@endpush