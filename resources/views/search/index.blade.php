@extends('layouts.app')

@section('title', 'Tìm Kiếm - Volunteer Connect')

@section('content')
<div class="container py-5">
    
    <!-- Hero Search Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-4">
                    <i class="fas fa-search me-3"></i>Tìm Kiếm Cơ Hội
                </h1>
                <p class="lead text-muted mb-4">
                    Khám phá hàng ngàn cơ hội tình nguyện phù hợp với kỹ năng và đam mê của bạn
                </p>
            </div>

            <!-- Main Search Box -->
            <div class="card border-0 shadow-lg">
                <div class="card-body p-4">
                    <form action="{{ route('search') }}" method="GET" id="mainSearchForm">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Tìm kiếm theo từ khóa</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control form-control-lg" 
                                           name="q" 
                                           placeholder="VD: dạy học, môi trường, y tế..."
                                           value="{{ request('q') }}"
                                           id="mainSearchInput">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Địa điểm</label>
                                <select class="form-select form-select-lg" name="location">
                                    <option value="">Tất cả địa điểm</option>
                                    <option value="Hà Nội" {{ request('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                    <option value="Hồ Chí Minh" {{ request('location') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                    <option value="Đà Nẵng" {{ request('location') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                    <option value="Remote" {{ request('location') == 'Remote' ? 'selected' : '' }}>Làm từ xa</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-search me-2"></i>Tìm Kiếm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Search Options -->
            <div class="text-center mt-4">
                <p class="text-muted mb-3">Hoặc tìm kiếm nhanh theo:</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('search.advanced', ['category' => 1]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-heart me-1"></i> Giáo dục
                    </a>
                    <a href="{{ route('search.advanced', ['category' => 2]) }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-leaf me-1"></i> Môi trường
                    </a>
                    <a href="{{ route('search.advanced', ['category' => 3]) }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-hand-holding-medical me-1"></i> Y tế
                    </a>
                    <a href="{{ route('search.advanced', ['schedule_type' => 'Remote']) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-laptop me-1"></i> Làm từ xa
                    </a>
                    <a href="{{ route('search.advanced', ['experience_needed' => 'No experience']) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-star me-1"></i> Không yêu cầu KN
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Search Link -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card border-0 bg-light">
                <div class="card-body text-center py-4">
                    <h5 class="mb-3">Tìm kiếm chi tiết hơn?</h5>
                    <p class="text-muted mb-3">Sử dụng tìm kiếm nâng cao để lọc theo kỹ năng, thời gian, kinh nghiệm và nhiều tiêu chí khác</p>
                    <a href="{{ route('search.advanced') }}" class="btn btn-outline-primary">
                        <i class="fas fa-sliders-h me-2"></i>Tìm Kiếm Nâng Cao
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Categories -->
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="text-center mb-4">Danh Mục Phổ Biến</h3>
            <div class="row g-4">
                @foreach($categories->take(6) as $category)
                <div class="col-md-4 col-lg-2">
                    <a href="{{ route('search.advanced', ['category' => $category->category_id]) }}" 
                       class="card category-card text-decoration-none text-center border-0 shadow-sm">
                        <div class="card-body py-4">
                            <div class="mb-3">
                                <i class="{{ $category->icon ?? 'fas fa-heart' }} fa-2x" 
                                   style="color: {{ $category->color ?? '#3B82F6' }}"></i>
                            </div>
                            <h6 class="card-title mb-2 text-dark">{{ $category->category_name }}</h6>
                            <small class="text-muted">{{ $category->opportunities_count ?? 0 }} cơ hội</small>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Trending Opportunities -->
    @if(isset($trendingOpportunities) && $trendingOpportunities->count() > 0)
    <div class="row">
        <div class="col-12">
            <h3 class="text-center mb-4">Cơ Hội Đang Hot</h3>
            <div class="row g-4">
                @foreach($trendingOpportunities->take(3) as $opportunity)
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-fire me-1"></i>Trending
                                </span>
                                <span class="badge rounded-pill" style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}; color: white;">
                                    {{ $opportunity->category->category_name ?? 'General' }}
                                </span>
                            </div>
                            <h5 class="card-title">
                                <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                                   class="text-dark text-decoration-none">
                                    {{ Str::limit($opportunity->title, 50) }}
                                </a>
                            </h5>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-building me-1"></i>
                                {{ $opportunity->organization->organization_name }}
                            </p>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-dark small">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                    {{ $opportunity->location }}
                                </span>
                                <span class="badge bg-light text-dark small">
                                    <i class="fas fa-users text-info me-1"></i>
                                    {{ $opportunity->application_count }} ứng viên
                                </span>
                            </div>
                            <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                               class="btn btn-outline-primary btn-sm w-100">
                                Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Search Statistics -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body py-5">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="h2 fw-bold mb-2">{{ $stats['total_opportunities'] ?? 0 }}</div>
                            <div class="small opacity-75">Cơ Hội Tình Nguyện</div>
                        </div>
                        <div class="col-md-3">
                            <div class="h2 fw-bold mb-2">{{ $stats['total_organizations'] ?? 0 }}</div>
                            <div class="small opacity-75">Tổ Chức</div>
                        </div>
                        <div class="col-md-3">
                            <div class="h2 fw-bold mb-2">{{ $stats['total_categories'] ?? 0 }}</div>
                            <div class="small opacity-75">Danh Mục</div>
                        </div>
                        <div class="col-md-3">
                            <div class="h2 fw-bold mb-2">{{ $stats['total_locations'] ?? 0 }}+</div>
                            <div class="small opacity-75">Địa Điểm</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .category-card {
        transition: all 0.3s ease;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    .hover-card {
        transition: all 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }

    .input-group-text {
        border: none;
    }

    .form-control-lg, .form-select-lg {
        border-radius: 0.375rem;
    }
</style>
@endpush

@push('styles')
<style>
    /* Search Index Specific Styles */
    .hero-search-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1.5rem;
        padding: 3rem 2rem;
        margin-bottom: 3rem;
    }
    
    .search-hero-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .category-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e5e7eb;
        background: white;
    }
    
    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border-color: #6366f1;
    }
    
    .trending-badge {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .quick-search-btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        background: linear-gradient(white, white) padding-box,
                    linear-gradient(135deg, #6366f1, #8b5cf6) border-box;
    }
    
    .quick-search-btn:hover {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        transform: translateY(-2px);
    }
    
    .stats-card {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border-radius: 1rem;
        overflow: hidden;
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    /* Search input enhancements */
    .search-input-group {
        position: relative;
    }
    
    .search-input-group .input-group-text {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: none;
        color: white;
    }
    
    .search-input-group .form-control {
        border-left: none;
        padding-left: 0;
    }
    
    .search-input-group .form-control:focus {
        border-color: #d1d5db;
        box-shadow: none;
    }
    
    .search-input-group .form-control:focus + .input-group-text {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .hero-search-section {
            padding: 2rem 1rem;
            border-radius: 1rem;
        }
        
        .category-card {
            margin-bottom: 1rem;
        }
    }
    
    /* Dark mode support */
    .dark .search-hero-card {
        background: rgba(31, 41, 55, 0.95);
    }
    
    .dark .category-card {
        background: #1f2937;
        border-color: #374151;
    }
    
    .dark .quick-search-btn {
        background: linear-gradient(#1f2937, #1f2937) padding-box,
                    linear-gradient(135deg, #6366f1, #8b5cf6) border-box;
        color: #f9fafb;
    }
    
    .dark .quick-search-btn:hover {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick search functionality
    const mainSearchInput = document.getElementById('mainSearchInput');
    
    if (mainSearchInput) {
        mainSearchInput.focus();
        
        // Add enter key support
        mainSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('mainSearchForm').submit();
            }
        });
    }
    
    // Load trending opportunities if not already loaded
    @if(!isset($trendingOpportunities))
    fetch('/api/trending-opportunities')
        .then(response => response.json())
        .then(data => {
            // You can implement dynamic loading of trending opportunities here
            console.log('Trending opportunities:', data);
        })
        .catch(error => console.error('Error loading trending opportunities:', error));
    @endif
});
</script>
@endpush
@endsection