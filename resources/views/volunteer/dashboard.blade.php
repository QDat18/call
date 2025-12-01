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
    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero nhỏ hơn, nhẹ nhàng hơn -->
        <div class="bg-gradient-to-r from-purple-600 via-pink-500 to-orange-400 text-white py-12 px-10">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-bold mb-2">
                    Xin chào, {{ auth()->user()->first_name }}!
                </h1>
                <p class="text-lg opacity-95">Hôm nay bạn muốn lan tỏa điều gì?</p>
                <p class="text-sm opacity-80 mt-2">{{ now()->translatedFormat('l, d/m/Y') }}</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- 4 thẻ thống kê nhỏ gọn -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
                <div class="glass rounded-2xl p-5 text-center">
                    <i class="fas fa-clock text-3xl text-purple-600 mb-2"></i>
                    <div class="text-3xl font-bold text-purple-700">{{ $stats['total_hours'] ?? 0 }}</div>
                    <p class="text-sm text-gray-600">Giờ đóng góp</p>
                </div>
                <div class="glass rounded-2xl p-5 text-center">
                    <i class="fas fa-check-circle text-3xl text-emerald-500 mb-2"></i>
                    <div class="text-3xl font-bold text-emerald-600">{{ $stats['accepted_applications'] ?? 0 }}</div>
                    <p class="text-sm text-gray-600">Đã tham gia</p>
                </div>
                <div class="glass rounded-2xl p-5 text-center">
                    <i class="fas fa-hourglass-half text-3xl text-amber-500 mb-2"></i>
                    <div class="text-3xl font-bold text-amber-600">{{ $stats['pending_applications'] ?? 0 }}</div>
                    <p class="text-sm text-gray-600">Chờ duyệt</p>
                </div>
                <div class="glass rounded-2xl p-5 text-center">
                    <i class="fas fa-star text-3xl text-rose-500 mb-2"></i>
                    <div class="text-3xl font-bold text-rose-600">{{ number_format($stats['rating'] ?? 5, 1) }}/5.0</div>
                    <p class="text-sm text-gray-600">Đánh giá</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-7">
                <!-- Cột trái -->
                <div class="lg:col-span-2 space-y-7">
                    <!-- Gợi ý cơ hội (dựa trên skills_required khớp với skills của user) -->
                    <div class="glass rounded-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-5 flex justify-between items-center">
                            <h3 class="text-lg font-bold">Cơ hội phù hợp với kỹ năng của bạn</h3>
                            <a href="{{ route('opportunities.index') }}" class="text-sm font-medium hover:underline">Xem tất cả →</a>
                        </div>
                        <div class="p-5 space-y-4">
                            @forelse($recommendations as $opp)
                                <div class="flex gap-4 p-4 rounded-xl hover:bg-purple-50 transition">
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-xl flex-shrink-0">
                                        <i class="{{ $opp->category->icon ?? 'fas fa-heart' }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-purple-800 truncate">
                                            <a href="{{ route('opportunities.show', $opp->opportunity_id) }}">{{ $opp->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-600 mt-1">{{ $opp->organization->organization_name }}</p>
                                        <div class="flex items-center gap-3 mt-2">
                                            <span class="text-xs px-2.5 py-1 bg-purple-100 text-purple-700 rounded-full font-medium">
                                                Match {{ $opp->match_score ?? 90 }}%
                                            </span>
                                            <span class="text-xs px-2.5 py-1 bg-green-100 text-green-700 rounded-full font-medium">
                                                Kỹ năng: {{ Str::limit($opp->skills_required ?? 'N/A', 30) }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('volunteer.applications.create', $opp->opportunity_id) }}" class="gradient-btn text-sm self-center">
                                        Ứng tuyển
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-12 text-gray-500">
                                    <i class="fas fa-heart text-5xl mb-3 text-purple-200"></i>
                                    <p class="text-sm">Chưa có gợi ý phù hợp. Hãy cập nhật kỹ năng trong hồ sơ để nhận gợi ý chính xác hơn!</p>
                                    <a href="{{ route('volunteer.profile.edit') }}" class="mt-4 text-sm text-purple-600 hover:underline">Cập nhật hồ sơ →</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Biểu đồ nhỏ gọn -->
                    <div class="grid md:grid-cols-2 gap-5">
                        <div class="glass rounded-2xl p-5">
                            <h3 class="text-base font-bold text-purple-800 mb-4">Hoạt động gần đây</h3>
                            <canvas id="activityChart" height="160"></canvas>
                        </div>
                        <div class="glass rounded-2xl p-5">
                            <h3 class="text-base font-bold text-purple-800 mb-4">Lĩnh vực yêu thích</h3>
                            <canvas id="fieldChart" height="160"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="space-y-7">
                    <!-- Thành tựu -->
                    <div class="glass rounded-2xl p-5">
                        <h3 class="text-base font-bold text-purple-800 mb-4">Thành tựu</h3>
                        <div class="space-y-3">
                            @forelse($achievements ?? [] as $ach)
                                <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl">
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

                    <!-- Hành động nhanh -->
                    <div class="glass rounded-2xl p-5">
                        <h3 class="text-base font-bold text-purple-800 mb-4">Hành động nhanh</h3>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <a href="{{ route('opportunities.index') }}" class="bg-purple-600 text-white p-4 rounded-xl text-center hover:shadow-md transition">
                                <i class="fas fa-search text-xl mb-1"></i><br>Tìm cơ hội
                            </a>
                            <a href="{{ route('volunteer.activities.create') }}" class="bg-emerald-600 text-white p-4 rounded-xl text-center hover:shadow-md transition">
                                <i class="fas fa-plus text-xl mb-1"></i><br>Log giờ
                            </a>
                            <a href="{{ route('volunteer.profile.edit') }}" class="bg-sky-600 text-white p-4 rounded-xl text-center hover:shadow-md transition">
                                <i class="fas fa-user-edit text-xl mb-1"></i><br>Hồ sơ
                            </a>
                            <a href="{{ route('volunteer.analytics') }}" class="bg-orange-600 text-white p-4 rounded-xl text-center hover:shadow-md transition">
                                <i class="fas fa-chart-bar text-xl mb-1"></i><br>Thống kê
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
    new Chart(document.getElementById('activityChart'), {
        type: 'line',
        data: { labels: ['T1', 'T2', 'T3', 'T4'], datasets: [{ data: [8,15,12,25], borderColor: '#8b5cf6', backgroundColor: 'rgba(139,92,246,0.1)', tension: 0.4, fill: true }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('fieldChart'), {
        type: 'doughnut',
        data: { labels: ['Môi trường','Giáo dục','Sức khỏe','Cộng đồng'], datasets: [{ data: [35,30,20,15], backgroundColor: ['#8b5cf6','#10b981','#f59e0b','#ef4444'] }] },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endpush
@endsection