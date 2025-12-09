{{-- resources/views/volunteer/dashboard.blade.php --}}
@extends('layouts.volunteer')

@section('title', 'Trang chủ • Tình nguyện viên')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #8b5cf6;
        --primary-dark: #7c3aed;
    }
    body { font-family: 'Inter', sans-serif; }
    .main-content {background: linear-gradient(to bottom right, #faf5ff, #f3e8ff); min-height: 100vh; }
    .gradient-btn { 
        @apply bg-gradient-to-r from-purple-600 to-purple-700 text-white font-medium rounded-full px-6 py-2.5 transition hover:shadow-lg hover:-translate-y-0.5;
    }
</style>
@endpush

@section('content')
<div class="flex">
    <main class="main-content w-full">
        
        {{-- Banner xác thực (Giữ nguyên từ bước trước) --}}
        @if(!Auth::user()->email_verified_at)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 m-6 mb-0 shadow-md rounded-r-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mr-4"></i>
                        <div>
                            <h3 class="font-bold text-yellow-800">Tài khoản chưa xác thực</h3>
                            <p class="text-sm text-yellow-700">Vui lòng kiểm tra email để kích hoạt đầy đủ tính năng.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('email.resend') }}">
                        @csrf
                        <button type="submit" class="text-white bg-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-sm px-5 py-2.5 transition">
                            <i class="fas fa-paper-plane mr-2"></i>Gửi lại Email
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <div class="bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 text-white py-12 px-10 {{ !Auth::user()->email_verified_at ? 'mt-6' : '' }}">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-bold mb-2">
                    Xin chào, {{ auth()->user()->first_name }}!
                </h1>
                <p class="text-lg opacity-95">Hôm nay bạn muốn lan tỏa điều gì?</p>
                <p class="text-sm opacity-80 mt-2">{{ now()->translatedFormat('l, d/m/Y') }}</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
                <div class="glass rounded-2xl p-5 text-center bg-white shadow-sm">
                    <i class="fas fa-clock text-3xl text-purple-600 mb-2"></i>
                    <div class="text-3xl font-bold text-purple-700">{{ $stats['total_hours'] }}</div>
                    <p class="text-sm text-gray-600">Giờ đóng góp</p>
                </div>
                <div class="glass rounded-2xl p-5 text-center bg-white shadow-sm">
                    <i class="fas fa-check-circle text-3xl text-emerald-500 mb-2"></i>
                    <div class="text-3xl font-bold text-emerald-600">{{ $stats['accepted_applications'] }}</div>
                    <p class="text-sm text-gray-600">Đã tham gia</p>
                </div>
                <div class="glass rounded-2xl p-5 text-center bg-white shadow-sm">
                    <i class="fas fa-hourglass-half text-3xl text-amber-500 mb-2"></i>
                    <div class="text-3xl font-bold text-amber-600">{{ $stats['pending_applications'] }}</div>
                    <p class="text-sm text-gray-600">Chờ duyệt</p>
                </div>
                <div class="glass rounded-2xl p-5 text-center bg-white shadow-sm">
                    <i class="fas fa-star text-3xl text-rose-500 mb-2"></i>
                    <div class="text-3xl font-bold text-rose-600">{{ number_format($stats['rating'], 1) }}/5.0</div>
                    <p class="text-sm text-gray-600">Đánh giá</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-7">
                <div class="lg:col-span-2 space-y-7">
                    <div class="glass rounded-2xl overflow-hidden bg-white shadow-md">
                        <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-5 flex justify-between items-center">
                            <h3 class="text-lg font-bold">Cơ hội mới nhất cho bạn</h3>
                            <a href="{{ route('opportunities.index') }}" class="text-sm font-medium hover:underline">Xem tất cả →</a>
                        </div>
                        <div class="p-5 space-y-4">
                            @forelse($recommendations as $opp)
                                <div class="flex gap-4 p-4 rounded-xl hover:bg-purple-50 transition border border-gray-100">
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-xl flex-shrink-0 shadow-sm">
                                        {{-- Hiển thị icon theo category nếu có --}}
                                        <i class="{{ $opp->category->icon ?? 'fas fa-heart' }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-purple-800 truncate text-lg">
                                            <a href="{{ route('opportunities.show', $opp->opportunity_id) }}" class="hover:underline">
                                                {{ $opp->title }}
                                            </a>
                                        </h4>
                                        <p class="text-sm text-gray-600 mt-1 flex items-center gap-1">
                                            <i class="fas fa-building text-gray-400"></i>
                                            {{ $opp->organization->organization_name }}
                                        </p>
                                        <div class="flex items-center gap-3 mt-2">
                                            <span class="text-xs px-2.5 py-1 bg-purple-100 text-purple-700 rounded-full font-medium">
                                                Match {{ $opp->match_score }}%
                                            </span>
                                            <span class="text-xs px-2.5 py-1 bg-green-100 text-green-700 rounded-full font-medium">
                                                <i class="fas fa-map-marker-alt mr-1"></i> {{ Str::limit($opp->location, 20) }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('volunteer.applications.create', $opp->opportunity_id) }}" class="gradient-btn text-sm self-center shadow-md">
                                        Ứng tuyển
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-12 text-gray-500">
                                    <i class="fas fa-search text-5xl mb-3 text-purple-200"></i>
                                    <p class="text-base font-medium">Hiện chưa có cơ hội mới phù hợp.</p>
                                    <p class="text-sm">Hãy thử tìm kiếm các cơ hội khác!</p>
                                    <a href="{{ route('opportunities.index') }}" class="mt-4 inline-block text-sm text-purple-600 hover:underline font-semibold">Tìm kiếm ngay →</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-5">
                        <div class="glass rounded-2xl p-5 bg-white shadow-md">
                            <h3 class="text-base font-bold text-purple-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-chart-line"></i> Hoạt động gần đây (Giờ)
                            </h3>
                            @if(count($chartValues) > 0)
                                <canvas id="activityChart" height="200"></canvas>
                            @else
                                <div class="h-40 flex items-center justify-center text-gray-400 text-sm italic border-2 border-dashed border-gray-200 rounded-xl">
                                    Chưa có dữ liệu hoạt động
                                </div>
                            @endif
                        </div>
                        <div class="glass rounded-2xl p-5 bg-white shadow-md">
                            <h3 class="text-base font-bold text-purple-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-chart-pie"></i> Lĩnh vực tham gia
                            </h3>
                            @if(count($fieldValues) > 0)
                                <canvas id="fieldChart" height="200"></canvas>
                            @else
                                <div class="h-40 flex items-center justify-center text-gray-400 text-sm italic border-2 border-dashed border-gray-200 rounded-xl">
                                    Chưa tham gia hoạt động nào
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-7">
                    <div class="glass rounded-2xl p-5 bg-white shadow-md">
                        <h3 class="text-base font-bold text-purple-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-trophy text-yellow-500"></i> Thành tựu & Huy hiệu
                        </h3>
                        <div class="space-y-3">
                            @forelse($achievements as $ach)
                                <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl border border-purple-100 hover:bg-purple-100 transition cursor-default">
                                    <div class="text-2xl">{{ $ach['icon'] }}</div>
                                    <div class="text-sm">
                                        <div class="font-semibold text-purple-800">{{ $ach['title'] }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-xs text-gray-500 py-6">Hoàn thành hoạt động để nhận huy hiệu!</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="glass rounded-2xl p-5 bg-white shadow-md">
                        <h3 class="text-base font-bold text-purple-800 mb-4">Hành động nhanh</h3>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <a href="{{ route('opportunities.index') }}" class="bg-purple-600 text-white p-4 rounded-xl text-center hover:bg-purple-700 hover:shadow-lg transition duration-200">
                                <i class="fas fa-search text-xl mb-2"></i><br><span class="font-semibold">Tìm cơ hội</span>
                            </a>
                            <a href="{{ route('volunteer.activities.create') }}" class="bg-emerald-500 text-white p-4 rounded-xl text-center hover:bg-emerald-600 hover:shadow-lg transition duration-200">
                                <i class="fas fa-plus-circle text-xl mb-2"></i><br><span class="font-semibold">Log giờ làm</span>
                            </a>
                            <a href="{{ route('volunteer.profile.edit') }}" class="bg-sky-500 text-white p-4 rounded-xl text-center hover:bg-sky-600 hover:shadow-lg transition duration-200">
                                <i class="fas fa-user-edit text-xl mb-2"></i><br><span class="font-semibold">Sửa hồ sơ</span>
                            </a>
                            <a href="{{ route('volunteer.analytics') }}" class="bg-orange-500 text-white p-4 rounded-xl text-center hover:bg-orange-600 hover:shadow-lg transition duration-200">
                                <i class="fas fa-chart-bar text-xl mb-2"></i><br><span class="font-semibold">Xem thống kê</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dữ liệu từ Controller (PHP) chuyển sang JS
    const chartLabels = @json($chartLabels);
    const chartValues = @json($chartValues);
    const fieldLabels = @json($fieldLabels);
    const fieldValues = @json($fieldValues);

    // Vẽ biểu đồ Hoạt động (Line Chart)
    if (document.getElementById('activityChart') && chartLabels.length > 0) {
        new Chart(document.getElementById('activityChart'), {
            type: 'line',
            data: { 
                labels: chartLabels, 
                datasets: [{ 
                    label: 'Giờ làm',
                    data: chartValues, 
                    borderColor: '#8b5cf6', 
                    backgroundColor: 'rgba(139,92,246,0.1)', 
                    tension: 0.4, 
                    fill: true,
                    pointBackgroundColor: '#7c3aed',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#7c3aed'
                }] 
            },
            options: { 
                responsive: true, 
                plugins: { legend: { display: false } }, 
                scales: { 
                    y: { 
                        beginAtZero: true,
                        ticks: { stepSize: 1 } 
                    } 
                } 
            }
        });
    }

    // Vẽ biểu đồ Lĩnh vực (Doughnut Chart)
    if (document.getElementById('fieldChart') && fieldLabels.length > 0) {
        new Chart(document.getElementById('fieldChart'), {
            type: 'doughnut',
            data: { 
                labels: fieldLabels, 
                datasets: [{ 
                    data: fieldValues, 
                    backgroundColor: ['#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#ec4899'],
                    borderWidth: 0
                }] 
            },
            options: { 
                responsive: true, 
                plugins: { 
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } 
                },
                cutout: '70%'
            }
        });
    }
</script>
@endpush
@endsection