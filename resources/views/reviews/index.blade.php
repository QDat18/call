@extends('layouts.app')

@section('title', 'Reviews & Ratings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reviews & Ratings</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">See what volunteers and organizations are saying</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Reviews</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Average Rating</p>
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">
                        {{ number_format($stats['average'], 1) }}
                        <span class="text-sm text-gray-500">/5.0</span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star-half-alt text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">By Volunteers</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $stats['volunteer_reviews'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">By Organizations</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ $stats['organization_reviews'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-building text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Review Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-filter mr-1"></i> Review Type
                </label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Reviews</option>
                    <option value="volunteer" {{ request('type') == 'volunteer' ? 'selected' : '' }}>By Volunteers</option>
                    <option value="organization" {{ request('type') == 'organization' ? 'selected' : '' }}>By Organizations</option>
                </select>
            </div>

            <!-- Rating Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-star mr-1"></i> Rating
                </label>
                <select name="rating" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-sort mr-1"></i> Sort By
                </label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most Recent</option>
                    <option value="helpful" {{ request('sort') == 'helpful' ? 'selected' : '' }}>Most Helpful</option>
                    <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>Highest Rating</option>
                    <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Lowest Rating</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    <i class="fas fa-search mr-2"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Rating Distribution -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Rating Distribution</h2>
        <div class="space-y-3">
            @for($i = 5; $i >= 1; $i--)
            @php
                $count = $stats['rating_distribution'][$i] ?? 0;
                $percentage = $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0;
            @endphp
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1 w-20">
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $i }}</span>
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                </div>
                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    <div class="bg-yellow-400 h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-400 w-16 text-right">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
            </div>
            @endfor
        </div>
    </div>

    <!-- Reviews List -->
    <div class="space-y-6">
        @forelse($reviews as $review)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-start gap-4">
                        <img src="{{ $review->reviewer->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($review->reviewer->first_name.' '.$review->reviewer->last_name).'&background=059669&color=fff' }}" 
                            alt="Avatar" class="w-12 h-12 rounded-full">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                {{ $review->reviewer->first_name }} {{ $review->reviewer->last_name }}
                                @if($review->review_type === 'Volunteer to Organization')
                                    <span class="text-xs text-green-600 dark:text-green-400 ml-2">
                                        <i class="fas fa-user-check"></i> Volunteer
                                    </span>
                                @else
                                    <span class="text-xs text-blue-600 dark:text-blue-400 ml-2">
                                        <i class="fas fa-building"></i> Organization
                                    </span>
                                @endif
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                reviewed 
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $review->reviewee->first_name }} {{ $review->reviewee->last_name }}
                                </span>
                            </p>
                            @if($review->opportunity)
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                <i class="fas fa-clipboard-list mr-1"></i> {{ $review->opportunity->title }}
                            </p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <!-- Star Rating -->
                        <div class="flex items-center gap-1 mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Review Content -->
                @if($review->review_title)
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $review->review_title }}</h4>
                @endif
                
                @if($review->review_text)
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $review->review_text }}</p>
                @endif

                <!-- Footer Actions -->
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <button onclick="markHelpful({{ $review->review_id }})" 
                            class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition">
                            <i class="fas fa-thumbs-up"></i>
                            <span>Helpful ({{ $review->helpful_count }})</span>
                        </button>
                        
                        @auth
                        @if(Auth::id() === $review->reviewer_id || Auth::user()->role === 'Admin')
                        <button onclick="reportReview({{ $review->review_id }})" 
                            class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition">
                            <i class="fas fa-flag"></i>
                            <span>Report</span>
                        </button>
                        @endif
                        @endauth
                    </div>

                    @if(!$review->is_approved)
                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-xs rounded-full">
                        Pending Approval
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
            <i class="fas fa-star text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Reviews Yet</h3>
            <p class="text-gray-600 dark:text-gray-400">Be the first to leave a review!</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
    <div class="mt-8">
        {{ $reviews->links() }}
    </div>
    @endif

</div>

@push('scripts')
<script>
function markHelpful(reviewId) {
    fetch(`/reviews/${reviewId}/helpful`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('Failed to mark as helpful', 'error');
    });
}

function reportReview(reviewId) {
    if (!confirm('Are you sure you want to report this review?')) return;
    
    fetch(`/reviews/${reviewId}/report`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('Failed to report review', 'error');
    });
}
</script>
@endpush
@endsection