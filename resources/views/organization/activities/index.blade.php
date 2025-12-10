@extends('layouts.organization')

@section('title', 'Volunteer Activities')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Volunteer Activities</h1>
        <p class="text-gray-600 mt-1">Track and verify volunteer hours</p>
    </div>

    {{-- ... (Giữ nguyên phần thống kê) ... --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        {{-- ... Cards ... --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Hours</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_hours'] ?? 0) }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        {{-- ... Các card khác tương tự, thêm ?? 0 để tránh lỗi null ... --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pending Verification</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</p>
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
                    <p class="text-gray-600 text-sm">Verified</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['verified'] ?? 0 }}</p>
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
                    <p class="text-gray-600 text-sm">Disputed</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['disputed'] ?? 0 }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                     <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                 <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search volunteer..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Verified" {{ request('status') == 'Verified' ? 'selected' : '' }}>Verified</option>
                        <option value="Disputed" {{ request('status') == 'Disputed' ? 'selected' : '' }}>Disputed</option>
                    </select>
                </div>
                <div>
                     <select name="opportunity" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Opportunities</option>
                        @foreach($opportunities as $opp)
                        <option value="{{ $opp->opportunity_id }}" {{ request('opportunity') == $opp->opportunity_id ? 'selected' : '' }}>
                            {{ Str::limit($opp->title, 40) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                 <div>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="From date">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">Filter</button>
                    <a href="{{ route('organization.activities.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow">
        @if($activities->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volunteer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opportunity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($activities as $activity)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    {{-- FIX: Logic Avatar --}}
                                    @php
                                        $avatar = $activity->volunteer->avatar_url 
                                            ? asset('storage/' . $activity->volunteer->avatar_url) 
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($activity->volunteer->first_name . ' ' . $activity->volunteer->last_name) . '&background=random';
                                    @endphp
                                    <img src="{{ $avatar }}" 
                                         alt="{{ $activity->volunteer->first_name }}"
                                         class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $activity->volunteer->first_name }} {{ $activity->volunteer->last_name }}
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $activity->volunteer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-800">{{ Str::limit($activity->opportunity->title, 40) }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $activity->activity_date->format('M d, Y') }}
                                <br>
                                <span class="text-xs text-gray-500">{{ $activity->activity_date->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-lg font-bold text-blue-600">{{ $activity->hours_worked }}h</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($activity->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($activity->status == 'Verified') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $activity->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if($activity->status == 'Pending')
                                    <button onclick="verifyActivity({{ $activity->activity_id }})"
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition">
                                        Verify
                                    </button>
                                    <button onclick="disputeActivity({{ $activity->activity_id }})"
                                            class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-sm rounded-lg transition">
                                        Dispute
                                    </button>
                                    @else
                                    {{-- FIX LINK: Dùng đúng route trong web.php --}}
                                    <a href="{{ route('organization.activities.show', $activity->activity_id) }}" 
                                       class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition">
                                        View
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $activities->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                 <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No activities found</h3>
                <p class="text-gray-600 mb-4">
                    @if(request('search') || request('status') || request('opportunity'))
                        Try adjusting your filters
                    @else
                        Activities will appear here once volunteers log their hours
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<div id="verifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Verify Activity</h3>
        <p class="text-gray-600 mb-4">Are you sure you want to verify this volunteer activity?</p>
        <form id="verifyForm">
            <textarea id="verifyNotes" 
                      rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent mb-4"
                      placeholder="Add verification notes (optional)..."></textarea>
            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeVerifyModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    Verify
                </button>
            </div>
        </form>
    </div>
</div>

<div id="disputeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Dispute Activity</h3>
        <p class="text-gray-600 mb-4">Please provide a reason for disputing this activity:</p>
        <form id="disputeForm">
            <textarea id="disputeReason" 
                      rows="4"
                      required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent mb-4"
                      placeholder="Explain why you're disputing this activity..."></textarea>
            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeDisputeModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                    Dispute
                </button>
            </div>
        </form>
    </div>
</div>

<div id="toast" class="fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg opacity-0 transition-all duration-300 pointer-events-none z-50"></div>

@endsection

@push('scripts')
<script>
let currentActivityId = null;

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.remove('opacity-0', 'bg-green-600', 'bg-red-600');
    toast.classList.add(type === 'success' ? 'bg-green-600' : 'bg-red-600', 'opacity-100');
    
    setTimeout(() => {
        toast.classList.remove('opacity-100');
        toast.classList.add('opacity-0');
    }, 3000);
}

function verifyActivity(activityId) {
    currentActivityId = activityId;
    document.getElementById('verifyModal').classList.remove('hidden');
}

function closeVerifyModal() {
    document.getElementById('verifyModal').classList.add('hidden');
    currentActivityId = null;
}

document.getElementById('verifyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const notes = document.getElementById('verifyNotes').value;

    // FIX AJAX: Gửi đúng cấu trúc cho Controller (action + impact_notes)
    fetch(`/organization/activities/${currentActivityId}/verify`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            action: 'verify', 
            impact_notes: notes 
        })
    })
    .then(async response => {
        // Xử lý cả response lỗi và thành công
        const data = await response.json().catch(() => ({})); 
        if (response.ok) { // Check status 200-299
             // Nếu controller redirect back()->with('success'), fetch thường trả về trang HTML của redirect
             // Tuy nhiên nếu API trả JSON thì tốt hơn. Ở đây giả định controller redirect nên ta reload.
             // Để UX tốt nhất, controller nên trả JSON. Nếu controller trả redirect, ta reload trang.
            showToast('Activity verified successfully!');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to verify activity', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Nếu server trả về redirect (HTML), fetch có thể coi là lỗi parse JSON nhưng thực tế là thành công
        // Tạm thời reload để an toàn
        location.reload(); 
    });
});

function disputeActivity(activityId) {
    currentActivityId = activityId;
    document.getElementById('disputeModal').classList.remove('hidden');
}

function closeDisputeModal() {
    document.getElementById('disputeModal').classList.add('hidden');
    currentActivityId = null;
}

document.getElementById('disputeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const reason = document.getElementById('disputeReason').value;

    if (!reason.trim()) {
        showToast('Please provide a reason', 'error');
        return;
    }

    // FIX AJAX: Gửi đúng cấu trúc cho Controller
    fetch(`/organization/activities/${currentActivityId}/verify`, { // Dùng chung route verify nếu controller xử lý cả 2 action
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            action: 'dispute', 
            impact_notes: reason 
        })
    })
    .then(async response => {
        const data = await response.json().catch(() => ({}));
        if (response.ok) {
            showToast('Activity disputed');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to dispute activity', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload();
    });
});
</script>
@endpush