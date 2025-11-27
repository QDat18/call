@extends('layouts.admin')

@section('title', 'Review Details')
@section('breadcrumb', 'Reviews / Details')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Review Details</h2>
            <p class="text-gray-600 mt-1">Review #{{ $review->review_id }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
            
            @if(!$review->is_approved)
                <form method="POST" action="{{ route('admin.reviews.approve', $review->review_id) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-sm">
                        <i class="fas fa-check mr-2"></i>Approve
                    </button>
                </form>
                <button onclick="openRejectModal('{{ $review->review_id }}')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-sm">
                    <i class="fas fa-times mr-2"></i>Reject
                </button>
            @else
                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-medium border border-green-200">
                    <i class="fas fa-check-circle mr-2"></i>Approved
                </span>
                <button onclick="openRejectModal('{{ $review->review_id }}')" class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition">
                    <i class="fas fa-trash-alt mr-2"></i>Delete
                </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Rating:</span>
                        <div class="flex text-yellow-400 text-lg">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                        <span class="font-bold text-gray-900 ml-2">{{ $review->rating }}.0</span>
                    </div>
                    <span class="text-sm text-gray-500">
                        <i class="far fa-clock mr-1"></i> {{ $review->created_at->format('M d, Y H:i') }}
                    </span>
                </div>
                
                <div class="p-8">
                    @if($review->review_title)
                        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $review->review_title }}</h3>
                    @endif
                    
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {{ $review->review_text ?? 'No written content.' }}
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium">Type:</span> {{ $review->review_type }}
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-thumbs-up text-blue-500 mr-1"></i> {{ $review->helpful_count }} found helpful
                    </div>
                </div>
            </div>

            @if($review->opportunity)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-briefcase text-indigo-600 mr-2"></i> Related Opportunity
                </h3>
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clipboard-list text-indigo-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-md font-bold text-gray-900">{{ $review->opportunity->title }}</h4>
                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $review->opportunity->description }}</p>
                        <div class="mt-3 flex items-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-map-marker-alt mr-1"></i> {{ $review->opportunity->location }}</span>
                            <span><i class="fas fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($review->opportunity->start_date)->format('M Y') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.opportunities.show', $review->opportunity->opportunity_id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        View <i class="fas fa-external-link-alt ml-1"></i>
                    </a>
                </div>
            </div>
            @endif

        </div>

        <div class="space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Reviewer (Author)</h3>
                <div class="flex items-center space-x-4 mb-4">
                    <img src="{{ $review->reviewer->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->reviewer->first_name . ' ' . $review->reviewer->last_name) }}" 
                         class="w-14 h-14 rounded-full object-cover border-2 border-gray-100">
                    <div>
                        <a href="{{ route('admin.users.show', $review->reviewer->user_id) }}" class="text-lg font-bold text-gray-900 hover:text-indigo-600 transition">
                            {{ $review->reviewer->first_name }} {{ $review->reviewer->last_name }}
                        </a>
                        <p class="text-xs text-gray-500">{{ $review->reviewer->email }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">
                            {{ $review->reviewer->user_type }}
                        </span>
                    </div>
                </div>
                
                <div class="border-t border-gray-100 pt-4 mt-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Status</span>
                        <span class="{{ $review->reviewer->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $review->reviewer->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Joined</span>
                        <span class="text-gray-900">{{ $review->reviewer->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Reviewee (Target)</h3>
                <div class="flex items-center space-x-4 mb-4">
                    <img src="{{ $review->reviewee->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->reviewee->first_name . ' ' . $review->reviewee->last_name) }}" 
                         class="w-14 h-14 rounded-full object-cover border-2 border-gray-100">
                    <div>
                        <a href="{{ route('admin.users.show', $review->reviewee->user_id) }}" class="text-lg font-bold text-gray-900 hover:text-indigo-600 transition">
                            {{ $review->reviewee->first_name }} {{ $review->reviewee->last_name }}
                        </a>
                        <p class="text-xs text-gray-500">{{ $review->reviewee->email }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-purple-100 text-purple-800 text-xs rounded-full font-medium">
                            {{ $review->reviewee->user_type }}
                        </span>
                    </div>
                </div>

                @if($review->reviewee->user_type === 'Organization' && $review->reviewee->organization)
                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500 uppercase mb-1">Organization</p>
                    <p class="font-semibold text-gray-900">{{ $review->reviewee->organization->organization_name }}</p>
                </div>
                @endif
            </div>

        </div>
    </div>

    @if(isset($reviewerHistory) && $reviewerHistory->count() > 0)
    <div class="mt-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Other Reviews by {{ $review->reviewer->first_name }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($reviewerHistory as $hist)
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex text-yellow-400 text-xs">
                        @for($i = 1; $i <= 5; $i++) <i class="fas fa-star {{ $i <= $hist->rating ? '' : 'text-gray-300' }}"></i> @endfor
                    </div>
                    <span class="text-xs text-gray-400">{{ $hist->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-gray-700 line-clamp-2">{{ $hist->review_text }}</p>
                <a href="{{ route('admin.reviews.show', $hist->review_id) }}" class="text-xs text-indigo-600 hover:underline mt-2 inline-block">View</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all scale-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i> Reject Review
            </h3>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="p-6">
                <p class="text-gray-600 mb-4 text-sm">Are you sure you want to reject this review? This action will remove it from the public platform.</p>
                
                <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="3" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm placeholder-gray-400"
                          placeholder="e.g. Inappropriate language, Spam, Irrelevant..."></textarea>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-white transition text-sm">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium shadow-sm">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(reviewId) {
        document.getElementById('rejectForm').action = `/admin/reviews/${reviewId}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }
    
    // Close on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('rejectModal');
        if (event.target == modal) {
            closeRejectModal();
        }
    }
</script>
@endpush
@endsection