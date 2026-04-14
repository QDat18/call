@extends('layouts.app')

@section('title', $opportunity->title . ' - Volunteer Connect')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="flex text-gray-500 text-sm mb-6" aria-label="Breadcrumb">
                {{-- ... Giữ nguyên Breadcrumb ... --}}
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Trang chủ</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs mx-2"></i></li>
                    <li>
                        <a href="{{ route('opportunities.index') }}" class="hover:text-indigo-600 transition">Cơ hội</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs mx-2"></i></li>
                    <li aria-current="page" class="font-medium text-gray-800 truncate max-w-[200px]">
                        {{ $opportunity->title }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT COLUMN: CONTENT --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Hero Card --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 relative overflow-hidden">
                        {{-- Status Badge & Favorite --}}
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex gap-2">
                                <span class="px-3 py-1 rounded-full text-xs font-bold text-white flex items-center gap-1"
                                    style="background-color: {{ $opportunity->category_color_label }}">
                                    <i class="{{ $opportunity->category_icon_label }}"></i>
                                    {{ $opportunity->category_name_label }}
                                </span>
                                @if($opportunity->status === 'Active')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        <i class="fas fa-check-circle mr-1"></i> Đang mở
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                        {{ $opportunity->status }}
                                    </span>
                                @endif
                            </div>

                            {{-- === NÚT YÊU THÍCH (ĐÃ SỬA) === --}}
                            @auth
                                @if(auth()->user()->user_type === 'Volunteer')
                                    <button
                                        class="favorite-btn group w-10 h-10 rounded-full bg-gray-50 hover:bg-red-50 flex items-center justify-center transition-all duration-300 {{ $isFavorited ? 'active bg-red-50' : '' }}"
                                        onclick="toggleFavorite(this, {{ $opportunity->opportunity_id }})"
                                        title="{{ $isFavorited ? 'Bỏ yêu thích' : 'Yêu thích' }}">
                                        {{-- Icon: Nếu đã like thì màu đỏ, chưa like thì màu xám --}}
                                        <i
                                            class="fas fa-heart text-lg transition-colors duration-300 {{ $isFavorited ? 'text-red-500' : 'text-gray-300 group-hover:text-red-400' }}"></i>
                                    </button>
                                @endif
                            @endauth
                        </div>

                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                            {{ $opportunity->title }}</h1>

                        {{-- ... Giữ nguyên phần Organization Info ... --}}
                        <div class="flex items-center p-4 bg-gray-50 rounded-2xl mb-6">
                            <img src="{{ $opportunity->organization->user->avatar_url ? asset('storage/' . $opportunity->organization->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($opportunity->organization->organization_name) . '&background=6366f1&color=fff' }}"
                                alt="{{ $opportunity->organization->organization_name }}"
                                class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm mr-4">
                            <div>
                                <h6 class="font-bold text-gray-800 text-lg flex items-center gap-1">
                                    <a href="{{ route('organizations.show', $opportunity->org_id) }}"
                                        class="hover:text-indigo-600 transition">
                                        {{ $opportunity->organization->organization_name }}
                                    </a>
                                    @if($opportunity->organization->verification_status === 'Verified')
                                        <i class="fas fa-check-circle text-blue-500 text-sm" title="Đã xác thực"></i>
                                    @endif
                                </h6>
                                <div class="text-sm text-gray-500 flex items-center gap-3">
                                    <span class="flex items-center text-yellow-500">
                                        <i class="fas fa-star mr-1"></i>
                                        {{ number_format($opportunity->organization->rating, 1) }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ $opportunity->organization->volunteer_count }} tình nguyện viên</span>
                                </div>
                            </div>
                        </div>

                        {{-- ... Giữ nguyên phần Stats, Progress Bar, Description ... --}}
                        {{-- Quick Stats Grid --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 p-4 rounded-2xl text-center">
                                <i class="fas fa-map-marker-alt text-blue-500 text-xl mb-2"></i>
                                <div class="text-xs text-gray-500 uppercase font-bold">Địa điểm</div>
                                <div class="font-semibold text-gray-800 text-sm truncate">
                                    {{ Str::limit($opportunity->location, 15) }}</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-2xl text-center">
                                <i class="fas fa-calendar text-green-500 text-xl mb-2"></i>
                                <div class="text-xs text-gray-500 uppercase font-bold">Bắt đầu</div>
                                <div class="font-semibold text-gray-800 text-sm">
                                    {{ $opportunity->formatted_start_date }}</div>
                            </div>
                            <div class="bg-orange-50 p-4 rounded-2xl text-center">
                                <i class="fas fa-clock text-orange-500 text-xl mb-2"></i>
                                <div class="text-xs text-gray-500 uppercase font-bold">Cam kết</div>
                                <div class="font-semibold text-gray-800 text-sm truncate">
                                    {{ $opportunity->time_commitment }}</div>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-2xl text-center">
                                <i class="fas fa-users text-purple-500 text-xl mb-2"></i>
                                <div class="text-xs text-gray-500 uppercase font-bold">Cần tuyển</div>
                                <div class="font-semibold text-gray-800 text-sm">{{ $opportunity->volunteers_needed }} người
                                </div>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="mt-6">
                            <div class="flex justify-between text-sm mb-2 font-medium">
                                <span class="text-gray-600">Đã đăng ký: <b
                                        class="text-indigo-600">{{ $opportunity->volunteers_registered }}/{{ $opportunity->volunteers_needed }}</b></span>
                                <span class="text-gray-500">{{ round($opportunity->registration_percentage) }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500"
                                    style="width: {{ min($opportunity->registration_percentage, 100) }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-align-left text-indigo-500"></i> Mô tả chi tiết
                        </h3>
                        <div class="prose max-w-none text-gray-600 leading-relaxed">
                            {!! nl2br(e($opportunity->description)) !!}
                        </div>
                    </div>

                    {{-- Requirements --}}
                    @if($opportunity->requirements || $opportunity->required_skills)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-clipboard-check text-green-500"></i> Yêu cầu
                            </h3>

                            @if($opportunity->requirements)
                                <div class="prose max-w-none text-gray-600 mb-6">
                                    {!! nl2br(e($opportunity->requirements)) !!}
                                </div>
                            @endif

                            @if($opportunity->required_skills)
                                <div class="mb-6">
                                    <h4 class="font-bold text-gray-700 text-sm uppercase mb-3">Kỹ năng chuyên môn:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($opportunity->required_skills as $skill)
                                            <span
                                                class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-semibold border border-indigo-100">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-4 mt-4">
                                <span class="px-4 py-2 bg-gray-100 rounded-xl text-sm font-medium text-gray-700">
                                    <i class="fas fa-briefcase mr-2 text-gray-400"></i> Kinh nghiệm:
                                    {{ $opportunity->experience_needed }}
                                </span>
                                <span class="px-4 py-2 bg-gray-100 rounded-xl text-sm font-medium text-gray-700">
                                    <i class="fas fa-birthday-cake mr-2 text-gray-400"></i> Tối thiểu:
                                    {{ $opportunity->min_age }} tuổi
                                </span>
                            </div>
                        </div>
                    @endif

                    {{-- Map --}}
                    @if($opportunity->latitude && $opportunity->longitude)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 overflow-hidden">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-map-marked-alt text-red-500"></i> Bản đồ
                            </h3>
                            <div id="map" class="h-80 w-full rounded-2xl z-0"></div>
                        </div>
                    @endif

                    {{-- Reviews (Giữ nguyên) --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-star text-yellow-500"></i> Đánh giá
                        </h3>

                        @if($reviews->isEmpty())
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-comment-slash text-gray-300 text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Chưa có đánh giá nào cho cơ hội này.</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($reviews as $review)
                                    <div class="flex gap-4 pb-6 border-b border-gray-50 last:border-0 last:pb-0">
                                        <img src="{{ $review->reviewer->avatar_url ? asset('storage/' . $review->reviewer->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($review->reviewer->first_name) . '&background=random' }}"
                                            alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h6 class="font-bold text-gray-800">{{ $review->reviewer->first_name }}
                                                    {{ $review->reviewer->last_name }}</h6>
                                                <div class="flex text-yellow-400 text-xs">
                                                    @for($i = 0; $i < 5; $i++)
                                                        <i class="fas fa-star{{ $i < $review->rating ? '' : '-o text-gray-300' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-400 mb-2">{{ $review->created_at->diffForHumans() }}</p>
                                            @if($review->review_title)
                                                <p class="font-bold text-gray-700 text-sm mb-1">{{ $review->review_title }}</p>
                                            @endif
                                            <p class="text-gray-600 text-sm leading-relaxed">{{ $review->review_text }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- RIGHT COLUMN: SIDEBAR (Giữ nguyên) --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        <div class="bg-white rounded-3xl shadow-lg border border-indigo-100 p-6">
                            <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-info-circle text-indigo-600"></i> Thông tin quan trọng
                            </h4>

                            <div class="space-y-4 text-sm">
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-gray-500"><i class="fas fa-hourglass-start mr-2"></i>Hạn nộp
                                        đơn</span>
                                    <span class="font-bold text-red-600">
                                        {{ $opportunity->formatted_deadline }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-gray-500"><i class="fas fa-calendar-alt mr-2"></i>Ngày bắt đầu</span>
                                    <span
                                        class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($opportunity->start_date)->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-gray-500"><i class="fas fa-sync mr-2"></i>Loại lịch</span>
                                    <span class="font-bold text-gray-800">{{ $opportunity->schedule_type }}</span>
                                </div>
                            </div>

                            {{-- <div class="mt-6">
                                @auth
                                    @if(auth()->user()->user_type === 'Volunteer')
                                        @if($hasApplied ?? false)
                                            <div
                                                class="w-full py-3 bg-blue-50 text-blue-600 font-bold rounded-xl text-center border border-blue-100">
                                                <i class="fas fa-check-circle mr-2"></i> Đã nộp đơn
                                            </div>
                                        @elseif($opportunity->status === 'Active' && $opportunity->volunteers_registered < $opportunity->volunteers_needed)
                                            <a href="{{ route('volunteer.applications.create', ['opportunity' => $opportunity->opportunity_id]) }}"
                                                class="block w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform duration-200">
                                                Nộp Đơn Ngay <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        @else
                                            <div class="w-full py-3 bg-gray-100 text-gray-500 font-bold rounded-xl text-center">
                                                Đã đóng đơn
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block w-full py-3 bg-indigo-50 text-indigo-600 font-bold rounded-xl text-center hover:bg-indigo-100 transition">
                                        Đăng nhập để ứng tuyển
                                    </a>
                                @endauth
                            </div> --}}
                            <div class="mt-6">
                                @auth
                                    @if(auth()->user()->user_type === 'Volunteer')
                                        {{-- LOGIC 1: Đã ứng tuyển --}}
                                        @if($hasApplied ?? false)
                                            <div class="w-full py-3 bg-blue-50 text-blue-600 font-bold rounded-xl text-center border border-blue-100">
                                                <i class="fas fa-check-circle mr-2"></i> Đã nộp đơn
                                            </div>
                                        
                                        {{-- LOGIC 2: Chưa xác thực (THÊM MỚI) --}}
                                        @elseif(!auth()->user()->is_verified)
                                            <div class="text-center">
                                                <div class="w-full py-3 bg-gray-100 text-gray-500 font-bold rounded-xl text-center mb-2 cursor-not-allowed">
                                                    <i class="fas fa-lock mr-2"></i> Chưa xác thực
                                                </div>
                                                <p class="text-xs text-red-500 px-2">
                                                    Bạn cần <a href="{{ route('volunteer.profile.profile') }}" class="underline font-bold">xác thực tài khoản</a> để ứng tuyển.
                                                </p>
                                            </div>

                                        {{-- LOGIC 3: Đủ điều kiện ứng tuyển --}}
                                        @elseif($opportunity->status === 'Active' && $opportunity->volunteers_registered < $opportunity->volunteers_needed)
                                            <a href="{{ route('volunteer.applications.create', ['opportunity' => $opportunity->opportunity_id]) }}"
                                                class="block w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform duration-200">
                                                Nộp Đơn Ngay <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        
                                        {{-- LOGIC 4: Đã đóng --}}
                                        @else
                                            <div class="w-full py-3 bg-gray-100 text-gray-500 font-bold rounded-xl text-center">
                                                Đã đóng đơn
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block w-full py-3 bg-indigo-50 text-indigo-600 font-bold rounded-xl text-center hover:bg-indigo-100 transition">
                                        Đăng nhập để ứng tuyển
                                    </a>
                                @endauth
                            </div>
                            {{-- Share Buttons --}}
                            <div class="mt-6 flex justify-center gap-3">
                                <button
                                    class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button
                                    class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button onclick="copyLink()"
                                    class="w-10 h-10 rounded-full bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-gray-600 hover:text-white transition">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <style>
            /* Animation cho nút tim */
            @keyframes heart-beat {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.3);
                }

                100% {
                    transform: scale(1);
                }
            }

            .heart-anim {
                animation: heart-beat 0.3s ease-in-out;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            // --- MAP LOGIC ---
            @if($opportunity->latitude && $opportunity->longitude)
                const map = L.map('map').setView([{{ $opportunity->latitude }}, {{ $opportunity->longitude }}], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                L.marker([{{ $opportunity->latitude }}, {{ $opportunity->longitude }}]).addTo(map)
                    .bindPopup('<b>{{ $opportunity->title }}</b>').openPopup();
            @endif

                // --- COPY LINK LOGIC ---
                function copyLink() {
                    navigator.clipboard.writeText(window.location.href);
                    // Có thể thay alert bằng toast notification đẹp hơn
                    alert('Đã sao chép liên kết!');
                }

            // --- FAVORITE LOGIC (AJAX) ---
            function toggleFavorite(btn, opportunityId) {
                // 1. Chặn click liên tục (spam click)
                if (btn.classList.contains('processing')) return;
                btn.classList.add('processing');

                const icon = btn.querySelector('i');

                // 2. Gửi AJAX
                fetch('{{ route("volunteer.favorites.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ opportunity_id: opportunityId })
                })
                    .then(response => {
                        if (!response.ok) {
                            if (response.status === 401) {
                                alert('Vui lòng đăng nhập để thực hiện chức năng này.');
                                return null;
                            }
                            throw new Error('Lỗi hệ thống');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data) return; // Nếu lỗi 401 đã return null ở trên

                        if (data.success) {
                            // === XỬ LÝ GIAO DIỆN TỨC THÌ (KHÔNG CẦN F5) ===

                            if (data.status === 'added') {
                                // TRƯỜNG HỢP: ĐÃ LIKE (Chuyển sang Đỏ)

                                // 1. Xóa màu xám và hiệu ứng hover cũ
                                icon.classList.remove('text-gray-300', 'group-hover:text-red-400');

                                // 2. Thêm màu đỏ và hiệu ứng tim đập
                                icon.classList.add('text-red-500', 'heart-anim');

                                // 3. Đổi màu nền nút
                                btn.classList.add('bg-red-50', 'active');

                                // 4. Cập nhật tooltip
                                btn.title = "Bỏ yêu thích";

                            } else {
                                // TRƯỜNG HỢP: BỎ LIKE (Chuyển về Xám)

                                // 1. Xóa màu đỏ và hiệu ứng tim đập
                                icon.classList.remove('text-red-500', 'heart-anim');

                                // 2. Thêm lại màu xám
                                icon.classList.add('text-gray-300', 'group-hover:text-red-400');

                                // 3. Xóa màu nền nút
                                btn.classList.remove('bg-red-50', 'active');

                                // 4. Cập nhật tooltip
                                btn.title = "Yêu thích";
                            }

                            // Xóa class animation sau 0.3s để lần sau click lại vẫn nhảy hiệu ứng
                            setTimeout(() => icon.classList.remove('heart-anim'), 300);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        // Mở khóa nút bấm
                        btn.classList.remove('processing');
                    });
            }
            </script>
    @endpush
@endsection