@extends('layouts.app')

@section('title', $opportunity->title . ' - Volunteer Connect')

@section('content')
<div class="container py-4">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('opportunities.index') }}">Cơ hội</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($opportunity->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex gap-2">
                            <span class="badge rounded-pill px-3 py-2" 
                                  style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}">
                                <i class="{{ $opportunity->category->icon ?? 'fas fa-heart' }}"></i>
                                {{ $opportunity->category->category_name ?? 'General' }}
                            </span>
                            @if($opportunity->status === 'Active')
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                <i class="fas fa-check-circle"></i> Đang mở
                            </span>
                            @else
                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                {{ $opportunity->status }}
                            </span>
                            @endif
                        </div>
                        
                        @auth
                            @if(auth()->user()->user_type === 'Volunteer')
                            <button class="btn btn-outline-danger btn-sm favorite-btn {{ $isFavorited ?? false ? 'active' : '' }}" 
                                    data-opportunity-id="{{ $opportunity->opportunity_id }}">
                                <i class="fas fa-heart"></i>
                                <span class="ms-1 d-none d-md-inline">
                                    {{ $isFavorited ?? false ? 'Đã lưu' : 'Lưu' }}
                                </span>
                            </button>
                            @endif
                        @endauth
                    </div>

                    <h1 class="display-5 fw-bold mb-3">{{ $opportunity->title }}</h1>

                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $opportunity->organization->user->avatar_url ? asset('storage/' . $opportunity->organization->user->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($opportunity->organization->organization_name).'&background=10B981&color=fff' }}" 
                             alt="{{ $opportunity->organization->organization_name }}"
                             class="rounded-circle me-3"
                             style="width: 48px; height: 48px; object-fit: cover;">
                        <div>
                            <h6 class="mb-0">
                                <a href="{{ route('organizations.show', $opportunity->org_id) }}" 
                                   class="text-dark text-decoration-none">
                                    {{ $opportunity->organization->organization_name }}
                                </a>
                                @if($opportunity->organization->verification_status === 'Verified')
                                <i class="fas fa-check-circle text-primary ms-1" title="Đã xác thực"></i>
                                @endif
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-star text-warning"></i>
                                {{ number_format($opportunity->organization->rating, 1) }} 
                                ({{ $opportunity->organization->volunteer_count }} tình nguyện viên)
                            </small>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="bg-light rounded p-3 text-center">
                                <i class="fas fa-map-marker-alt text-primary fs-4 mb-2"></i>
                                <div class="small text-muted">Địa điểm</div>
                                <div class="fw-semibold">{{ Str::limit($opportunity->location, 15) }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="bg-light rounded p-3 text-center">
                                <i class="fas fa-calendar text-success fs-4 mb-2"></i>
                                <div class="small text-muted">Bắt đầu</div>
                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($opportunity->start_date)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="bg-light rounded p-3 text-center">
                                <i class="fas fa-clock text-warning fs-4 mb-2"></i>
                                <div class="small text-muted">Thời gian</div>
                                <div class="fw-semibold">{{ $opportunity->time_commitment }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="bg-light rounded p-3 text-center">
                                <i class="fas fa-users text-info fs-4 mb-2"></i>
                                <div class="small text-muted">Cần tuyển</div>
                                <div class="fw-semibold">{{ $opportunity->volunteers_needed }} người</div>
                            </div>
                        </div>
                    </div>

                    @php
                        $percentage = $opportunity->volunteers_needed > 0 
                            ? ($opportunity->volunteers_registered / $opportunity->volunteers_needed) * 100 
                            : 0;
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small fw-semibold">
                                <i class="fas fa-users"></i> 
                                {{ $opportunity->volunteers_registered }}/{{ $opportunity->volunteers_needed }} đã đăng ký
                            </span>
                            <span class="small text-muted">{{ round($percentage) }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" 
                                 role="progressbar" 
                                 style="width: {{ min($percentage, 100) }}%">
                            </div>
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->user_type === 'Volunteer')
                            @if($hasApplied ?? false)
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-check-circle"></i>
                                Bạn đã nộp đơn cho cơ hội này
                                <a href="{{ route('volunteer.applications.my') }}" class="alert-link">Xem đơn ứng tuyển</a>
                            </div>
                            @elseif($opportunity->status === 'Active' && $opportunity->volunteers_registered < $opportunity->volunteers_needed)
                            
                            {{-- SỬA LỖI Ở ĐÂY: Truyền tham số 'opportunity' (là ID) vào route --}}
                            <div class="d-grid">
                                <a href="{{ route('volunteer.applications.create', ['opportunity' => $opportunity->opportunity_id]) }}" 
                                   class="btn btn-primary btn-lg d-grid gap-2">
                                    <i class="fas fa-paper-plane"></i> Nộp Đơn Ứng Tuyển
                                </a>
                            </div>

                            @else
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle"></i>
                                Cơ hội này đã đóng hoặc đã đủ số lượng tình nguyện viên
                            </div>
                            @endif
                        @endif
                    @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle"></i>
                        Vui lòng <a href="{{ route('login') }}" class="alert-link">đăng nhập</a> để nộp đơn ứng tuyển
                    </div>
                    @endauth

                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">
                        <i class="fas fa-align-left text-primary"></i> Mô tả
                    </h4>
                    <div class="opportunity-description">
                        {!! nl2br(e($opportunity->description)) !!}
                    </div>
                </div>
            </div>

            @if($opportunity->requirements)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">
                        <i class="fas fa-clipboard-check text-success"></i> Yêu cầu
                    </h4>
                    <div class="requirements-content">
                        {!! nl2br(e($opportunity->requirements)) !!}
                    </div>
                    
                    @if($opportunity->required_skills)
                    <div class="mt-3">
                        <h6 class="text-muted mb-2">Kỹ năng cần thiết:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $skills = is_array($opportunity->required_skills)
                                    ? $opportunity->required_skills
                                    : explode(',', $opportunity->required_skills ?? '');
                            @endphp

                            @foreach($skills as $skill)
                                <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mr-2 mb-2">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-3">
                        <span class="badge bg-info">
                            <i class="fas fa-chart-line"></i> 
                            Yêu cầu kinh nghiệm: {{ $opportunity->experience_needed }}
                        </span>
                        <span class="badge bg-warning text-dark ms-2">
                            <i class="fas fa-birthday-cake"></i> 
                            Độ tuổi tối thiểu: {{ $opportunity->min_age }} tuổi
                        </span>
                    </div>
                </div>
            </div>
            @endif

            @if($opportunity->benefits)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">
                        <i class="fas fa-gift text-warning"></i> Quyền lợi
                    </h4>
                    <div class="benefits-content">
                        {!! nl2br(e($opportunity->benefits)) !!}
                    </div>
                </div>
            </div>
            @endif

            @if($opportunity->latitude && $opportunity->longitude)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">
                        <i class="fas fa-map-marked-alt text-danger"></i> Bản đồ
                    </h4>
                    <div id="map" style="height: 300px; border-radius: 8px;"></div>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">
                        <i class="fas fa-star text-warning"></i> Đánh giá từ tình nguyện viên
                    </h4>
                    
                    @if($reviews->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-comments fa-3x mb-3"></i>
                        <p>Chưa có đánh giá nào</p>
                    </div>
                    @else
                    <div class="reviews-list">
                        @foreach($reviews as $review)
                        <div class="review-item border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-start">
                                <img src="{{ $review->reviewer->avatar_url ? asset('storage/' . $review->reviewer->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($review->reviewer->first_name).'&background=3B82F6&color=fff' }}" 
                                     alt="{{ $review->reviewer->first_name }}"
                                     class="rounded-circle me-3"
                                     style="width: 40px; height: 40px;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div>
                                            <h6 class="mb-0">{{ $review->reviewer->first_name }} {{ $review->reviewer->last_name }}</h6>
                                            <div class="text-warning small">
                                                @for($i = 0; $i < 5; $i++)
                                                    <i class="fas fa-star{{ $i < $review->rating ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                    @if($review->review_title)
                                    <h6 class="fw-semibold">{{ $review->review_title }}</h6>
                                    @endif
                                    <p class="mb-0 small">{{ $review->review_text }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            
            <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="mb-3">
                        <i class="fas fa-info-circle text-primary"></i> Thông tin quan trọng
                    </h5>

                    <div class="mb-3">
                        <h6 class="text-muted small mb-2">
                            <i class="fas fa-calendar-alt"></i> Lịch trình
                        </h6>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small">Bắt đầu:</span>
                            <span class="small fw-semibold">{{ \Carbon\Carbon::parse($opportunity->start_date)->format('d/m/Y') }}</span>
                        </div>
                        @if($opportunity->end_date)
                        <div class="d-flex justify-content-between">
                            <span class="small">Kết thúc:</span>
                            <span class="small fw-semibold">{{ \Carbon\Carbon::parse($opportunity->end_date)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>

                    <hr>

                    @if($opportunity->application_deadline)
                    <div class="mb-3">
                        <h6 class="text-muted small mb-2">
                            <i class="fas fa-hourglass-end"></i> Hạn nộp đơn
                        </h6>
                        <span class="badge bg-danger">
                            {{ \Carbon\Carbon::parse($opportunity->application_deadline)->format('d/m/Y H:i') }}
                        </span>
                        @php
                            $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($opportunity->application_deadline), false);
                        @endphp
                        @if($daysLeft > 0)
                        <small class="d-block text-muted mt-1">Còn {{ $daysLeft }} ngày</small>
                        @endif
                    </div>
                    <hr>
                    @endif

                    <div class="mb-3">
                        <h6 class="text-muted small mb-2">
                            <i class="fas fa-sync-alt"></i> Loại lịch
                        </h6>
                        <span class="badge bg-info">{{ $opportunity->schedule_type }}</span>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt"></i> Địa điểm
                        </h6>
                        <p class="mb-0 small">{{ $opportunity->location }}</p>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="text-muted small mb-2">
                            <i class="fas fa-phone"></i> Liên hệ
                        </h6>
                        @if($opportunity->organization->user->phone)
                        <p class="mb-1 small">
                            <i class="fas fa-phone text-success"></i>
                            {{ $opportunity->organization->user->phone }}
                        </p>
                        @endif
                        <p class="mb-0 small">
                            <i class="fas fa-envelope text-primary"></i>
                            {{ $opportunity->organization->user->email }}
                        </p>
                    </div>

                    <hr>
                    <div>
                        <h6 class="text-muted small mb-2">
                            <i class="fas fa-share-alt"></i> Chia sẻ
                        </h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($opportunity->title) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-info">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-secondary" onclick="copyLink()">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>

                    <hr>
                    <div class="text-center small text-muted">
                        <i class="fas fa-eye"></i> {{ $opportunity->view_count }} lượt xem
                    </div>

                </div>
            </div>

            @if($similarOpportunities->isNotEmpty())
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">
                        <i class="fas fa-lightbulb text-warning"></i> Cơ hội tương tự
                    </h5>
                    @foreach($similarOpportunities as $similar)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-1">
                            <a href="{{ route('opportunities.show', $similar->opportunity_id) }}" 
                               class="text-dark text-decoration-none">
                                {{ Str::limit($similar->title, 50) }}
                            </a>
                        </h6>
                        <small class="text-muted d-block mb-1">
                            <i class="fas fa-building"></i> {{ $similar->organization->organization_name }}
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt text-primary"></i> {{ Str::limit($similar->location, 20) }}
                        </small>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .opportunity-description,
    .requirements-content,
    .benefits-content {
        line-height: 1.8;
        color: #374151;
    }
    
    .review-item:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    
    .favorite-btn.active {
        background-color: #EF4444;
        border-color: #EF4444;
        color: white;
    }
    
    .favorite-btn.active:hover {
        background-color: #DC2626;
        border-color: #DC2626;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
$(document).ready(function() {
    // Initialize map if coordinates exist
    @if($opportunity->latitude && $opportunity->longitude)
    const map = L.map('map').setView([{{ $opportunity->latitude }}, {{ $opportunity->longitude }}], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    L.marker([{{ $opportunity->latitude }}, {{ $opportunity->longitude }}])
        .addTo(map)
        .bindPopup('<b>{{ $opportunity->title }}</b><br>{{ $opportunity->location }}');
    @endif

    // Favorite functionality
    $('.favorite-btn').click(function(e) {
        e.preventDefault();
        const btn = $(this);
        const opportunityId = btn.data('opportunity-id');
        
        $.ajax({
            url: '{{ route("api.favorites.toggle") }}',
            method: 'POST',
            data: {
                opportunity_id: opportunityId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    btn.toggleClass('active');
                    const isActive = btn.hasClass('active');
                    btn.find('span').text(isActive ? 'Đã lưu' : 'Lưu');
                    
                    showToast(
                        response.action === 'added' ? 'Đã thêm vào yêu thích' : 'Đã xóa khỏi yêu thích',
                        'success'
                    );
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

// Copy link function
function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        showToast('Đã sao chép liên kết', 'success');
    }).catch(() => {
        showToast('Không thể sao chép liên kết', 'error');
    });
}

// Toast notification function
function showToast(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    const toast = $(`
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed shadow-lg" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="fas ${icon} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);
    
    $('body').append(toast);
    
    setTimeout(function() {
        toast.fadeOut(function() {
            $(this).remove();
        });
    }, 3000);
}
</script>
@endpush
@endsection