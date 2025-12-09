@extends('layouts.app')

@section('title', 'Danh sách Tổ Chức - Volunteer Connect')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 pb-12">
    
    {{-- Hero Header --}}
    <div class="relative bg-gradient-to-br from-green-600 to-emerald-800 py-16 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                Đối Tác Cộng Đồng
            </h1>
            <p class="text-green-100 text-lg md:text-xl max-w-2xl mx-auto font-light">
                Kết nối với hàng trăm tổ chức phi lợi nhuận uy tín, cùng chung tay tạo nên những thay đổi tích cực.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        
        {{-- Search & Filter Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 mb-8">
            <form id="filterForm" action="{{ route('organizations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                
                {{-- Search Input --}}
                <div class="md:col-span-5 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           id="searchInput"
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Tìm tên tổ chức, sứ mệnh..." 
                           class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-gray-800 dark:text-white placeholder-gray-400">
                </div>

                {{-- Type Filter --}}
                <div class="md:col-span-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-filter text-gray-400"></i>
                        </div>
                        <select name="type" id="typeInput" class="w-full pl-10 pr-8 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none transition text-gray-800 dark:text-white cursor-pointer">
                            <option value="">Tất cả loại hình</option>
                            @foreach($organizationTypes as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </div>

                {{-- Sort Filter --}}
                <div class="md:col-span-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-sort-amount-down text-gray-400"></i>
                        </div>
                        <select name="sort" id="sortInput" class="w-full pl-10 pr-8 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none transition text-gray-800 dark:text-white cursor-pointer">
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Đánh giá cao nhất</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="volunteers" {{ request('sort') == 'volunteers' ? 'selected' : '' }}>Nhiều TNV nhất</option>
                            <option value="opportunities" {{ request('sort') == 'opportunities' ? 'selected' : '' }}>Nhiều cơ hội nhất</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </div>

                {{-- Search Button (Optional for JS disabled, nice to have) --}}
                <div class="md:col-span-1">
                    <button type="submit" class="w-full h-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-lg shadow-green-200 dark:shadow-none transition flex items-center justify-center transform active:scale-95">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Loading Spinner --}}
        <div id="loadingSpinner" class="hidden py-12 text-center">
            <div class="inline-block w-12 h-12 border-4 border-green-200 border-t-green-600 rounded-full animate-spin"></div>
            <p class="mt-3 text-gray-500 text-sm font-medium">Đang tìm kiếm...</p>
        </div>

        {{-- Results Container --}}
        <div id="organizationsContainer" class="transition-opacity duration-300">
            @include('organizations.partials.list')
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const container = document.getElementById('organizationsContainer');
    const spinner = document.getElementById('loadingSpinner');
    const inputs = ['searchInput', 'typeInput', 'sortInput'];
    let debounceTimer;

    // 1. Hàm chính: Fetch dữ liệu bằng AJAX
    function fetchOrganizations(url) {
        // Show loading
        spinner.classList.remove('hidden');
        container.classList.add('opacity-50', 'pointer-events-none');

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Update nội dung
            container.innerHTML = html;
            
            // Update URL trên thanh địa chỉ (Quan trọng cho SEO & Share link)
            window.history.pushState({}, '', url);
            
            // Re-attach sự kiện click cho phân trang
            attachPaginationListeners();
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
            // Hide loading
            spinner.classList.add('hidden');
            container.classList.remove('opacity-50', 'pointer-events-none');
            // Scroll lên đầu danh sách nhẹ nhàng
            if(window.innerWidth < 768) {
                 container.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    // 2. Xử lý sự kiện input thay đổi (Search, Select)
    inputs.forEach(id => {
        const el = document.getElementById(id);
        if(!el) return;

        // Dùng 'input' cho text để realtime, 'change' cho select
        const eventType = el.tagName === 'INPUT' ? 'input' : 'change';

        el.addEventListener(eventType, function() {
            clearTimeout(debounceTimer);
            
            // Debounce: Chỉ gửi request sau khi ngừng gõ 500ms
            debounceTimer = setTimeout(() => {
                const formData = new FormData(form);
                const queryString = new URLSearchParams(formData).toString();
                const url = `{{ route('organizations.index') }}?${queryString}`;
                fetchOrganizations(url);
            }, 500);
        });
    });

    // 3. Xử lý submit form (Nút Search hoặc Enter)
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        const queryString = new URLSearchParams(formData).toString();
        const url = `{{ route('organizations.index') }}?${queryString}`;
        fetchOrganizations(url);
    });

    // 4. Xử lý phân trang (Pagination) không reload
    function attachPaginationListeners() {
        const links = container.querySelectorAll('.pagination a');
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                if(url) {
                    fetchOrganizations(url);
                }
            });
        });
    }

    // 5. Hàm reset bộ lọc (cho nút Reset)
    window.resetFilters = function() {
        document.getElementById('searchInput').value = '';
        document.getElementById('typeInput').value = '';
        document.getElementById('sortInput').value = 'rating';
        fetchOrganizations(`{{ route('organizations.index') }}`);
    }

    // 6. Xử lý nút Back/Forward của trình duyệt (Popstate)
    window.addEventListener('popstate', function() {
        // Khi user ấn Back, reload lại trang hoặc fetch lại theo URL hiện tại
        // Đơn giản nhất là reload để đảm bảo đồng bộ
        window.location.reload();
    });

    // Khởi tạo listener ban đầu
    attachPaginationListeners();
});
</script>
@endpush