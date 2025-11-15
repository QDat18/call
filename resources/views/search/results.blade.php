@extends('layouts.app')

@section('title', 'Kết Quả Tìm Kiếm - Volunteer Connect')

@section('content')
<div class="container py-4">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold mb-2">
                        <i class="fas fa-search text-primary"></i> Kết Quả Tìm Kiếm
                    </h1>
                    <p class="text-muted">Kết quả tìm kiếm cho từ khóa của bạn</p>
                </div>
                <a href="{{ route('search.advanced') }}" class="btn btn-outline-primary">
                    <i class="fas fa-sliders-h me-2"></i>Tìm Kiếm Nâng Cao
                </a>
            </div>
        </div>
    </div>

    <!-- Search Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-2">
                                @if($opportunities->total() > 0)
                                    Tìm thấy <strong class="text-primary">{{ $opportunities->total() }}</strong> kết quả 
                                    @if(request('q'))
                                        cho "<strong>{{ request('q') }}</strong>"
                                    @endif
                                @else
                                    Không tìm thấy kết quả 
                                    @if(request('q'))
                                        cho "<strong>{{ request('q') }}</strong>"
                                    @endif
                                @endif
                            </h5>
                            @if($opportunities->total() > 0)
                            <p class="text-muted mb-0">
                                Hiển thị {{ $opportunities->firstItem() }}-{{ $opportunities->lastItem() }} trên {{ $opportunities->total() }} kết quả
                            </p>
                            @endif
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-flex align-items-center justify-content-md-end gap-3">
                                <span class="text-muted small">Sắp xếp:</span>
                                <select class="form-select form-select-sm w-auto" onchange="updateSort(this.value)">
                                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                                    <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Hạn nộp đơn</option>
                                    <option value="nearest" {{ request('sort') == 'nearest' ? 'selected' : '' }}>Bắt đầu sớm nhất</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-filter text-primary me-2"></i>Bộ Lọc
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('search') }}" method="GET" id="resultsFilterForm">
                        <input type="hidden" name="q" value="{{ request('q') }}">
                        
                        <!-- Category -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Danh Mục</label>
                            <select class="form-select form-select-sm" name="category" onchange="this.form.submit()">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories ?? [] as $category)
                                <option value="{{ $category->category_id }}" 
                                        {{ request('category') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Địa Điểm</label>
                            <select class="form-select form-select-sm" name="location" onchange="this.form.submit()">
                                <option value="">Tất cả địa điểm</option>
                                <option value="Hà Nội" {{ request('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                <option value="Hồ Chí Minh" {{ request('location') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                <option value="Đà Nẵng" {{ request('location') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                <option value="Remote" {{ request('location') == 'Remote' ? 'selected' : '' }}>Làm từ xa</option>
                            </select>
                        </div>

                        <!-- Experience Level -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Kinh Nghiệm</label>
                            <select class="form-select form-select-sm" name="experience_needed" onchange="this.form.submit()">
                                <option value="">Tất cả cấp độ</option>
                                <option value="No experience" {{ request('experience_needed') == 'No experience' ? 'selected' : '' }}>Không yêu cầu</option>
                                <option value="Some experience" {{ request('experience_needed') == 'Some experience' ? 'selected' : '' }}>Có chút kinh nghiệm</option>
                                <option value="Experienced" {{ request('experience_needed') == 'Experienced' ? 'selected' : '' }}>Có kinh nghiệm</option>
                            </select>
                        </div>

                        <!-- Time Commitment -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Thời Gian</label>
                            <select class="form-select form-select-sm" name="time_commitment" onchange="this.form.submit()">
                                <option value="">Tất cả thời gian</option>
                                <option value="1-2 hours" {{ request('time_commitment') == '1-2 hours' ? 'selected' : '' }}>1-2 giờ/tuần</option>
                                <option value="3-5 hours" {{ request('time_commitment') == '3-5 hours' ? 'selected' : '' }}>3-5 giờ/tuần</option>
                                <option value="Flexible" {{ request('time_commitment') == 'Flexible' ? 'selected' : '' }}>Linh hoạt</option>
                                <option value="Remote" {{ request('time_commitment') == 'Remote' ? 'selected' : '' }}>Làm từ xa</option>
                            </select>
                        </div>

                        <!-- Quick Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('search.advanced') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-sliders-h me-1"></i>Bộ Lọc Nâng Cao
                            </a>
                            <a href="{{ route('search') }}?q={{ request('q') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-redo me-1"></i>Đặt Lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Tips -->
            <div class="card border-0 bg-primary text-white mt-4">
                <div class="card-body">
                    <h6 class="mb-3">
                        <i class="fas fa-lightbulb me-2"></i>Mẹo Tìm Kiếm
                    </h6>
                    <ul class="small ps-3 mb-0">
                        <li>Sử dụng từ khóa cụ thể</li>
                        <li>Thử các từ khóa đồng nghĩa</li>
                        <li>Kiểm tra chính tả</li>
                        <li>Sử dụng bộ lọc nâng cao</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="col-lg-9">
            @if($opportunities->isNotEmpty())
            
            <!-- Results Grid -->
            <div class="row g-4">
                @foreach($opportunities as $opportunity)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body d-flex flex-column">
                            <!-- Category Badge -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge rounded-pill" style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}; color: white;">
                                    <i class="{{ $opportunity->category->icon ?? 'fas fa-heart' }} me-1"></i>
                                    {{ $opportunity->category->category_name ?? 'General' }}
                                </span>
                                <span class="badge bg-light text-dark small">
                                    <i class="fas fa-eye me-1"></i>{{ $opportunity->view_count ?? 0 }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h6 class="card-title mb-2">
                                <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                                   class="text-dark text-decoration-none">
                                    {{ Str::limit($opportunity->title, 60) }}
                                </a>
                            </h6>

                            <!-- Organization -->
                            <p class="text-muted small mb-3">
                                <i class="fas fa-building me-1"></i>
                                {{ Str::limit($opportunity->organization->organization_name, 25) }}
                            </p>

                            <!-- Description -->
                            <p class="card-text small text-muted mb-3 flex-grow-1">
                                {{ Str::limit(strip_tags($opportunity->description), 80) }}
                            </p>

                            <!-- Skills Preview -->
                            @if($opportunity->required_skills)
                            <div class="mb-3">
                                @foreach(explode(',', $opportunity->required_skills) as $skill)
                                    @if($loop->index < 2)
                                    <span class="badge bg-light text-dark border small mb-1">
                                        <i class="fas fa-check text-success me-1"></i>{{ trim($skill) }}
                                    </span>
                                    @endif
                                @endforeach
                                @if(count(explode(',', $opportunity->required_skills)) > 2)
                                    <span class="badge bg-light text-muted border small">+{{ count(explode(',', $opportunity->required_skills)) - 2 }} more</span>
                                @endif
                            </div>
                            @endif

                            <!-- Meta Info -->
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                <span class="badge bg-light text-dark small">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                    {{ Str::limit($opportunity->location, 12) }}
                                </span>
                                <span class="badge bg-light text-dark small">
                                    <i class="fas fa-clock text-info me-1"></i>
                                    {{ $opportunity->time_commitment }}
                                </span>
                            </div>

                            <!-- Footer -->
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($opportunity->created_at)->diffForHumans() }}
                                </small>
                                <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                                   class="btn btn-primary btn-sm">
                                    Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($opportunities->hasPages())
            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Hiển thị {{ $opportunities->firstItem() }}-{{ $opportunities->lastItem() }} trên {{ $opportunities->total() }} kết quả
                    </div>
                    {{ $opportunities->appends(request()->query())->links() }}
                </div>
            </div>
            @endif

            @else
            <!-- No Results -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="mb-3 text-muted">Không tìm thấy kết quả phù hợp</h4>
                <p class="text-muted mb-4">Hãy thử các cách sau để tìm thấy cơ hội phù hợp:</p>
                
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-sync-alt text-primary"></i>
                                    </div>
                                    <h6>Thử từ khóa khác</h6>
                                    <p class="small text-muted">Sử dụng từ khóa đơn giản hơn hoặc từ đồng nghĩa</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-sliders-h text-success"></i>
                                    </div>
                                    <h6>Điều chỉnh bộ lọc</h6>
                                    <p class="small text-muted">Mở rộng phạm vi tìm kiếm với ít bộ lọc hơn</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-compass text-info"></i>
                                    </div>
                                    <h6>Khám phá danh mục</h6>
                                    <p class="small text-muted">Duyệt qua các danh mục phổ biến</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('opportunities.index') }}" class="btn btn-primary">
                            <i class="fas fa-th me-2"></i>Xem Tất Cả Cơ Hội
                        </a>
                        <a href="{{ route('search.advanced') }}" class="btn btn-outline-primary">
                            <i class="fas fa-sliders-h me-2"></i>Tìm Kiếm Nâng Cao
                        </a>
                        <a href="{{ route('search') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i>Tìm Lại
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Related Searches -->
            @if($opportunities->isNotEmpty() && request('q'))
            <div class="mt-5">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h6 class="mb-3">Tìm kiếm liên quan:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $relatedSearches = [
                                    request('q') . ' tình nguyện',
                                    'cơ hội ' . request('q'),
                                    'hoạt động ' . request('q'),
                                    'dự án ' . request('q')
                                ];
                            @endphp
                            @foreach($relatedSearches as $related)
                            <a href="{{ route('search') }}?q={{ urlencode($related) }}" class="btn btn-outline-secondary btn-sm">
                                {{ $related }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }

    .card-title {
        line-height: 1.4;
    }

    .badge {
        font-size: 0.7rem;
    }
</style>
@endpush

@push('styles')
<style>
    /* Search Results Specific Styles */
    .results-summary-card {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border: 1px solid #bae6fd;
        border-radius: 1rem;
    }
    
    .result-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        background: white;
        overflow: hidden;
    }
    
    .result-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #6366f1;
    }
    
    .result-card-highlight {
        border-left: 4px solid #6366f1;
    }
    
    .pagination-custom .page-link {
        border: 1px solid #d1d5db;
        color: #6b7280;
        padding: 0.5rem 1rem;
        margin: 0 0.25rem;
        border-radius: 0.5rem;
        transition: all 0.2s;
    }
    
    .pagination-custom .page-link:hover {
        background: #6366f1;
        color: white;
        border-color: #6366f1;
    }
    
    .pagination-custom .page-item.active .page-link {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: #6366f1;
        color: white;
    }
    
    .related-search-tag {
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        color: #6b7280;
        transition: all 0.2s;
    }
    
    .related-search-tag:hover {
        background: #6366f1;
        color: white;
        border-color: #6366f1;
        transform: translateY(-1px);
    }
    
    .filter-sidebar {
        background: #f9fafb;
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
    }
    
    .search-tips-card {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border-radius: 1rem;
        overflow: hidden;
    }
    
    .search-tips-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        animation: shine 3s infinite;
    }
    
    @keyframes shine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }
    
    .no-results-illustration {
        opacity: 0.6;
        transition: opacity 0.3s;
    }
    
    .no-results-illustration:hover {
        opacity: 1;
    }
    
    /* Loading states */
    .result-skeleton {
        background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    
    /* Sort dropdown */
    .sort-dropdown {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background: white;
        padding: 0.5rem;
    }
    
    .sort-dropdown:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .filter-sidebar {
            margin-bottom: 2rem;
        }
        
        .result-card {
            margin-bottom: 1rem;
        }
    }
    
    /* Dark mode support */
    .dark .results-summary-card {
        background: linear-gradient(135deg, #1e3a8a, #1e40af);
        border-color: #3730a3;
    }
    
    .dark .result-card {
        background: #1f2937;
        border-color: #374151;
    }
    
    .dark .filter-sidebar {
        background: #1f2937;
        border-color: #374151;
    }
    
    .dark .sort-dropdown {
        background: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }
    
    .dark .related-search-tag {
        background: #374151;
        border-color: #4b5563;
        color: #d1d5db;
    }
    
    .dark .related-search-tag:hover {
        background: #6366f1;
        color: white;
    }
    
    .dark .result-skeleton {
        background: linear-gradient(90deg, #374151 25%, #4b5563 50%, #374151 75%);
    }
</style>
@endpush

@push('scripts')
<script>
function updateSort(sortValue) {
    const form = document.getElementById('resultsFilterForm');
    let sortInput = form.querySelector('[name="sort"]');
    
    if (!sortInput) {
        sortInput = document.createElement('input');
        sortInput.type = 'hidden';
        sortInput.name = 'sort';
        form.appendChild(sortInput);
    }
    
    sortInput.value = sortValue;
    form.submit();
}

// Update filter form with current search query
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('q');
    
    if (searchQuery) {
        const form = document.getElementById('resultsFilterForm');
        let qInput = form.querySelector('[name="q"]');
        
        if (!qInput) {
            qInput = document.createElement('input');
            qInput.type = 'hidden';
            qInput.name = 'q';
            form.appendChild(qInput);
        }
        
        qInput.value = searchQuery;
    }
});
</script>
@endpush
@endsection