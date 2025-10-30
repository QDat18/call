@extends('layouts.app')

@section('title', 'Tìm Cơ Hội Tình Nguyện')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl mb-8 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-8 md:p-12">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Tìm Cơ Hội Tình Nguyện
            </h1>
            <p class="text-xl text-white/90 mb-8">
                Hàng trăm cơ hội đang chờ bạn khám phá
            </p>

            <!-- Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="relative">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Tìm kiếm theo tiêu đề, địa điểm, kỹ năng..."
                               class="w-full px-6 py-4 rounded-xl bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm border-2 border-transparent focus:border-white focus:ring-4 focus:ring-white/20 transition-all text-gray-800 dark:text-white placeholder-gray-500 dark:placeholder-gray-400">
                        <i class="fas fa-search absolute right-6 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button type="submit" 
                            class="px-8 py-4 bg-white text-indigo-600 font-semibold rounded-xl hover:bg-gray-50 transform hover:scale-105 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-search mr-2"></i>
                        Tìm Kiếm
                    </button>
                    <a href="{{ route('search.advanced') }}" 
                       class="px-6 py-4 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-xl hover:bg-white/30 transition-all border-2 border-white/20 hover:border-white/40 text-center">
                        <i class="fas fa-sliders-h mr-2"></i>
                        Nâng Cao
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="glass dark:glass-dark rounded-2xl border border-gray-200/50 dark:border-gray-700/50 p-6 mb-8">
        <form action="{{ route('opportunities.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-th-large text-indigo-600 mr-2"></i>
                        Danh Mục
                    </label>
                    <select name="category" 
                            class="w-full px-4 py-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        <option value="">Tất cả</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->category_id }}" 
                                    {{ request('category') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Location Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                        Địa Điểm
                    </label>
                    <select name="location" 
                            class="w-full px-4 py-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        <option value="">Tất cả</option>
                        <option value="Hà Nội" {{ request('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                        <option value="Hồ Chí Minh" {{ request('location') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                        <option value="Đà Nẵng" {{ request('location') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                    </select>
                </div>

                <!-- Time Commitment -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-clock text-orange-600 mr-2"></i>
                        Thời Gian
                    </label>
                    <select name="time_commitment" 
                            class="w-full px-4 py-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        <option value="">Tất cả</option>
                        <option value="1-2 hours" {{ request('time_commitment') == '1-2 hours' ? 'selected' : '' }}>1-2 giờ</option>
                        <option value="3-5 hours" {{ request('time_commitment') == '3-5 hours' ? 'selected' : '' }}>3-5 giờ</option>
                        <option value="Full day" {{ request('time_commitment') == 'Full day' ? 'selected' : '' }}>Cả ngày</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-filter mr-2"></i>
                        Áp Dụng Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Tìm thấy <span class="text-indigo-600">{{ $opportunities->total() }}</span> cơ hội
        </h2>
        
        <div class="flex items-center gap-3">
            <label class="text-sm text-gray-600 dark:text-gray-400">Sắp xếp:</label>
            <select onchange="window.location.href=this.value" 
                    class="px-4 py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 text-sm">
                <option value="?sort=latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                <option value="?sort=popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến</option>
                <option value="?sort=deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Hạn nộp đơn</option>
            </select>
        </div>
    </div>

    <!-- Opportunities Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($opportunities as $opportunity)
            <div class="group relative glass dark:glass-dark rounded-2xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden hover-lift transition-all duration-300">
                
                <!-- Card Header -->
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold text-white" 
                              style="background: linear-gradient(135deg, {{ $opportunity->category->color ?? '#6366f1' }}, {{ $opportunity->category->color ?? '#8b5cf6' }});">
                            <i class="{{ $opportunity->category->icon ?? 'fas fa-heart' }} mr-1"></i>
                            {{ $opportunity->category->category_name ?? 'General' }}
                        </span>
                        
                        @auth
                            @if(auth()->user()->user_type === 'Volunteer')
                                <button class="favorite-btn p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" 
                                        data-opportunity-id="{{ $opportunity->opportunity_id }}">
                                    <i class="far fa-heart text-red-500 text-lg"></i>
                                </button>
                            @endif
                        @endauth
                    </div>

                    <!-- Title -->
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-3 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}">
                            {{ $opportunity->title }}
                        </a>
                    </h3>

                    <!-- Organization -->
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-gray-600 dark:text-gray-300 text-xs"></i>
                        </div>
                        <a href="{{ route('organizations.show', $opportunity->org_id) }}" 
                           class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            {{ Str::limit($opportunity->organization->organization_name, 30) }}
                        </a>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                        {{ Str::limit($opportunity->description, 100) }}
                    </p>

                    <!-- Meta Info -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs">
                            <i class="fas fa-map-marker-alt mr-1.5"></i>
                            {{ Str::limit($opportunity->location, 15) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 text-xs">
                            <i class="fas fa-calendar mr-1.5"></i>
                            {{ \Carbon\Carbon::parse($opportunity->start_date)->format('d/m/Y') }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300 text-xs">
                            <i class="fas fa-clock mr-1.5"></i>
                            {{ $opportunity->time_commitment }}
                        </span>
                    </div>

                    <!-- Stats -->
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <div class="flex items-center gap-1.5">
                            <i class="fas fa-users"></i>
                            <span>{{ $opportunity->volunteers_registered }}/{{ $opportunity->volunteers_needed }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="fas fa-eye"></i>
                            <span>{{ $opportunity->view_count }}</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    @php
                        $percentage = $opportunity->volunteers_needed > 0 
                            ? ($opportunity->volunteers_registered / $opportunity->volunteers_needed) * 100 
                            : 0;
                    @endphp
                    <div class="mb-4">
                        <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-500" 
                                 style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                       class="block w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-center font-semibold rounded-xl transform group-hover:scale-105 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Xem Chi Tiết
                    </a>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-span-full">
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-4xl text-gray-400 dark:text-gray-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-3">
                        Không tìm thấy cơ hội phù hợp
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Hãy thử thay đổi bộ lọc hoặc tìm kiếm với từ khóa khác
                    </p>
                    <a href="{{ route('opportunities.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all shadow-lg">
                        <i class="fas fa-th mr-2"></i>
                        Xem Tất Cả Cơ Hội
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($opportunities->hasPages())
        <div class="flex justify-center mt-8">
            <div class="glass dark:glass-dark rounded-xl border border-gray-200/50 dark:border-gray-700/50 p-2">
                {{ $opportunities->links() }}
            </div>
        </div>
    @endif

</div>

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .favorite-btn.active i {
        color: #EF4444 !important;
        font-weight: 900;
    }
    
    .favorite-btn.active i::before {
        content: "\f004";
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Favorite functionality
    $('.favorite-btn').click(function(e) {
        e.preventDefault();
        const btn = $(this);
        const opportunityId = btn.data('opportunity-id');
        
        $.ajax({
            url: '{{ route("api.favorites.toggle") }}',
            method: 'POST',
            data: {
                opportunity_id: opportunityId
            },
            success: function(response) {
                if (response.success) {
                    btn.toggleClass('active');
                    
                    const message = response.action === 'added' 
                        ? 'Đã thêm vào yêu thích' 
                        : 'Đã xóa khỏi yêu thích';
                    
                    showToast(message, 'success');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    showToast('Vui lòng đăng nhập để lưu cơ hội', 'error');
                    setTimeout(() => {
                        window.location.href = '{{ route("login") }}';
                    }, 1500);
                } else {
                    showToast('Có lỗi xảy ra', 'error');
                }
            }
        });
    });
});
</script>
@endpush
@endsection