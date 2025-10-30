@extends('layouts.app')

@section('title', 'Tìm Kiếm Nâng Cao - Volunteer Connect')

@section('content')
<div class="container py-4">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold mb-2">
                        <i class="fas fa-search text-primary"></i> Tìm Kiếm Nâng Cao
                    </h1>
                    <p class="text-muted">Tìm cơ hội tình nguyện phù hợp với bạn</p>
                </div>
                <a href="{{ route('opportunities.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Search Filters -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-sliders-h text-primary"></i> Bộ Lọc
                    </h5>

                    <form action="{{ route('search') }}" method="GET" id="advancedSearchForm">
                        
                        <!-- Keyword Search -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-keyboard"></i> Từ khóa
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   name="q" 
                                   placeholder="Tìm theo tiêu đề, mô tả..."
                                   value="{{ request('q') }}">
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-th-large"></i> Danh Mục
                            </label>
                            <select class="form-select" name="category">
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
                            <label class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt"></i> Địa Điểm
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   name="location" 
                                   placeholder="Thành phố, quận..."
                                   value="{{ request('location') }}"
                                   list="locationSuggestions">
                            <datalist id="locationSuggestions">
                                <option value="Hà Nội">
                                <option value="Hồ Chí Minh">
                                <option value="Đà Nẵng">
                                <option value="Hải Phòng">
                                <option value="Cần Thơ">
                                <option value="Biên Hòa">
                                <option value="Nha Trang">
                                <option value="Huế">
                            </datalist>
                        </div>

                        <!-- Time Commitment -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-clock"></i> Thời Gian Cam Kết
                            </label>
                            <select class="form-select" name="time_commitment">
                                <option value="">Tất cả</option>
                                <option value="1-2 hours" {{ request('time_commitment') == '1-2 hours' ? 'selected' : '' }}>1-2 giờ</option>
                                <option value="3-5 hours" {{ request('time_commitment') == '3-5 hours' ? 'selected' : '' }}>3-5 giờ</option>
                                <option value="6-8 hours" {{ request('time_commitment') == '6-8 hours' ? 'selected' : '' }}>6-8 giờ</option>
                                <option value="Full day" {{ request('time_commitment') == 'Full day' ? 'selected' : '' }}>Cả ngày</option>
                                <option value="Multiple days" {{ request('time_commitment') == 'Multiple days' ? 'selected' : '' }}>Nhiều ngày</option>
                            </select>
                        </div>

                        <!-- Schedule Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt"></i> Loại Lịch
                            </label>
                            <select class="form-select" name="schedule_type">
                                <option value="">Tất cả</option>
                                <option value="One-time" {{ request('schedule_type') == 'One-time' ? 'selected' : '' }}>Một lần</option>
                                <option value="Weekly" {{ request('schedule_type') == 'Weekly' ? 'selected' : '' }}>Hàng tuần</option>
                                <option value="Monthly" {{ request('schedule_type') == 'Monthly' ? 'selected' : '' }}>Hàng tháng</option>
                                <option value="Flexible" {{ request('schedule_type') == 'Flexible' ? 'selected' : '' }}>Linh hoạt</option>
                            </select>
                        </div>

                        <!-- Experience Level -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-chart-line"></i> Yêu Cầu Kinh Nghiệm
                            </label>
                            <select class="form-select" name="experience_needed">
                                <option value="">Tất cả</option>
                                <option value="No experience" {{ request('experience_needed') == 'No experience' ? 'selected' : '' }}>Không yêu cầu</option>
                                <option value="Some experience" {{ request('experience_needed') == 'Some experience' ? 'selected' : '' }}>Có chút kinh nghiệm</option>
                                <option value="Experienced" {{ request('experience_needed') == 'Experienced' ? 'selected' : '' }}>Có kinh nghiệm</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-check"></i> Ngày Bắt Đầu
                            </label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="date" 
                                           class="form-control" 
                                           name="start_date_from" 
                                           placeholder="Từ"
                                           value="{{ request('start_date_from') }}">
                                    <small class="text-muted">Từ ngày</small>
                                </div>
                                <div class="col-6">
                                    <input type="date" 
                                           class="form-control" 
                                           name="start_date_to" 
                                           placeholder="Đến"
                                           value="{{ request('start_date_to') }}">
                                    <small class="text-muted">Đến ngày</small>
                                </div>
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-lightbulb"></i> Kỹ Năng
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   name="skills" 
                                   placeholder="VD: Tiếng Anh, IT..."
                                   value="{{ request('skills') }}">
                            <small class="text-muted">Nhập kỹ năng cần tìm</small>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-toggle-on"></i> Trạng Thái
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="status[]" 
                                       value="Active" 
                                       id="statusActive"
                                       {{ in_array('Active', request('status', ['Active'])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusActive">
                                    Đang mở
                                </label>
                            </div>
                        </div>

                        <!-- Sorting -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sort"></i> Sắp Xếp
                            </label>
                            <select class="form-select" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                                <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Hạn nộp đơn</option>
                                <option value="nearest" {{ request('sort') == 'nearest' ? 'selected' : '' }}>Bắt đầu sớm nhất</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Tìm Kiếm
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="fas fa-redo"></i> Đặt Lại
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Search Results -->
        <div class="col-lg-8">
            
            <!-- Results Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">
                    @if(isset($opportunities))
                        Tìm thấy <strong>{{ $opportunities->total() }}</strong> kết quả
                    @else
                        Nhập tiêu chí tìm kiếm
                    @endif
                </h5>
            </div>

            <!-- Active Filters -->
            @if(request()->hasAny(['q', 'category', 'location', 'time_commitment', 'schedule_type', 'experience_needed', 'skills']))
            <div class="card border-0 bg-light mb-4">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="text-muted small">Bộ lọc đang áp dụng:</span>
                        
                        @if(request('q'))
                        <span class="badge bg-primary">
                            <i class="fas fa-search"></i> "{{ request('q') }}"
                            <button type="button" class="btn-close btn-close-white ms-1" style="font-size: 0.7rem;" onclick="removeFilter('q')"></button>
                        </span>
                        @endif

                        @if(request('category'))
                        <span class="badge bg-info">
                            <i class="fas fa-th-large"></i> {{ $categories->find(request('category'))->category_name ?? 'Category' }}
                            <button type="button" class="btn-close btn-close-white ms-1" style="font-size: 0.7rem;" onclick="removeFilter('category')"></button>
                        </span>
                        @endif

                        @if(request('location'))
                        <span class="badge bg-success">
                            <i class="fas fa-map-marker-alt"></i> {{ request('location') }}
                            <button type="button" class="btn-close btn-close-white ms-1" style="font-size: 0.7rem;" onclick="removeFilter('location')"></button>
                        </span>
                        @endif

                        @if(request('time_commitment'))
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-clock"></i> {{ request('time_commitment') }}
                            <button type="button" class="btn-close ms-1" style="font-size: 0.7rem;" onclick="removeFilter('time_commitment')"></button>
                        </span>
                        @endif

                        @if(request('skills'))
                        <span class="badge bg-secondary">
                            <i class="fas fa-lightbulb"></i> {{ request('skills') }}
                            <button type="button" class="btn-close btn-close-white ms-1" style="font-size: 0.7rem;" onclick="removeFilter('skills')"></button>
                        </span>
                        @endif

                        <a href="{{ route('search.advanced') }}" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-times"></i> Xóa tất cả
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Results Grid -->
            @if(isset($opportunities) && $opportunities->isNotEmpty())
            <div class="row g-4">
                @foreach($opportunities as $opportunity)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body">
                            <!-- Category Badge -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge rounded-pill" style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}">
                                    <i class="{{ $opportunity->category->icon ?? 'fas fa-heart' }}"></i>
                                    {{ $opportunity->category->category_name ?? 'General' }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h5 class="card-title mb-2">
                                <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                                   class="text-dark text-decoration-none">
                                    {{ Str::limit($opportunity->title, 50) }}
                                </a>
                            </h5>

                            <!-- Organization -->
                            <p class="text-muted small mb-3">
                                <i class="fas fa-building"></i>
                                {{ Str::limit($opportunity->organization->organization_name, 30) }}
                            </p>

                            <!-- Meta Info -->
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    {{ Str::limit($opportunity->location, 15) }}
                                </span>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-calendar text-success"></i>
                                    {{ \Carbon\Carbon::parse($opportunity->start_date)->format('d/m/Y') }}
                                </span>
                            </div>

                            <!-- Action Button -->
                            <div class="d-grid">
                                <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    Xem Chi Tiết <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($opportunities->hasPages())
            <div class="mt-4">
                {{ $opportunities->appends(request()->query())->links() }}
            </div>
            @endif

            @elseif(isset($opportunities))
            <!-- No Results -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search fa-4x text-muted"></i>
                </div>
                <h4 class="mb-3">Không tìm thấy kết quả phù hợp</h4>
                <p class="text-muted mb-4">Hãy thử điều chỉnh bộ lọc hoặc tìm kiếm với từ khóa khác</p>
                <a href="{{ route('opportunities.index') }}" class="btn btn-primary">
                    <i class="fas fa-th"></i> Xem Tất Cả Cơ Hội
                </a>
            </div>
            @else
            <!-- Initial State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-filter fa-4x text-primary"></i>
                </div>
                <h4 class="mb-3">Bắt đầu tìm kiếm</h4>
                <p class="text-muted">Sử dụng bộ lọc bên trái để tìm cơ hội phù hợp với bạn</p>
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

    .badge .btn-close {
        padding: 0;
        opacity: 0.8;
    }

    .badge .btn-close:hover {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
function resetForm() {
    document.getElementById('advancedSearchForm').reset();
    window.location.href = '{{ route("search.advanced") }}';
}

function removeFilter(filterName) {
    const form = document.getElementById('advancedSearchForm');
    const input = form.querySelector(`[name="${filterName}"]`);
    if (input) {
        input.value = '';
        form.submit();
    }
}
</script>
@endpush
@endsection