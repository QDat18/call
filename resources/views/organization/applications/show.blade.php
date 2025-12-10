@extends('layouts.organization')

@section('title', 'Application Details')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('organization.applications.index') }}"
                class="inline-flex items-center gap-2 text-green-600 hover:text-green-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Applications
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Application Header -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-4">
                            @php
                                $avatarSrc = $application->volunteer->avatar_url
                                    ? asset('storage/' . $application->volunteer->avatar_url)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($application->volunteer->first_name . ' ' . $application->volunteer->last_name) . '&background=random&color=fff';
                            @endphp

                            <img src="{{ $avatarSrc }}" alt="{{ $application->volunteer->first_name }}"
                                class="w-16 h-16 rounded-full object-cover border border-gray-200">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">
                                    {{ $application->volunteer->first_name }} {{ $application->volunteer->last_name }}
                                </h1>
                                <p class="text-gray-600">{{ $application->volunteer->email }}</p>
                                @if($application->volunteer->phone)
                                    <p class="text-gray-600">{{ $application->volunteer->phone }}</p>
                                @endif
                            </div>
                        </div>
                        <span class="px-4 py-2 text-sm font-semibold rounded-full
                                                        @if($application->status == 'Pending') bg-yellow-100 text-yellow-800
                                                        @elseif($application->status == 'Under Review') bg-blue-100 text-blue-800
                                                        @elseif($application->status == 'Accepted') bg-green-100 text-green-800
                                                        @elseif($application->status == 'Rejected') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800
                                                        @endif">
                            {{ $application->status }}
                        </span>
                    </div>

                    <!-- Application Meta -->
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-600">Applied For</p>
                            <a href="{{ route('organization.opportunities.show', $application->opportunity->opportunity_id) }}"
                                class="font-semibold text-green-600 hover:text-green-700 hover:underline">
                                {{ $application->opportunity->title }}
                            </a>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Applied Date</p>
                            <p class="font-semibold text-gray-800">
                                {{ $application->applied_date->format('M d, Y') }}
                                <span
                                    class="text-sm text-gray-500">({{ $application->applied_date->diffForHumans() }})</span>
                            </p>
                        </div>
                        @if($application->reviewed_date)
                            <div>
                                <p class="text-sm text-gray-600">Reviewed Date</p>
                                <p class="font-semibold text-gray-800">{{ $application->reviewed_date->format('M d, Y') }}</p>
                            </div>
                        @endif
                        @if($application->interview_scheduled)
                            <div>
                                <p class="text-sm text-gray-600">Interview Scheduled</p>
                                <p class="font-semibold text-gray-800">
                                    {{ $application->interview_scheduled->format('M d, Y H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Motivation Letter -->
                @if($application->motivation_letter)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Motivation Letter</h2>
                        <div class="text-gray-700 whitespace-pre-line">{{ $application->motivation_letter }}</div>
                    </div>
                @endif

                <!-- Relevant Experience -->
                @if($application->relevant_experience)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Relevant Experience</h2>
                        <div class="text-gray-700 whitespace-pre-line">{{ $application->relevant_experience }}</div>
                    </div>
                @endif

                <!-- Availability -->
                @if($application->availability_note)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Availability</h2>
                        <div class="text-gray-700 whitespace-pre-line">{{ $application->availability_note }}</div>
                    </div>
                @endif

                <!-- Organization Notes -->
                @if($application->organization_notes)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-yellow-900 mb-4">Internal Notes</h2>
                        <div class="text-yellow-800 whitespace-pre-line">{{ $application->organization_notes }}</div>
                    </div>
                @endif

                <!-- Add Notes Section -->
                @if($application->status != 'Withdrawn')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Add Internal Notes</h2>
                        <form id="notesForm" onsubmit="saveNotes(event)">
                            <textarea id="notes" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Add notes about this application (visible only to your organization)">{{ $application->organization_notes }}</textarea>
                            <button type="submit"
                                class="mt-3 px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                Save Notes
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Volunteer Profile Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Volunteer Profile</h3>

                    @if($application->volunteer->volunteerProfile)
                        <div class="space-y-3">
                            @if($application->volunteer->volunteerProfile->occupation)
                                <div>
                                    <p class="text-sm text-gray-600">Occupation</p>
                                    <p class="font-medium text-gray-800">{{ $application->volunteer->volunteerProfile->occupation }}
                                    </p>
                                </div>
                            @endif

                            @if($application->volunteer->volunteerProfile->education_level)
                                <div>
                                    <p class="text-sm text-gray-600">Education</p>
                                    <p class="font-medium text-gray-800">
                                        {{ $application->volunteer->volunteerProfile->education_level }}
                                    </p>
                                </div>
                            @endif

                            @if($application->volunteer->volunteerProfile->skills)
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">Skills</p>
                                    <div class="flex flex-wrap gap-2">
                                        @php
                                            $rawSkills = $application->volunteer->volunteerProfile->skills;
                                            // Kiểm tra: Nếu là mảng thì giữ nguyên, nếu là chuỗi thì explode, nếu null thì mảng rỗng
                                            $skillsArray = is_array($rawSkills) ? $rawSkills : (is_string($rawSkills) ? explode(',', $rawSkills) : []);
                                        @endphp

                                        @foreach($skillsArray as $skill)
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                {{ trim($skill) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif


                            @if($application->volunteer->volunteerProfile->availability)
                                <div>
                                    <p class="text-sm text-gray-600">Availability</p>
                                    <p class="font-medium text-gray-800">
                                        {{ $application->volunteer->volunteerProfile->availability }}
                                    </p>
                                </div>
                            @endif

                            <div>
                                <p class="text-sm text-gray-600">Volunteer Hours</p>
                                <p class="font-medium text-gray-800">
                                    {{ $application->volunteer->volunteerProfile->total_volunteer_hours ?? 0 }} hours
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Rating</p>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-medium text-gray-800">{{ number_format($application->volunteer->volunteerProfile->volunteer_rating ?? 0, 1) }}</span>
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= ($application->volunteer->volunteerProfile->volunteer_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('organization.volunteers.show', $application->volunteer->user_id) }}"
                                class="block w-full px-4 py-2 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition">
                                View Full Profile
                            </a>
                        </div>
                    @else
                        <p class="text-gray-600 text-sm">Profile information not available</p>
                    @endif
                </div>

                <!-- Actions Card -->
                @if($application->status != 'Withdrawn')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
                        <div class="space-y-3">
                            @if($application->status == 'Pending')
                                <button onclick="markUnderReview()"
                                    class="block w-full px-4 py-3 text-center bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                    Mark as Under Review
                                </button>
                            @endif

                            @if($application->status == 'Pending' || $application->status == 'Under Review')
                                <button onclick="openScheduleModal()"
                                    class="block w-full px-4 py-3 text-center border border-green-600 text-green-600 hover:bg-green-50 rounded-lg transition">
                                    Schedule Interview
                                </button>

                                <button onclick="acceptApplication()"
                                    class="block w-full px-4 py-3 text-center bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                    Accept Application
                                </button>

                                <button onclick="rejectApplication()"
                                    class="block w-full px-4 py-3 text-center bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                    Reject Application
                                </button>
                            @endif

                            <!-- Contact Actions -->
                            <div class="pt-3 border-t border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Contact Volunteer</p>

                                <a href="mailto:{{ $application->volunteer->email }}"
                                    class="block w-full px-4 py-2 text-center border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg transition mb-2">
                                    Send Email
                                </a>

                                @if($application->volunteer->phone)
                                    <a href="tel:{{ $application->volunteer->phone }}"
                                        class="block w-full px-4 py-2 text-center border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg transition mb-2">
                                        Call Phone
                                    </a>
                                @endif

                                <button onclick="startVideoCall()"
                                    class="block w-full px-4 py-2 text-center border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                    Start Video Call
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Timeline Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Application Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Application Submitted</p>
                                <p class="text-sm text-gray-600">{{ $application->applied_date->format('M d, Y H:i') }}</p>
                            </div>
                        </div>

                        @if($application->reviewed_date)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Application Reviewed</p>
                                    <p class="text-sm text-gray-600">{{ $application->reviewed_date->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($application->interview_scheduled)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Interview Scheduled</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $application->interview_scheduled->format('M d, Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if($application->status == 'Accepted' || $application->status == 'Rejected')
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-8 h-8 {{ $application->status == 'Accepted' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 {{ $application->status == 'Accepted' ? 'text-green-600' : 'text-red-600' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            @if($application->status == 'Accepted')
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            @else
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            @endif
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Application {{ $application->status }}</p>
                                    <p class="text-sm text-gray-600">{{ $application->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Interview Modal -->
    <div id="scheduleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Schedule Interview</h3>
            <form id="scheduleForm" onsubmit="scheduleInterview(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Interview Date & Time</label>
                    <input type="datetime-local" id="interview_datetime" required min="{{ now()->format('Y-m-d\TH:i') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea id="interview_notes" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Add any notes about the interview..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeScheduleModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="toast"
        class="fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg opacity-0 transition-all duration-300 pointer-events-none">
    </div>
@endsection

@push('scripts')
    <script>
        const applicationId = {{ $application->application_id }};

        function saveNotes(event) {
            event.preventDefault();
            const notes = document.getElementById('notes').value;

            fetch(`/organization/applications/${applicationId}/notes`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ notes: notes })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Notes saved successfully');
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to save notes');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                });
        }

        function markUnderReview() {
            if (confirm('Mark this application as under review?')) {
                fetch(`/organization/applications/${applicationId}/review`, {
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
                            alert(data.message || 'Failed to update status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred');
                    });
            }
        }
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;

            toast.classList.remove('opacity-0');
            toast.classList.remove('bg-green-600', 'bg-red-600');

            toast.classList.add(type === 'success' ? 'bg-green-600' : 'bg-red-600');

            setTimeout(() => {
                toast.classList.add('opacity-0');
            }, 2500);
        }
        function acceptApplication() {
            const notes = prompt('Add notes for acceptance (optional):');

            if (notes !== null) {
                fetch(`/organization/applications/${applicationId}/accept`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ notes })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Application accepted successfully!', 'success');
                            setTimeout(() => location.reload(), 1200);
                        } else {
                            showToast(data.message || 'Failed to accept application', 'error');
                        }
                    })
                    .catch(() => {
                        showToast('An error occurred', 'error');
                    });
            }
        }
        function rejectApplication() {
            const reason = prompt('Please provide a reason for rejection:');
            if (reason !== null && reason.trim() !== '') {
                fetch(`/organization/applications/${applicationId}/reject`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ reason: reason })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Application rejected', 'success'); // Or 'info' type if you prefer
                            setTimeout(() => location.reload(), 1200);
                        } else {
                            showToast(data.message || 'Failed to reject application', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred', 'error');
                    });
            } else if (reason !== null) {
                showToast('Please provide a reason for rejection', 'error');
            }
        }
        function openScheduleModal() {
            document.getElementById('scheduleModal').classList.remove('hidden');
        }

        function closeScheduleModal() {
            document.getElementById('scheduleModal').classList.add('hidden');
        }

        function scheduleInterview(event) {
            event.preventDefault();

            const datetime = document.getElementById('interview_datetime').value;
            const notes = document.getElementById('interview_notes').value;

            fetch(`/organization/applications/${applicationId}/schedule-interview`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    interview_datetime: datetime,
                    notes: notes
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Interview scheduled successfully!');
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to schedule interview');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                });
        }

        function startVideoCall() {
            alert('Video call feature coming soon!');
            // TODO: Implement video call functionality
        }
    </script>
@endpush