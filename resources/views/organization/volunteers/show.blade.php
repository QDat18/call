@extends('layouts.organization')

@section('title', 'Volunteer Profile')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('organization.volunteers.index') }}" 
           class="inline-flex items-center gap-2 text-green-600 hover:text-green-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Volunteers
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-start gap-6">
                    <img src="{{ $volunteer->avatar_url ? asset('storage/' . $volunteer->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($volunteer->first_name . ' ' . $volunteer->last_name) }}" 
                         alt="{{ $volunteer->first_name }}"
                         class="w-24 h-24 rounded-full object-cover">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">
                            {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                        </h1>
                        @if($volunteer->volunteerProfile && $volunteer->volunteerProfile->occupation)
                        <p class="text-lg text-gray-600 mb-3">{{ $volunteer->volunteerProfile->occupation }}</p>
                        @endif
                        
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:{{ $volunteer->email }}" class="hover:text-green-600">{{ $volunteer->email }}</a>
                            </div>
                            @if($volunteer->phone)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $volunteer->phone }}
                            </div>
                            @endif
                            @if($volunteer->city)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $volunteer->city }}{{ $volunteer->district ? ', ' . $volunteer->district : '' }}
                            </div>
                            @endif
                        </div>

                        @if($volunteer->volunteerProfile)
                        <div class="flex items-center gap-3 mt-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= ($volunteer->volunteerProfile->volunteer_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>
                            <span class="text-lg font-semibold text-gray-800">
                                {{ number_format($volunteer->volunteerProfile->volunteer_rating ?? 0, 1) }}
                            </span>
                            <span class="text-gray-600">({{ $volunteer->volunteerProfile->total_volunteer_hours ?? 0 }} hours)</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($volunteer->volunteerProfile && $volunteer->volunteerProfile->bio)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">About</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $volunteer->volunteerProfile->bio }}</p>
            </div>
            @endif

            @if($volunteer->volunteerProfile)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Skills & Interests</h2>
                
                @if($volunteer->volunteerProfile->skills)
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Skills</p>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $skills = $volunteer->volunteerProfile->skills;
                            if (is_string($skills)) {
                                $skills = explode(',', $skills);
                            } elseif (!is_array($skills)) {
                                $skills = [];
                            }
                        @endphp

                        @foreach($skills as $skill)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ trim($skill) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($volunteer->volunteerProfile->interests)
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Interests</p>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $interests = $volunteer->volunteerProfile->interests;
                            if (is_string($interests)) {
                                $interests = explode(',', $interests);
                            } elseif (!is_array($interests)) {
                                $interests = [];
                            }
                        @endphp

                        @foreach($interests as $interest)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            {{ trim($interest) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endif

            @if($volunteer->volunteerProfile && $volunteer->volunteerProfile->volunteer_experience)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Volunteer Experience</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $volunteer->volunteerProfile->volunteer_experience }}</p>
            </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Activities with Your Organization</h2>
                
                @if($activities && $activities->count() > 0)
                <div class="space-y-4">
                    @foreach($activities as $activity)
                    <div class="border-l-4 border-green-500 pl-4 py-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $activity->opportunity->title }}</p>
                                <p class="text-sm text-gray-600">{{ $activity->activity_date->format('M d, Y') }}</p>
                                @if($activity->activity_description)
                                <p class="text-sm text-gray-700 mt-1">{{ $activity->activity_description }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600">{{ $activity->hours_worked }}h</p>
                                <span class="text-xs px-2 py-1 rounded-full
                                    @if($activity->status == 'Verified') bg-green-100 text-green-800
                                    @elseif($activity->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $activity->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-600">No activities recorded yet</p>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Application History</h2>
                
                @if($applications && $applications->count() > 0)
                <div class="space-y-3">
                    @foreach($applications as $application)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $application->opportunity->title }}</p>
                            <p class="text-sm text-gray-600">Applied {{ $application->applied_date->format('M d, Y') }}</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if($application->status == 'Accepted') bg-green-100 text-green-800
                            @elseif($application->status == 'Pending') bg-yellow-100 text-yellow-800
                            @elseif($application->status == 'Under Review') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $application->status }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-600">No applications yet</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Hours</span>
                        <span class="font-semibold text-gray-800">
                            {{ $volunteer->volunteerProfile->total_volunteer_hours ?? 0 }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Opportunities</span>
                        <span class="font-semibold text-gray-800">{{ $applications->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Completed</span>
                        <span class="font-semibold text-green-600">
                            {{ $applications->where('status', 'Accepted')->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Member Since</span>
                        <span class="font-semibold text-gray-800">
                            {{ $volunteer->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            @if($volunteer->volunteerProfile)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Profile Details</h3>
                <div class="space-y-3">
                    @if($volunteer->volunteerProfile->education_level)
                    <div>
                        <p class="text-sm text-gray-600">Education</p>
                        <p class="font-medium text-gray-800">{{ $volunteer->volunteerProfile->education_level }}</p>
                    </div>
                    @endif

                    @if($volunteer->volunteerProfile->university)
                    <div>
                        <p class="text-sm text-gray-600">University</p>
                        <p class="font-medium text-gray-800">{{ $volunteer->volunteerProfile->university }}</p>
                    </div>
                    @endif

                    @if($volunteer->volunteerProfile->availability)
                    <div>
                        <p class="text-sm text-gray-600">Availability</p>
                        <p class="font-medium text-gray-800">{{ $volunteer->volunteerProfile->availability }}</p>
                    </div>
                    @endif

                    @if($volunteer->volunteerProfile->transportation)
                    <div>
                        <p class="text-sm text-gray-600">Transportation</p>
                        <p class="font-medium text-gray-800">{{ $volunteer->volunteerProfile->transportation }}</p>
                    </div>
                    @endif

                    @if($volunteer->volunteerProfile->preferred_location)
                    <div>
                        <p class="text-sm text-gray-600">Preferred Location</p>
                        <p class="font-medium text-gray-800">{{ $volunteer->volunteerProfile->preferred_location }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="mailto:{{ $volunteer->email }}" 
                       class="block w-full px-4 py-3 text-center bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        Send Email
                    </a>
                    
                    @if($volunteer->phone)
                    <a href="tel:{{ $volunteer->phone }}" 
                       class="block w-full px-4 py-3 text-center border border-green-600 text-green-600 hover:bg-green-50 rounded-lg transition">
                        Call Phone
                    </a>
                    @endif

                    <button onclick="startVideoCall()" 
                            class="block w-full px-4 py-3 text-center border border-green-600 text-green-600 hover:bg-green-50 rounded-lg transition">
                        Start Video Call
                    </button>

                    <button onclick="writeReview()" 
                            class="block w-full px-4 py-3 text-center border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        Write Review
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                <div class="space-y-4">
                    @if($activities && $activities->count() > 0)
                        @foreach($activities->take(5) as $activity)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $activity->hours_worked }}h volunteered</p>
                                <p class="text-xs text-gray-600">{{ $activity->activity_date->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-600">No recent activity</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function startVideoCall() {
    alert('Video call feature coming soon!');
}

function writeReview() {
    alert('Review feature coming soon!');
}
</script>
@endpush