@extends('layouts.app')

@section('title', 'Tìm Kiếm Nâng Cao - Volunteer Connect')

@section('content')
<div class="container py-4">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold mb-2">
                        <i class="fas fa-search text-primary"></i> Tìm Kiếm Nâng Cao
                    </h1>
                    <p class="text-muted">Tìm cơ hội tình nguyện phù hợp với kỹ năng và sở thích của bạn</p>
                </div>
                <a href="{{ route('opportunities.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="mb-4">
                        <i class="fas fa-sliders-h text-primary"></i> Bộ Lọc Tìm Kiếm
                    </h5>

                    <form action="{{ route('search.advanced') }}" method="GET" id="advancedSearchForm">
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-keyboard"></i> Từ khóa
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   name="q" 
                                   placeholder="Tìm theo tiêu đề, mô tả, tổ chức..."
                                   value="{{ request('q') }}"
                                   id="keywordInput">
                            <div id="searchSuggestions" class="dropdown-menu w-100" style="display: none;"></div>
                        </div>

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

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt"></i> Địa Điểm
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   name="location" 
                                   placeholder="Thành phố, quận, huyện..."
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
                                <option value="Vũng Tàu">
                                <option value="Quảng Ninh">
                            </datalist>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-clock"></i> Thời Gian Cam Kết
                            </label>
                            <select class="form-select" name="time_commitment">
                                <option value="">Tất cả thời gian</option>
                                <option value="1-2 hours" {{ request('time_commitment') == '1-2 hours' ? 'selected' : '' }}>1-2 giờ/tuần</option>
                                <option value="3-5 hours" {{ request('time_commitment') == '3-5 hours' ? 'selected' : '' }}>3-5 giờ/tuần</option>
                                <option value="6-8 hours" {{ request('time_commitment') == '6-8 hours' ? 'selected' : '' }}>6-8 giờ/tuần</option>
                                <option value="Full day" {{ request('time_commitment') == 'Full day' ? 'selected' : '' }}>Cả ngày</option>
                                <option value="Multiple days" {{ request('time_commitment') == 'Multiple days' ? 'selected' : '' }}>Nhiều ngày</option>
                                <option value="Flexible" {{ request('time_commitment') == 'Flexible' ? 'selected' : '' }}>Linh hoạt</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt"></i> Loại Lịch
                            </label>
                            <select class="form-select" name="schedule_type">
                                <option value="">Tất cả loại lịch</option>
                                <option value="One-time" {{ request('schedule_type') == 'One-time' ? 'selected' : '' }}>Một lần</option>
                                <option value="Weekly" {{ request('schedule_type') == 'Weekly' ? 'selected' : '' }}>Hàng tuần</option>
                                <option value="Monthly" {{ request('schedule_type') == 'Monthly' ? 'selected' : '' }}>Hàng tháng</option>
                                <option value="Flexible" {{ request('schedule_type') == 'Flexible' ? 'selected' : '' }}>Linh hoạt</option>
                                <option value="Remote" {{ request('schedule_type') == 'Remote' ? 'selected' : '' }}>Làm từ xa</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-chart-line"></i> Yêu Cầu Kinh Nghiệm
                            </label>
                            <select class="form-select" name="experience_needed">
                                <option value="">Tất cả cấp độ</option>
                                <option value="No experience" {{ request('experience_needed') == 'No experience' ? 'selected' : '' }}>Không yêu cầu kinh nghiệm</option>
                                <option value="Some experience" {{ request('experience_needed') == 'Some experience' ? 'selected' : '' }}>Có chút kinh nghiệm</option>
                                <option value="Experienced" {{ request('experience_needed') == 'Experienced' ? 'selected' : '' }}>Có kinh nghiệm</option>
                                <option value="Expert" {{ request('experience_needed') == 'Expert' ? 'selected' : '' }}>Chuyên gia</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-lightbulb"></i> Kỹ Năng
                            </label>
                            
                            <div class="d-flex flex-wrap gap-2">
                                
                                @php
                                    // Định nghĩa danh sách kỹ năng
                                    $all_skills = [
                                        'Communication' => 'Giao tiếp',
                                        'Leadership' => 'Lãnh đạo',
                                        'Teaching' => 'Giảng dạy',
                                        'IT' => 'Công nghệ thông tin',
                                        'Language' => 'Ngoại ngữ',
                                        'Medical' => 'Y tế',
                                        'Art' => 'Nghệ thuật',
                                        'Sports' => 'Thể thao',
                                        'Music' => 'Âm nhạc',
                                        'Cooking' => 'Nấu ăn'
                                    ];
                                    // Lấy các kỹ năng đã chọn từ request
                                    $selected_skills = request('skills', []);
                                @endphp

                                @foreach($all_skills as $value => $label)
                                    <input type="checkbox" 
                                           class="btn-check" 
                                           name="skills[]" 
                                           id="skill_{{ $value }}" 
                                           value="{{ $value }}"
                                           {{ in_array($value, $selected_skills) ? 'checked' : '' }}
                                           autocomplete="off">
                                           
                                    <label class="btn btn-outline-primary btn-sm" for="skill_{{ $value }}">
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                            </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-check"></i> Khoảng Thời Gian
                            </label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="date" 
                                           class="form-control" 
                                           name="start_date_from" 
                                           placeholder="Từ ngày"
                                           value="{{ request('start_date_from') }}"
                                           min="{{ date('Y-m-d') }}">
                                    <small class="text-muted">Từ ngày</small>
                                </div>
                                <div class="col-6">
                                    <input type="date" 
                                           class="form-control" 
                                           name="start_date_to" 
                                           placeholder="Đến ngày"
                                           value="{{ request('start_date_to') }}"
                                           min="{{ date('Y-m-d') }}">
                                    <small class="text-muted">Đến ngày</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tags"></i> Loại Hình
                            </label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="opportunity_type[]" value="Individual" 
                                               id="typeIndividual" {{ in_array('Individual', request('opportunity_type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="typeIndividual">
                                            Cá nhân
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="opportunity_type[]" value="Group" 
                                               id="typeGroup" {{ in_array('Group', request('opportunity_type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="typeGroup">
                                            Nhóm
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="opportunity_type[]" value="Remote" 
                                               id="typeRemote" {{ in_array('Remote', request('opportunity_type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="typeRemote">
                                            Từ xa
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="opportunity_type[]" value="Onsite" 
                                               id="typeOnsite" {{ in_array('Onsite', request('opportunity_type', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="typeOnsite">
                                            Trực tiếp
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-users"></i> Độ Tuổi Phù Hợp
                            </label>
                            <select class="form-select" name="age_group">
                                <option value="">Tất cả độ tuổi</option>
                                <option value="Under 18" {{ request('age_group') == 'Under 18' ? 'selected' : '' }}>Dưới 18 tuổi</option>
                                <option value="18-25" {{ request('age_group') == '18-25' ? 'selected' : '' }}>18-25 tuổi</option>
                                <option value="26-35" {{ request('age_group') == '26-35' ? 'selected' : '' }}>26-35 tuổi</option>
                                <option value="36-50" {{ request('age_group') == '36-50' ? 'selected' : '' }}>36-50 tuổi</option>
                                <option value="Over 50" {{ request('age_group') == 'Over 50' ? 'selected' : '' }}>Trên 50 tuổi</option>
                                <option value="Any" {{ request('age_group') == 'Any' ? 'selected' : '' }}>Mọi độ tuổi</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sort"></i> Sắp Xếp Theo
                            </label>
                            <select class="form-select" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                                <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Hạn nộp đơn gần nhất</option>
                                <option value="nearest" {{ request('sort') == 'nearest' ? 'selected' : '' }}>Bắt đầu sớm nhất</option>
                                <option value="most_applied" {{ request('sort') == 'most_applied' ? 'selected' : '' }}>Nhiều đơn ứng tuyển nhất</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search"></i> Tìm Kiếm Ngay
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="fas fa-redo"></i> Đặt Lại Bộ Lọc
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">
                        @if(isset($opportunities) && $opportunities->total() > 0)
                            Tìm thấy <strong class="text-primary">{{ $opportunities->total() }}</strong> kết quả phù hợp
                        @elseif(isset($opportunities))
                            Không tìm thấy kết quả
                        @else
                            Sẵn sàng tìm kiếm?
                        @endif
                    </h5>
                    @if(isset($opportunities) && $opportunities->total() > 0)
                    <p class="text-muted small mb-0">Hiển thị {{ $opportunities->firstItem() ?? 0 }}-{{ $opportunities->lastItem() ?? 0 }} trên {{ $opportunities->total() }} kết quả</p>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Hiển thị:</span>
                    <select class="form-select form-select-sm w-auto" onchange="updatePerPage(this.value)">
                        <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12</option>
                        <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                        <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                    </select>
                </div>
            </div>

            @if(request()->hasAny(['q', 'category', 'location', 'time_commitment', 'schedule_type', 'experience_needed', 'skills', 'opportunity_type', 'age_group']))
            <div class="card border-0 bg-light mb-4">
                <div class="card-body py-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="text-muted small fw-semibold">Bộ lọc đang áp dụng:</span>
                        
                        @if(request('q'))
                        <span class="badge bg-primary d-flex align-items-center">
                            <i class="fas fa-search me-1"></i> "{{ request('q') }}"
                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.6rem;" onclick="removeFilter('q')"></button>
                        </span>
                        @endif

                        @if(request('category'))
                        @php
                            $selectedCategory = $categories->find(request('category'));
                        @endphp
                        <span class="badge bg-info d-flex align-items-center">
                            <i class="fas fa-th-large me-1"></i> {{ $selectedCategory->category_name ?? 'Danh mục' }}
                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.6rem;" onclick="removeFilter('category')"></button>
                        </span>
                        @endif

                        @if(request('location'))
                        <span class="badge bg-success d-flex align-items-center">
                            <i class="fas fa-map-marker-alt me-1"></i> {{ request('location') }}
                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.6rem;" onclick="removeFilter('location')"></button>
                        </span>
                        @endif

                        @if(request('time_commitment'))
                        <span class="badge bg-warning text-dark d-flex align-items-center">
                            <i class="fas fa-clock me-1"></i> {{ request('time_commitment') }}
                            <button type="button" class="btn-close ms-2" style="font-size: 0.6rem;" onclick="removeFilter('time_commitment')"></button>
                        </span>
                        @endif

                        @if(request('skills'))
                        @foreach(request('skills') as $skill)
                        <span class="badge bg-secondary d-flex align-items-center">
                            <i class="fas fa-lightbulb me-1"></i> {{ $skill }}
                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.6rem;" onclick="removeArrayFilter('skills', '{{ $skill }}')"></button>
                        </span>
                        @endforeach
                        @endif

                        @if(request('opportunity_type'))
                        @foreach(request('opportunity_type') as $type)
                        <span class="badge bg-dark d-flex align-items-center">
                            <i class="fas fa-tag me-1"></i> {{ $type }}
                            <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.6rem;" onclick="removeArrayFilter('opportunity_type', '{{ $type }}')"></button>
                        </span>
                        @endforeach
                        @endif

                        <a href="{{ route('search.advanced') }}" class="btn btn-sm btn-outline-danger ms-2">
                            <i class="fas fa-times"></i> Xóa tất cả
                        </a>
                    </div>
                </div>
            </div>
            @endif

            @if(isset($opportunities) && $opportunities->total() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 bg-primary text-white">
                        <div class="card-body py-3">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="h5 mb-1">{{ $opportunities->total() }}</div>
                                    <small class="opacity-75">Tổng cơ hội</small>
                                </div>
                                <div class="col-md-3">
                                    <div class="h5 mb-1">{{ $opportunities->where('schedule_type', 'Remote')->count() }}</div>
                                    <small class="opacity-75">Làm từ xa</small>
                                </div>
                                <div class="col-md-3">
                                    <div class="h5 mb-1">{{ $opportunities->where('experience_needed', 'No experience')->count() }}</div>
                                    <small class="opacity-75">Không yêu cầu KN</small>
                                </div>
                                <div class="col-md-3">
                                    <div class="h5 mb-1">{{ $opportunities->where('time_commitment', 'Flexible')->count() }}</div>
                                    <small class="opacity-75">Thời gian linh hoạt</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(isset($opportunities) && $opportunities->isNotEmpty())
            <div class="row g-4">
                @foreach($opportunities as $opportunity)
                <div class="col-md-6 col-lg-6">
                    <div class="card h-100 border-0 opportunity-card">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge rounded-pill" style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}; color: white;">
                                    <i class="{{ $opportunity->category->icon ?? 'fas fa-heart' }} me-1"></i>
                                    {{ $opportunity->category->category_name ?? 'General' }}
                                </span>
                                <button class="btn btn-sm btn-outline-secondary bookmark-btn" data-opportunity-id="{{ $opportunity->opportunity_id }}">
                                    <i class="far fa-bookmark"></i>
                                </button>
                            </div>

                            <h5 class="card-title mb-2 flex-grow-1">
                                <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                                   class="text-dark text-decoration-none">
                                    {{ Str::limit($opportunity->title, 60) }}
                                </a>
                            </h5>

                            <p class="text-muted small mb-3">
                                <i class="fas fa-building me-1"></i>
                                {{ Str::limit($opportunity->organization->organization_name, 30) }}
                            </p>

                            <p class="card-text small text-muted mb-3">
                                {{ Str::limit(strip_tags($opportunity->description), 100) }}
                            </p>

                            @if($opportunity->required_skills)
                            <div class="mb-3">
                                @foreach(explode(',', $opportunity->required_skills) as $skill)
                                    @if($loop->index < 3)
                                    <span class="badge bg-light text-dark border small mb-1">
                                        <i class="fas fa-check text-success me-1"></i>{{ trim($skill) }}
                                    </span>
                                    @endif
                                @endforeach
                                @if(count(explode(',', $opportunity->required_skills)) > 3)
                                    <span class="badge bg-light text-muted border small">+{{ count(explode(',', $opportunity->required_skills)) - 3 }} more</span>
                                @endif
                            </div>
                            @endif

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-light text-dark small">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                    {{ Str::limit($opportunity->location, 15) }}
                                </span>
                                <span class="badge bg-light text-dark small">
                                    <i class="fas fa-calendar text-success me-1"></i>
                                    {{ \Carbon\Carbon::parse($opportunity->start_date)->format('d/m/Y') }}
                                </span>
                                <span class="badge bg-light text-dark small">
                                    <i class="fas fa-clock text-info me-1"></i>
                                    {{ $opportunity->time_commitment }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="text-muted small">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $opportunity->application_count ?? 0 }} ứng viên
                                </div>
                                <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                                   class="btn btn-primary btn-sm">
                                    Xem Chi Tiết <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

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

            @elseif(isset($opportunities))
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="mb-3 text-muted">Không tìm thấy kết quả phù hợp</h4>
                <p class="text-muted mb-4">Hãy thử điều chỉnh bộ lọc hoặc tìm kiếm với từ khóa khác</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('opportunities.index') }}" class="btn btn-primary">
                        <i class="fas fa-th me-2"></i> Xem Tất Cả Cơ Hội
                    </a>
                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                        <i class="fas fa-redo me-2"></i> Đặt Lại Bộ Lọc
                    </button>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-filter fa-4x text-primary opacity-75"></i>
                </div>
                <h4 class="mb-3 text-primary">Bắt đầu tìm kiếm cơ hội tình nguyện</h4>
                <p class="text-muted mb-4">Sử dụng bộ lọc bên trái để tìm cơ hội phù hợp với kỹ năng, sở thích và thời gian của bạn</p>
                
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-lightbulb text-primary fa-2x"></i>
                            </div>
                            <h6>Tìm theo kỹ năng</h6>
                            <p class="small text-muted">Lọc theo kỹ năng bạn có để tìm cơ hội phù hợp</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-map-marker-alt text-success fa-2x"></i>
                            </div>
                            <h6>Tìm theo địa điểm</h6>
                            <p class="small text-muted">Tìm cơ hội gần nơi bạn sống hoặc làm việc từ xa</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-clock text-info fa-2x"></i>
                            </div>
                            <h6>Tìm theo thời gian</h6>
                            <p class="small text-muted">Chọn thời gian phù hợp với lịch trình của bạn</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

@push('styles')
{{-- STYLE GIỮ NGUYÊN TỪ LẦN TRƯỚC --}}
<style>
    :root {
        --app-primary-color: #3B82F6; /* Màu chính */
        --app-primary-color-light: #ebf3fe; /* Màu xanh rất nhạt để hover */
        --app-light-gray: #f8f9fa; /* Bootstrap's light */
        --app-border-color: #dee2e6; /* Bootstrap's border color */
        --app-text-muted: #6c757d;
        --app-transition-duration: 0.25s;
        
        /* Một box-shadow tinh tế hơn nhiều */
        --app-subtle-shadow: 0 4px 12px rgba(0,0,0,0.08); 
    }

    /* --- Panel Bộ Lọc --- */
    .sticky-top > .card {
        background-color: var(--app-light-gray);
        border: 1px solid var(--app-border-color);
        box-shadow: none !important; /* Ghi đè shadow-sm từ HTML */
    }

    /* --- Card Cơ Hội --- */
    .opportunity-card {
        background-color: #ffffff;
        /* Thêm 1px border mặc định */
        border: 1px solid var(--app-border-color);
        border-radius: var(--bs-border-radius, 0.375rem);
        transition: all var(--app-transition-duration) ease;
        
        /* Ghi đè shadow-sm từ HTML */
        box-shadow: none !important; 
    }
    
    .opportunity-card:hover {
        transform: translateY(-4px);
        /* Đổi màu border khi hover */
        border-color: var(--app-primary-color);
        /* Thêm shadow tinh tế khi hover */
        box-shadow: var(--app-subtle-shadow) !important;
    }

    /* --- Thẻ (Badge) Bộ lọc đang áp dụng --- */
    .card.bg-light .badge {
        background-color: #ffffff !important; /* Nền trắng */
        color: var(--bs-dark, #212529) !important; /* Chữ đen */
        border: 1px solid var(--app-border-color);
        padding: 0.4em 0.65em;
        font-weight: 500;
        font-size: 0.8rem;
    }
    
    .card.bg-light .badge.bg-primary,
    .card.bg-light .badge.bg-info,
    .card.bg-light .badge.bg-success,
    .card.bg-light .badge.bg-warning,
    .card.bg-light .badge.bg-secondary,
    .card.bg-light .badge.bg-dark {
        background-color: #ffffff !important;
        color: var(--bs-dark, #212529) !important;
    }
    
    .card.bg-light .badge.bg-warning.text-dark {
         color: var(--bs-dark, #212529) !important;
    }

    .card.bg-light .badge .btn-close {
        filter: invert(0) grayscale(100%) brightness(0); 
        opacity: 0.6;
    }
     .card.bg-light .badge .btn-close:hover {
        opacity: 0.9;
    }
    
    /* --- Nút Bookmark --- */
    .bookmark-btn {
        border-radius: 50%; /* Làm nó tròn */
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-color: var(--app-border-color);
        color: var(--app-text-muted);
        transition: all var(--app-transition-duration) ease;
    }
    .bookmark-btn:hover,
    .bookmark-btn.active { 
        color: var(--app-primary-color);
        border-color: var(--app-primary-color);
        background-color: var(--app-primary-color-light);
    }
    .bookmark-btn.active .fa-bookmark {
        font-weight: 900; /* fas (solid) */
    }


    /* --- Menu Gợi ý Tìm kiếm --- */
    .dropdown-menu {
        max-height: 250px;
        overflow-y: auto;
        border: 1px solid var(--app-border-color);
        box-shadow: var(--app-subtle-shadow);
        border-radius: var(--bs-border-radius, 0.375rem);
    }

    .dropdown-item {
        transition: background-color var(--app-transition-duration) ease;
        padding: 0.5rem 1rem;
    }
    .dropdown-item:hover {
        background-color: var(--app-light-gray);
    }

    /* --- Style cho "Thẻ" (Pill) Kỹ năng MỚI --- */
    /* Làm cho các thẻ nhỏ hơn một chút và đổi màu khi được chọn */
    .btn-check:checked + .btn-outline-primary {
        background-color: var(--app-primary-color);
        color: #ffffff;
    }
    
    .btn.btn-outline-primary {
        font-size: 0.85rem;
        padding: 0.25rem 0.6rem;
    }


    /* --- Các icon trong Tip "Bắt đầu tìm kiếm" --- */
    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }
    .bg-success.bg-opacity-10 {
         background-color: rgba(var(--bs-success-rgb), 0.1) !important;
    }
    .bg-info.bg-opacity-10 {
         background-color: rgba(var(--bs-info-rgb), 0.1) !important;
    }
</style>
@endpush

@push('scripts')
{{-- SCRIPT ĐÃ ĐƯỢC CẬP NHẬT --}}
<script>
function resetForm() {
    // THAY ĐỔI: Bỏ chọn tất cả checkbox kỹ năng
    document.querySelectorAll('.btn-check[name="skills[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    document.getElementById('advancedSearchForm').reset();
    
    // Bỏ qua lỗi Select2 nếu nó không còn tồn tại
    // $('#skillsSelect').val([]).trigger('change'); 
    
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

function removeArrayFilter(filterName, valueToRemove) {
    const form = document.getElementById('advancedSearchForm');
    
    // THAY ĐỔI: Áp dụng cho cả checkbox (kỹ năng) và input (loại hình)
    const inputs = form.querySelectorAll(`[name="${filterName}[]"]`);
    
    inputs.forEach(input => {
        if (input.value === valueToRemove) {
            input.checked = false;
            
            // Nếu là 'skills[]', ta cũng phải bỏ chọn "thẻ" tương ứng
            if (filterName === 'skills') {
                const label = document.querySelector(`label[for="${input.id}"]`);
                if (label) {
                    label.classList.remove('active');
                }
            }
        }
    });
    
    form.submit();
}

function updatePerPage(value) {
    const form = document.getElementById('advancedSearchForm');
    let perPageInput = form.querySelector('[name="per_page"]');
    
    if (!perPageInput) {
        perPageInput = document.createElement('input');
        perPageInput.type = 'hidden';
        perPageInput.name = 'per_page';
        form.appendChild(perPageInput);
    }
    
    perPageInput.value = value;
    form.submit();
}

// Search suggestions
document.addEventListener('DOMContentLoaded', function() {
    const keywordInput = document.getElementById('keywordInput');
    const suggestionsDiv = document.getElementById('searchSuggestions');
    
    if (keywordInput && suggestionsDiv) {
        let timeoutId;
        
        keywordInput.addEventListener('input', function() {
            clearTimeout(timeoutId);
            const query = this.value.trim();
            
            if (query.length < 2) {
                suggestionsDiv.style.display = 'none';
                return;
            }
            
            timeoutId = setTimeout(() => {
                fetch(`/search/suggestions?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(suggestions => {
                        if (suggestions.length > 0) {
                            suggestionsDiv.innerHTML = suggestions.map(suggestion => `
                                <a class="dropdown-item" href="${suggestion.url}">
                                    <i class="fas fa-${suggestion.type === 'opportunity' ? 'search' : suggestion.type === 'organization' ? 'building' : 'th-large'} me-2 text-muted"></i>
                                    ${suggestion.title}
                                    <small class="text-muted float-end">${suggestion.type}</small>
                                </a>
                            `).join('');
                            suggestionsDiv.style.display = 'block';
                        } else {
                            suggestionsDiv.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching suggestions:', error);
                        suggestionsDiv.style.display = 'none';
                    });
            }, 300);
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!keywordInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                suggestionsDiv.style.display = 'none';
            }
        });
        
        // Handle suggestion click
        suggestionsDiv.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') {
                e.preventDefault();
                window.location.href = e.target.href;
            }
        });
    }
    
    // ============================================
    // ĐÃ XÓA BỎ PHẦN KHỞI TẠO SELECT2
    // ============================================
    // if ($.fn.select2) {
    //     $('#skillsSelect').select2({ ... });
    // }
    
    // Bookmark functionality
    document.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const opportunityId = this.dataset.opportunityId;
            // Implement bookmark logic here
            console.log('Bookmark opportunity:', opportunityId);
            
            this.classList.toggle('active'); 
            
            const icon = this.querySelector('i.fa-bookmark');
            if (this.classList.contains('active')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
        });
    });
});
</script>
@endpush
@endsection