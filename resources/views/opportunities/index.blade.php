@extends('layouts.app')

@section('title', 'Cơ hội tình nguyện')

@section('content')
<div class="min-h-screen bg-gray-50">
    
    {{-- HERO SECTION --}}
    <div class="relative bg-indigo-700 overflow-hidden mb-12">
        <div class="absolute inset-0 opacity-20">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">Kết nối trái tim, Lan tỏa yêu thương</h1>
            <p class="text-indigo-100 text-lg max-w-2xl mx-auto mb-8">
                Tìm kiếm hàng trăm cơ hội tình nguyện ý nghĩa và đóng góp cho cộng đồng ngay hôm nay.
            </p>
            
            {{-- SEARCH FORM (AJAX ENABLED) --}}
            <form id="searchForm" action="{{ route('opportunities.index') }}" method="GET" class="max-w-2xl mx-auto bg-white p-2 rounded-2xl shadow-xl flex flex-col md:flex-row gap-2">
                <div class="flex-grow relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    {{-- Input --}}
                    <input type="text" name="q" id="searchInput" value="{{ request('q') }}" 
                           placeholder="Bạn muốn giúp đỡ gì hôm nay?" 
                           class="w-full pl-10 pr-4 py-3 rounded-xl border-none focus:ring-0 text-gray-800 placeholder-gray-400">
                    {{-- Hidden Category Input --}}
                    <input type="hidden" name="category" id="categoryInput" value="{{ request('category') }}">
                </div>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-md">
                    Tìm kiếm
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        
        {{-- QUICK FILTERS --}}
        <div class="flex flex-wrap gap-4 mb-8 justify-center" id="categoryFilters">
            <button type="button" 
                    data-id=""
                    class="filter-btn px-5 py-2 rounded-full shadow-sm transition font-medium text-sm border 
                    {{ !request('category') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-transparent hover:border-indigo-100 hover:text-indigo-600' }}">
                Tất cả
            </button>
            @foreach($categories ?? [] as $cat)
                <button type="button" 
                        data-id="{{ $cat->category_id }}"
                        class="filter-btn px-5 py-2 rounded-full shadow-sm transition font-medium text-sm border 
                        {{ request('category') == $cat->category_id ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-transparent hover:border-indigo-100 hover:text-indigo-600' }}">
                    {{ $cat->category_name }}
                </button>
            @endforeach
        </div>

        {{-- LOADING SPINNER --}}
        <div id="loadingSpinner" class="hidden py-12 text-center">
            <div class="inline-block w-10 h-10 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
            <p class="mt-3 text-gray-500 text-sm font-medium">Đang tìm kiếm...</p>
        </div>

        {{-- RESULTS CONTAINER --}}
        <div id="opportunitiesContainer">
            @include('opportunities.partials.list')
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const categoryInput = document.getElementById('categoryInput');
    const categoryBtns = document.querySelectorAll('.filter-btn');
    const container = document.getElementById('opportunitiesContainer');
    const spinner = document.getElementById('loadingSpinner');
    let debounceTimer;

    // 1. Hàm thực hiện AJAX Fetch
    function fetchOpportunities(url = null) {
        // Show loading, hide content opacity
        spinner.classList.remove('hidden');
        container.classList.add('opacity-50', 'pointer-events-none');

        // Build URL
        const targetUrl = url || `{{ route('opportunities.index') }}?` + new URLSearchParams(new FormData(searchForm)).toString();

        fetch(targetUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            container.innerHTML = html;
            
            // Update URL browser (pushState)
            if (!url) { // Chỉ update URL nếu là search/filter, không update khi phân trang (tuỳ chọn)
                window.history.pushState({}, '', targetUrl);
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
            spinner.classList.add('hidden');
            container.classList.remove('opacity-50', 'pointer-events-none');
            
            // Re-attach pagination listeners after content update
            attachPaginationListeners();
        });
    }

    // 2. Xử lý Search Input (Debounce)
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchOpportunities();
        }, 500); // Đợi 500ms sau khi ngừng gõ mới tìm
    });

    // 3. Xử lý Submit Form (Prevent Reload)
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        fetchOpportunities();
    });

    // 4. Xử lý Filter Categories
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update UI Active Class
            categoryBtns.forEach(b => {
                b.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                b.classList.add('bg-white', 'text-gray-700', 'border-transparent');
            });
            this.classList.remove('bg-white', 'text-gray-700', 'border-transparent');
            this.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');

            // Update Hidden Input & Fetch
            categoryInput.value = this.dataset.id;
            fetchOpportunities();
        });
    });

    // 5. Xử lý Pagination (Click vào link phân trang không load lại trang)
    function attachPaginationListeners() {
        const paginationLinks = container.querySelectorAll('.pagination a'); // Laravel pagination links
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                if (url) {
                    fetchOpportunities(url);
                    // Scroll to top of results
                    container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }

    // Initial attach
    attachPaginationListeners();
});
</script>
@endpush
@endsection