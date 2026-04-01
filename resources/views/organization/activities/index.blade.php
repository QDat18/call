@extends('layouts.organization')

@section('title', 'Volunteer Activities')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Volunteer Activities</h1>
                <p class="text-gray-600 mt-1">Track and verify volunteer hours</p>
            </div>
            <button onclick="openImportModal()"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Import Excel
            </button>
            {{-- Dán code nút bấm bạn chọn vào đây --}}
            <button onclick="openLogModal()"
                class="group flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:ring-4 focus:ring-blue-200">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-90 duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Log Hours</span>
            </button>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow mb-6">
            <form method="GET" class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search volunteer..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <select name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Verified" {{ request('status') == 'Verified' ? 'selected' : '' }}>Verified</option>
                            <option value="Disputed" {{ request('status') == 'Disputed' ? 'selected' : '' }}>Disputed</option>
                        </select>
                    </div>
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
                    <div>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="From date">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">Filter</button>
                        <a href="{{ route('organization.activities.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Reset</a>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Volunteer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Opportunity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
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
                                            <img src="{{ $avatar }}" alt="{{ $activity->volunteer->first_name }}"
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
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
    <div id="logModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4 shadow-xl">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Log Volunteer Hours</h3>
            <p class="text-gray-600 mb-4 text-sm">Manually add hours for a volunteer. These will be automatically verified.
            </p>

            <form id="logForm">
                <div class="space-y-4">
                    {{-- Chọn Opportunity --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Opportunity</label>
                        <select name="opportunity_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Opportunity</option>
                            @foreach($opportunities as $opp)
                                <option value="{{ $opp->opportunity_id }}">{{ Str::limit($opp->title, 50) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Chọn Volunteer --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Volunteer</label>
                        <select name="volunteer_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Volunteer</option>
                            @foreach($volunteers as $vol)
                                <option value="{{ $vol->user_id }}">{{ $vol->first_name }} {{ $vol->last_name }}
                                    ({{ $vol->email }})</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Only displaying volunteers accepted into your opportunities.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Date --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="activity_date" required max="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        {{-- Hours --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hours</label>
                            <input type="number" name="hours_worked" required step="0.5" min="0.5" max="24"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                        <textarea name="description" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g. Completed assigned tasks successfully"></textarea>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeLogModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        Submit Log
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="verifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Verify Activity</h3>
            <p class="text-gray-600 mb-4">Are you sure you want to verify this volunteer activity?</p>
            <form id="verifyForm">
                <textarea id="verifyNotes" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent mb-4"
                    placeholder="Add verification notes (optional)..."></textarea>
                <div class="flex gap-3">
                    <button type="button" onclick="closeVerifyModal()"
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
                <textarea id="disputeReason" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent mb-4"
                    placeholder="Explain why you're disputing this activity..."></textarea>
                <div class="flex gap-3">
                    <button type="button" onclick="closeDisputeModal()"
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

    <div id="toast"
        class="fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg opacity-0 transition-all duration-300 pointer-events-none z-50">
    </div>
    <div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Import Activities</h3>
            <p class="text-gray-600 mb-4 text-sm">Upload an Excel file to log hours in bulk.</p>

            <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                <p class="text-sm text-blue-800 mb-2 font-medium">1. Download Template</p>
                <a href="{{ route('organization.activities.import.template') }}"
                    class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download log_hours_template.xlsx
                </a>
            </div>

            <form id="importForm" enctype="multipart/form-data">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">2. Upload File</label>
                    <input type="file" name="file" accept=".xlsx, .xls, .csv" required
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeImportModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        Upload & Process
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentActivityId = null;

        // --- TOAST NOTIFICATION ---
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            // Reset classes
            toast.className = 'fixed top-5 right-5 px-4 py-2 rounded-lg shadow-lg transition-all duration-300 pointer-events-none z-50 opacity-0 transform translate-y-[-20px]';

            // Set content and type color
            toast.textContent = message;
            if (type === 'success') {
                toast.classList.add('bg-green-600', 'text-white');
            } else if (type === 'error') {
                toast.classList.add('bg-red-600', 'text-white');
            } else {
                toast.classList.add('bg-blue-600', 'text-white');
            }

            // Show toast
            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-[-20px]');
                toast.classList.add('opacity-100', 'translate-y-0');
            });

            // Hide after 3s
            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'translate-y-[-20px]');
            }, 3000);
        }

        // --- VERIFY & DISPUTE MODAL ---
        function verifyActivity(activityId) {
            currentActivityId = activityId;
            document.getElementById('verifyModal').classList.remove('hidden');
        }

        function closeVerifyModal() {
            document.getElementById('verifyModal').classList.add('hidden');
            document.getElementById('verifyForm').reset();
            currentActivityId = null;
        }

        function disputeActivity(activityId) {
            currentActivityId = activityId;
            document.getElementById('disputeModal').classList.remove('hidden');
        }

        function closeDisputeModal() {
            document.getElementById('disputeModal').classList.add('hidden');
            document.getElementById('disputeForm').reset();
            currentActivityId = null;
        }

        // Handle Verify Submit
        document.getElementById('verifyForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const notes = document.getElementById('verifyNotes').value;
            submitActivityAction('verify', notes);
        });

        // Handle Dispute Submit
        document.getElementById('disputeForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const reason = document.getElementById('disputeReason').value;
            if (!reason.trim()) {
                showToast('Please provide a reason', 'error');
                return;
            }
            submitActivityAction('dispute', reason);
        });

        // Common function for Verify/Dispute
        function submitActivityAction(action, note) {
            if (!currentActivityId) return;

            fetch(`/organization/activities/${currentActivityId}/verify`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ action: action, impact_notes: note })
            })
                .then(async response => {
                    const data = await response.json().catch(() => ({}));
                    if (response.ok) {
                        showToast(data.message || `Activity ${action}ed successfully!`, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(data.message || 'Action failed', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred', 'error');
                });
        }

        // --- LOG HOURS MODAL ---
        function openLogModal() {
            document.getElementById('logModal').classList.remove('hidden');
        }

        function closeLogModal() {
            document.getElementById('logModal').classList.add('hidden');
            document.getElementById('logForm').reset();
        }

        document.getElementById('logForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = Object.fromEntries(new FormData(this).entries());
            const btn = this.querySelector('button[type="submit"]');

            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

            fetch("{{ route('organization.activities.log') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(async response => {
                    const result = await response.json().catch(() => ({}));
                    if (response.ok) {
                        showToast(result.message || 'Hours logged successfully', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(result.message || 'Failed to log hours', 'error');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred', 'error');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        });

        // --- IMPORT MODAL ---
        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
            document.getElementById('importForm').reset();
        }

        document.getElementById('importForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerText;

            btn.disabled = true;
            btn.innerText = 'Uploading...';

            fetch("{{ route('organization.activities.import') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(async response => {
                    const result = await response.json().catch(() => ({}));
                    if (response.ok) {
                        if (result.warning) {
                            alert(result.message); // Show detailed warning
                        } else {
                            showToast(result.message || 'Import successful', 'success');
                        }
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(result.message || 'Import failed', 'error');
                        btn.disabled = false;
                        btn.innerText = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An network error occurred', 'error');
                    btn.disabled = false;
                    btn.innerText = originalText;
                });
        });
    </script>
@endpush