<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Organization Verification - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    @include('admin.partials.navbar')

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-building mr-3 text-orange-600"></i>
                Organization Verification
            </h1>
            
            {{-- HIỂN THỊ THÔNG BÁO LỖI/THÀNH CÔNG --}}
            @if(session('success'))
                <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Status Tabs (Giữ nguyên) -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('admin.organizations.verification', ['status' => 'Pending']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm
                          {{ $status == 'Pending' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-clock mr-2"></i>
                    Pending ({{ $organizations->total() }})
                </a>
                <a href="{{ route('admin.organizations.verification', ['status' => 'Verified']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm
                          {{ $status == 'Verified' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-check-circle mr-2"></i>
                    Verified
                </a>
                <a href="{{ route('admin.organizations.verification', ['status' => 'Rejected']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm
                          {{ $status == 'Rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="fas fa-times-circle mr-2"></i>
                    Rejected
                </a>
            </nav>
        </div>

        <!-- Organizations List -->
        <div class="space-y-4">
            @forelse($organizations as $org)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-3">
                                <h3 class="text-xl font-bold text-gray-800">{{ $org->organization_name }}</h3>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $org->verification_status == 'Pending' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $org->verification_status == 'Verified' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $org->verification_status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $org->verification_status }}
                                </span>
                            </div>
                            <!-- Info grid (Giữ nguyên) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 mb-4">
                                <div><i class="fas fa-envelope mr-2 text-gray-400"></i>{{ $org->user->email }}</div>
                                <div><i class="fas fa-calendar mr-2 text-gray-400"></i>Submitted: {{ $org->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.organizations.show', $org->org_id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-eye mr-2"></i>View
                        </a>

                        @if($org->verification_status == 'Pending')
                        <button type="button" onclick="openApproveModal('{{ $org->org_id }}')" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-check mr-2"></i>Approve
                        </button>
                        
                        {{-- Nút Reject: Chú ý type="button" để tránh submit form ngoài ý muốn --}}
                        <button type="button" onclick="openRejectModal('{{ $org->org_id }}')" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-times mr-2"></i>Reject
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <p class="text-gray-500">No organizations found.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- ================= MODALS ================= -->

    <!-- 1. Approve Modal -->
    <div id="approveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="backdrop-filter: blur(2px);">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2"></i> Approve Organization
            </h3>
            <p class="text-gray-600 mb-6">Are you sure? This will verify the organization and send them an approval email.</p>
            
            <form id="approveForm" method="POST" action="">
                @csrf
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('approveModal')" 
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancel</button>
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-lg">Confirm Approve</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. Reject Modal (Quan trọng) -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="backdrop-filter: blur(2px);">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-times-circle text-red-600 mr-2"></i> Reject Organization
            </h3>
            
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection <span class="text-red-500">*</span></label>
                    <textarea name="rejection_reason" rows="4" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition"
                              placeholder="Please explain why this application is rejected..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('rejectModal')" 
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancel</button>
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow-lg">Confirm Reject</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Hàm mở modal Reject
        function openRejectModal(orgId) {
            // 1. Tìm form
            const form = document.getElementById('rejectForm');
            if (!form) {
                console.error('Reject form not found!');
                return;
            }
            
            // 2. Cập nhật action URL
            form.action = `/admin/organizations/${orgId}/reject`;
            
            // 3. Hiển thị modal (bỏ class hidden)
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        // Hàm mở modal Approve
        function openApproveModal(orgId) {
            const form = document.getElementById('approveForm');
            form.action = `/admin/organizations/${orgId}/approve`;
            document.getElementById('approveModal').classList.remove('hidden');
        }

        // Hàm đóng modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Đóng khi click ra ngoài
        window.onclick = function(event) {
            const modals = ['approveModal', 'rejectModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target == modal) {
                    closeModal(modalId);
                }
            });
        }
    </script>

</body>
</html>