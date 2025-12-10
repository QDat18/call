{{-- resources/views/organization/activities/show.blade.php --}}
@extends('layouts.organization')

@section('title', 'Activity Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('organization.activities.index') }}" 
           class="inline-flex items-center gap-2 text-green-600 hover:text-green-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Activities
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Volunteer Information</h2>
                <div class="flex items-center gap-4">
                    @php
                        $avatar = $activity->volunteer->avatar_url 
                            ? asset('storage/' . $activity->volunteer->avatar_url) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($activity->volunteer->first_name . ' ' . $activity->volunteer->last_name) . '&background=random';
                    @endphp
                    <img src="{{ $avatar }}" 
                         alt="{{ $activity->volunteer->first_name }}" 
                         class="w-20 h-20 rounded-full object-cover border border-gray-200">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $activity->volunteer->first_name }} {{ $activity->volunteer->last_name }}
                        </h3>
                        <p class="text-gray-600 flex items-center gap-2">
                            <i class="fas fa-envelope"></i> {{ $activity->volunteer->email }}
                        </p>
                        @if($activity->volunteer->phone)
                        <p class="text-gray-600 flex items-center gap-2">
                            <i class="fas fa-phone"></i> {{ $activity->volunteer->phone }}
                        </p>
                        @endif
                        <div class="mt-2">
                             <a href="{{ route('organization.volunteers.show', $activity->volunteer->user_id) }}" 
                                class="text-sm text-green-600 hover:underline font-medium">
                                View Full Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Activity Details</h2>
                    <span class="px-4 py-2 rounded-full text-sm font-bold
                        @if($activity->status == 'Pending') bg-yellow-100 text-yellow-800
                        @elseif($activity->status == 'Verified') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ $activity->status }}
                    </span>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b border-gray-100 pb-4">
                        <div>
                            <p class="text-sm text-gray-500">Opportunity</p>
                            <a href="{{ route('organization.opportunities.show', $activity->opportunity->opportunity_id) }}" class="font-medium text-green-600 hover:underline">
                                {{ $activity->opportunity->title }}
                            </a>
                        </div>
                        <div>
                             <p class="text-sm text-gray-500">Activity ID</p>
                             <p class="font-medium text-gray-800">#{{ $activity->activity_id }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b border-gray-100 pb-4">
                        <div>
                            <p class="text-sm text-gray-500">Date Performed</p>
                            <p class="font-medium text-gray-800">{{ $activity->activity_date->format('l, F j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Hours Logged</p>
                            <p class="font-medium text-2xl text-blue-600">{{ number_format($activity->hours_worked, 1) }} hours</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-2">Description</p>
                        <div class="bg-gray-50 p-4 rounded-lg text-gray-700 whitespace-pre-line border border-gray-200">
                            {{ $activity->activity_description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            @if($activity->status != 'Pending')
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Verification Info</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Processed By</p>
                        <p class="font-medium text-gray-800">
                            {{ $activity->verifiedBy->first_name ?? 'System' }} {{ $activity->verifiedBy->last_name ?? '' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Processed Date</p>
                        <p class="font-medium text-gray-800">
                            {{ $activity->verified_date ? $activity->verified_date->format('M d, Y H:i') : 'N/A' }}
                        </p>
                    </div>
                    @if($activity->impact_notes)
                    <div>
                        <p class="text-sm text-gray-500">Notes / Reason</p>
                        <p class="text-sm text-gray-700 mt-1 italic">"{{ $activity->impact_notes }}"</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($activity->status == 'Pending')
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
                <div class="space-y-3">
                    <button onclick="openVerifyModal()" 
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-medium shadow-sm">
                        <i class="fas fa-check-circle"></i> Verify Hours
                    </button>
                    
                    <button onclick="openDisputeModal()" 
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition font-medium">
                        <i class="fas fa-exclamation-circle"></i> Dispute Activity
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-4 text-center">
                    Verifying this activity will add {{ $activity->hours_worked }} hours to the volunteer's profile.
                </p>
            </div>
            @endif

        </div>
    </div>
</div>

<div id="verifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl transform transition-all">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Verify Activity</h3>
        <p class="text-gray-600 mb-4 text-sm">
            Confirm <strong>{{ $activity->hours_worked }} hours</strong> for <strong>{{ $activity->volunteer->first_name }}</strong>?
        </p>
        <form id="verifyForm">
            <textarea id="verifyNotes" 
                      rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent mb-4 text-sm"
                      placeholder="Add an encouraging note (optional)..."></textarea>
            <div class="flex gap-3">
                <button type="button" onclick="closeVerifyModal()" 
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-sm">
                    Confirm Verify
                </button>
            </div>
        </form>
    </div>
</div>

<div id="disputeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl transform transition-all">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Dispute Activity</h3>
        <p class="text-gray-600 mb-4 text-sm">Please provide a reason for rejecting this log.</p>
        <form id="disputeForm">
            <textarea id="disputeReason" 
                      rows="4"
                      required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent mb-4 text-sm"
                      placeholder="Reason for dispute (e.g., incorrect hours, did not show up)..."></textarea>
            <div class="flex gap-3">
                <button type="button" onclick="closeDisputeModal()" 
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition shadow-sm">
                    Confirm Dispute
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Toast Notification Container --}}
<div id="toast" class="fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg opacity-0 transition-all duration-300 pointer-events-none z-50"></div>
@endsection

@push('scripts')
<script>
    const activityId = {{ $activity->activity_id }};

    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = `fixed top-5 right-5 text-white px-4 py-2 rounded-lg shadow-lg transition-all duration-300 pointer-events-none z-50 opacity-100 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
        
        setTimeout(() => {
            toast.classList.remove('opacity-100');
            toast.classList.add('opacity-0');
        }, 3000);
    }

    // --- Modal Functions ---
    function openVerifyModal() { document.getElementById('verifyModal').classList.remove('hidden'); }
    function closeVerifyModal() { document.getElementById('verifyModal').classList.add('hidden'); }
    function openDisputeModal() { document.getElementById('disputeModal').classList.remove('hidden'); }
    function closeDisputeModal() { document.getElementById('disputeModal').classList.add('hidden'); }

    // --- Verify Action ---
    document.getElementById('verifyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const notes = document.getElementById('verifyNotes').value;

        fetch(`/organization/activities/${activityId}/verify`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'verify', impact_notes: notes })
        })
        .then(async response => {
            const data = await response.json().catch(() => ({}));
            if (response.ok) {
                showToast('Activity verified successfully!');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(data.message || 'Failed to verify', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            location.reload(); // Reload safe measure
        });
    });

    // --- Dispute Action ---
    document.getElementById('disputeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const reason = document.getElementById('disputeReason').value;

        if (!reason.trim()) {
            showToast('Please provide a reason', 'error');
            return;
        }

        fetch(`/organization/activities/${activityId}/verify`, { // Dùng chung route verify xử lý logic
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: 'dispute', impact_notes: reason })
        })
        .then(async response => {
            const data = await response.json().catch(() => ({}));
            if (response.ok) {
                showToast('Activity disputed', 'success'); // Có thể đổi màu sang red/info nếu muốn
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(data.message || 'Failed to dispute', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            location.reload();
        });
    });
</script>
@endpush