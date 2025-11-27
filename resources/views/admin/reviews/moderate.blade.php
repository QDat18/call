@extends('layouts.admin')

@section('title', 'Review Moderation')
@section('breadcrumb', 'Reviews')

@section('content')
<div class="space-y-6" x-data="reviewManagement()">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Review Moderation</h2>
            <p class="text-gray-600 mt-1">Manage and moderate user-submitted reviews</p>
        </div>
        
        <div class="flex space-x-3">
            <div x-show="selected.length > 0" x-cloak class="flex space-x-2 animate-fade-in">
                <button @click="bulkAction('approve')" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center shadow-sm">
                    <i class="fas fa-check-double mr-2"></i> Approve (<span x-text="selected.length"></span>)
                </button>
                <button @click="bulkAction('reject')" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center shadow-sm">
                    <i class="fas fa-times mr-2"></i> Reject (<span x-text="selected.length"></span>)
                </button>
            </div>
        </div>
    </div>

    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}"
               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center {{ request('status', 'pending') == 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-clock mr-2"></i> Pending
                @if($pendingCount > 0)
                    <span class="ml-2 bg-yellow-100 text-yellow-600 py-0.5 px-2 rounded-full text-xs">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}"
               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center {{ request('status') == 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-check-circle mr-2"></i> Approved
            </a>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.reviews.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="hidden" name="status" value="{{ request('status', 'pending') }}">
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                           placeholder="Search content, reviewer...">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Min Rating</label>
                <select name="min_rating" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('min_rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                    <option value="4" {{ request('min_rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐+ (4+)</option>
                    <option value="3" {{ request('min_rating') == '3' ? 'selected' : '' }}>⭐⭐⭐+ (3+)</option>
                    <option value="2" {{ request('min_rating') == '2' ? 'selected' : '' }}>⭐⭐+ (2+)</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('admin.reviews.index', ['status' => request('status', 'pending')]) }}" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center">
            <input type="checkbox" @change="toggleAll" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-3">
            <span class="text-sm text-gray-600 font-medium">Select All</span>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($reviews as $review)
            <div class="p-6 hover:bg-gray-50 transition group">
                <div class="flex items-start gap-4">
                    <div class="pt-1">
                        <input type="checkbox" value="{{ $review->review_id }}" x-model="selected" 
                               class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center space-x-3 mb-2">
                                <img src="{{ $review->reviewer->avatar_url ? asset('storage/'.$review->reviewer->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($review->reviewer->first_name) }}" 
                                     class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                <div>
                                    <div class="flex items-center">
                                        <h4 class="text-sm font-bold text-gray-900 mr-2">{{ $review->reviewer->first_name }} {{ $review->reviewer->last_name }}</h4>
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $review->reviewer->user_type }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                        <span>To: <strong>{{ $review->reviewee->first_name }} {{ $review->reviewee->last_name }}</strong></span>
                                        <span class="mx-1">•</span>
                                        <span>{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center bg-yellow-50 px-3 py-1 rounded-full border border-yellow-100">
                                <span class="text-yellow-500 mr-1"><i class="fas fa-star"></i></span>
                                <span class="font-bold text-gray-700">{{ $review->rating }}.0</span>
                            </div>
                        </div>

                        <div class="mt-3 pl-13">
                            @if($review->review_title)
                                <h5 class="text-base font-bold text-gray-800 mb-1">{{ $review->review_title }}</h5>
                            @endif
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $review->review_text }}</p>
                            
                            @if($review->opportunity)
                                <div class="mt-3 flex items-center text-xs text-gray-500 bg-gray-100 px-3 py-2 rounded-lg inline-block">
                                    <i class="fas fa-briefcase mr-1"></i>
                                    Opportunity: <a href="{{ route('admin.opportunities.show', $review->opportunity_id) }}" class="text-indigo-600 hover:underline">{{ $review->opportunity->title }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.reviews.show', $review->review_id) }}" 
                           class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition text-center" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        @if(!$review->is_approved)
                        <button @click="singleAction('{{ $review->review_id }}', 'approve')" 
                                class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="Approve">
                            <i class="fas fa-check"></i>
                        </button>
                        @endif
                        
                        <button @click="openRejectModal('{{ $review->review_id }}')" 
                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Reject/Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No reviews found</h3>
                <p class="text-gray-500 mt-1">Try adjusting your filters or check back later.</p>
            </div>
            @endforelse
        </div>
    </div>

    @if($reviews->hasPages())
    <div class="flex justify-center">
        {{ $reviews->withQueryString()->links() }}
    </div>
    @endif

    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-exclamation-circle text-red-600 mr-2"></i> Reject Review
                    </h3>
                    <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <p class="text-gray-600 mb-4 text-sm">Are you sure you want to reject this review? This will remove it from the platform.</p>
                
                <form id="rejectForm" @submit.prevent="submitReject">
                    <input type="hidden" id="rejectReviewId">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                        <textarea id="rejectReason" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                  placeholder="e.g. Spam, Inappropriate content..."></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRejectModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium shadow-sm">
                            Confirm Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function reviewManagement() {
        return {
            selected: [],
            
            toggleAll(e) {
                if (e.target.checked) {
                    // Lấy tất cả ID của review trên trang hiện tại
                    this.selected = @json($reviews->pluck('review_id'));
                } else {
                    this.selected = [];
                }
            },

            // Hành động đơn lẻ (Approve)
            singleAction(id, action) {
                if (!confirm(`Are you sure you want to ${action} this review?`)) return;

                const url = action === 'approve' 
                    ? `/admin/reviews/${id}/approve`
                    : `/admin/reviews/${id}/reject`; // Reject này dùng cho trường hợp không cần lý do (hoặc dùng modal)

                this.sendRequest(url, { action: action });
            },

            // Hành động hàng loạt (Bulk)
            bulkAction(action) {
                if (this.selected.length === 0) return;
                
                if (!confirm(`Are you sure you want to ${action} ${this.selected.length} reviews?`)) return;

                this.sendRequest('/admin/reviews/bulk-action', {
                    action: action,
                    review_ids: this.selected
                });
            },

            // Hàm gửi request chung
            sendRequest(url, data) {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        if(typeof showToast === 'function') showToast(result.message, 'success');
                        else alert(result.message);
                        
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        if(typeof showToast === 'function') showToast(result.message || 'Error', 'error');
                        else alert(result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                });
            }
        }
    }

    // Modal Functions (Outside Alpine for simplicity with form submit)
    function openRejectModal(reviewId) {
        document.getElementById('rejectReviewId').value = reviewId;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
        document.getElementById('rejectReason').value = '';
    }

    function submitReject(e) {
        const id = document.getElementById('rejectReviewId').value;
        const reason = document.getElementById('rejectReason').value;
        
        fetch(`/admin/reviews/${id}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ reason: reason })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                showToast('Review rejected successfully', 'success');
                closeRejectModal();
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(error => showToast('Error rejecting review', 'error'));
    }
</script>
@endpush
@endsection