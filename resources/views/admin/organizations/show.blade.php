@extends('layouts.admin')

@section('title', 'Chi Tiết Tổ Chức')
@section('breadcrumb', 'Organizations / Details')

@section('content')
<div class="space-y-6">
    
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.organizations.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
        </a>
    </div>
    
    <!-- Organization Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Cover -->
        <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
        
        <!-- Profile Info -->
        <div class="px-8 pb-8">
            <div class="flex items-end justify-between -mt-16 mb-6">
                <div class="flex items-end space-x-4">
                    <img src="{{ $organization->logo_url ? asset('storage/' . $organization->logo_url) : 'https://ui-avatars.com/api/?name=' . urlencode($organization->organization_name) }}" 
                         class="w-32 h-32 rounded-lg border-4 border-white shadow-lg bg-white object-cover" alt="Logo">
                    <div class="pb-2">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $organization->organization_name }}</h1>
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full
                                {{ $organization->verification_status == 'Verified' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $organization->verification_status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $organization->verification_status == 'Rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                <i class="fas fa-{{ $organization->verification_status == 'Verified' ? 'check-circle' : ($organization->verification_status == 'Pending' ? 'clock' : 'times-circle') }} mr-1"></i>
                                {{ $organization->verification_status }}
                            </span>
                            <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
                                {{ $organization->organization_type }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    @if($organization->verification_status == 'Pending')
                    {{-- Nút Duyệt --}}
                    <button type="button" onclick="openApproveModal('{{ $organization->org_id }}')" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-sm flex items-center">
                        <i class="fas fa-check mr-2"></i>Approve
                    </button>
                    
                    {{-- Nút Từ chối --}}
                    <button type="button" onclick="openRejectModal('{{ $organization->org_id }}')" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-sm flex items-center">
                        <i class="fas fa-times mr-2"></i>Reject
                    </button>
                    @endif
                    
                    {{-- Nút Xóa --}}
                    <button type="button" onclick="openDeleteModal('{{ $organization->org_id }}')" 
                            class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition flex items-center">
                        <i class="fas fa-trash-alt mr-2"></i>Delete
                    </button>
                </div>
            </div>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $organization->volunteer_count }}</div>
                    <div class="text-sm text-gray-600">Volunteers</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $organization->total_opportunities }}</div>
                    <div class="text-sm text-gray-600">Opportunities</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($organization->rating, 1) }}</div>
                    <div class="text-sm text-gray-600">Rating</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $organization->founded_year ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-600">Founded</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- LEFT COLUMN - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- About -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">About</h3>
                @if($organization->description)
                <p class="text-gray-700 leading-relaxed mb-4 whitespace-pre-line">{{ $organization->description }}</p>
                @else
                <p class="text-gray-500 italic">No description provided</p>
                @endif
                
                @if($organization->mission_statement)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Mission Statement</h4>
                    <p class="text-gray-700 italic">{{ $organization->mission_statement }}</p>
                </div>
                @endif
            </div>

            <!-- === VERIFICATION DOCUMENT (Tài liệu xác thực) === -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-file-contract text-indigo-600 mr-2"></i>Verification Document
                </h3>
                
                @if($organization->registration_document)
                    @php
                        $docPath = $organization->registration_document;
                        // Nếu đường dẫn trong DB chưa có 'storage/' thì thêm vào
                        $docUrl = Str::startsWith($docPath, 'storage/') ? asset($docPath) : asset('storage/' . $docPath);
                        $extension = pathinfo($docPath, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    @endphp

                    <div class="border rounded-lg p-4 bg-gray-50">
                        @if($isImage)
                            {{-- Hiển thị ảnh preview --}}
                            <div class="mb-4 text-center">
                                <a href="{{ $docUrl }}" target="_blank">
                                    <img src="{{ $docUrl }}" alt="Verification Document" 
                                         class="max-w-full h-auto max-h-96 rounded border border-gray-200 shadow-sm hover:opacity-95 transition cursor-zoom-in mx-auto">
                                </a>
                            </div>
                        @else
                            {{-- Hiển thị icon cho PDF/Doc --}}
                            <div class="flex items-center justify-center p-6 bg-white rounded border border-gray-200 mb-4">
                                <i class="fas fa-file-pdf text-5xl text-red-500 mr-4"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Document File</p>
                                    <p class="text-sm text-gray-500">{{ strtoupper($extension) }} File</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-center space-x-3">
                            <a href="{{ $docUrl }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                <i class="fas fa-external-link-alt mr-2"></i>View Full Size
                            </a>
                            <a href="{{ $docUrl }}" download class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-sm">
                                <i class="fas fa-download mr-2"></i>Download
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <i class="fas fa-file-excel text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500 italic">No verification document uploaded.</p>
                    </div>
                @endif
            </div>
            
            <!-- Recent Opportunities -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Opportunities</h3>
                    <a href="{{ route('admin.opportunities.index', ['organization' => $organization->organization_name]) }}" 
                       class="text-sm text-indigo-600 hover:text-indigo-800">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="space-y-3">
                    @forelse($organization->opportunities()->latest()->take(5)->get() as $opp)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ Str::limit($opp->title, 50) }}</h4>
                            <div class="flex items-center space-x-3 mt-1 text-xs text-gray-500">
                                <span><i class="fas fa-calendar mr-1"></i>{{ $opp->start_date ? $opp->start_date->format('M d, Y') : 'N/A' }}</span>
                                <span><i class="fas fa-users mr-1"></i>{{ $opp->application_count }} applications</span>
                                <span class="px-2 py-0.5 rounded-full text-xs
                                    {{ $opp->status == 'Active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $opp->status == 'Paused' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $opp->status == 'Completed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ $opp->status }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('admin.opportunities.show', $opp->opportunity_id) }}" 
                           class="ml-3 text-indigo-600 hover:text-indigo-800">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">No opportunities posted yet</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- RIGHT COLUMN - Additional Info -->
        <div class="space-y-6">
            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                <div class="space-y-3">
                    @if($organization->contact_person)
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-user w-5 mr-3 text-gray-400"></i>
                        <div>
                            <p class="text-xs text-gray-500">Contact Person</p>
                            <p class="text-sm font-medium">{{ $organization->contact_person }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-envelope w-5 mr-3 text-gray-400"></i>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="text-sm font-medium break-all">{{ $organization->user->email }}</p>
                        </div>
                    </div>
                    
                    @if($organization->user->phone)
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-phone w-5 mr-3 text-gray-400"></i>
                        <div>
                            <p class="text-xs text-gray-500">Phone</p>
                            <p class="text-sm font-medium">{{ $organization->user->phone }}</p>
                        </div>
                    </div>
                    @endif

                    @if($organization->website)
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-globe w-5 mr-3 text-gray-400"></i>
                        <div>
                            <p class="text-xs text-gray-500">Website</p>
                            <a href="{{ $organization->website }}" target="_blank" 
                               class="text-sm font-medium text-indigo-600 hover:underline break-all">
                                {{ $organization->website }}
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($organization->user->address)
                    <div class="flex items-start text-gray-700">
                        <i class="fas fa-map-marker-alt w-5 mr-3 text-gray-400 mt-1"></i>
                        <div>
                            <p class="text-xs text-gray-500">Address</p>
                            <p class="text-sm font-medium">{{ $organization->user->address }}</p>
                            <p class="text-xs text-gray-500">{{ $organization->user->city }}, {{ $organization->user->district }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Organization Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Organization Details</h3>
                <div class="space-y-3">
                    @if($organization->registration_number)
                    <div>
                        <p class="text-xs text-gray-500">Registration Number</p>
                        <p class="text-sm font-medium text-gray-900">{{ $organization->registration_number }}</p>
                    </div>
                    @endif
                    
                    @if($organization->founded_year)
                    <div>
                        <p class="text-xs text-gray-500">Founded Year</p>
                        <p class="text-sm font-medium text-gray-900">{{ $organization->founded_year }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-xs text-gray-500">Organization Type</p>
                        <p class="text-sm font-medium text-gray-900">{{ $organization->organization_type }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500">Member Since</p>
                        <p class="text-sm font-medium text-gray-900">{{ $organization->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Account Status -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Status</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            {{ $organization->user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $organization->user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Email Verified</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            {{ $organization->user->is_verified ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $organization->user->is_verified ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    
                    @if($organization->user->last_login_at)
                    <div>
                        <p class="text-xs text-gray-500">Last Login</p>
                        <p class="text-sm font-medium text-gray-900">{{ $organization->user->last_login_at->diffForHumans() }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= MODALS (HỘP THOẠI) ================= -->

<!-- 1. Approve Modal -->
<div id="approveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="backdrop-filter: blur(2px);">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-check-circle text-green-600 mr-2"></i> Approve Organization
        </h3>
        <p class="text-gray-600 mb-6">Are you sure you want to approve <strong>{{ $organization->organization_name }}</strong>?</p>
        <p class="text-sm text-gray-500 mb-6">An email notification will be sent to the organization.</p>
        
        <form id="approveForm" method="POST" action="">
            @csrf
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('approveModal')" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Cancel</button>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-lg transition">Confirm Approve</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="backdrop-filter: blur(2px);">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-times-circle text-red-600 mr-2"></i> Reject Organization
        </h3>
        <p class="text-gray-600 mb-4">Please provide a reason for rejecting this organization.</p>
        
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason <span class="text-red-500">*</span></label>
                <textarea name="rejection_reason" rows="4" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition"
                          placeholder="e.g., Incomplete documentation, invalid registration number..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('rejectModal')" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Cancel</button>
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow-lg transition">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="backdrop-filter: blur(2px);">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl transform transition-all">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-trash-alt text-red-600 mr-2"></i> Delete Organization
        </h3>
        <p class="text-gray-600 mb-2">Are you sure you want to delete <strong>{{ $organization->organization_name }}</strong>?</p>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">
                        Warning: This action cannot be undone. All related data (opportunities, activities) will also be deleted.
                    </p>
                </div>
            </div>
        </div>
        
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('deleteModal')" 
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Cancel</button>
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow-lg transition">Delete Permanently</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // === JAVASCRIPT XỬ LÝ MODAL ===

    // Mở Modal Duyệt
    function openApproveModal(orgId) {
        const form = document.getElementById('approveForm');
        form.action = `/admin/organizations/${orgId}/approve`;
        
        const modal = document.getElementById('approveModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex'); // Thêm flex để căn giữa
    }

    // Mở Modal Từ chối
    function openRejectModal(orgId) {
        const form = document.getElementById('rejectForm');
        form.action = `/admin/organizations/${orgId}/reject`;
        
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Mở Modal Xóa
    function openDeleteModal(orgId) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/organizations/${orgId}`; // Route delete
        
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Đóng Modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Đóng khi click ra ngoài vùng modal (overlay)
    window.onclick = function(event) {
        const modals = ['approveModal', 'rejectModal', 'deleteModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target == modal) {
                closeModal(modalId);
            }
        });
    }
</script>
@endpush
@endsection