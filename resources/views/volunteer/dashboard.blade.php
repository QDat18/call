{{-- resources/views/volunteer/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Bảng Điều Khiển - Tình Nguyện Viên')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
    :root {
        --purple-500: #8b5cf6;
        --purple-600: #7c3aed;
        --purple-700: #6b46c1;
        --purple-800: #5b21b6;
    }
    .gradient-purple { background: linear-gradient(135deg, var(--purple-500), var(--purple-700)); }
    .btn-gradient { 
        @apply bg-gradient-to-r from-purple-600 to-purple-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform transition hover:scale-105 hover:shadow-2xl;
    }
    .card-hover { @apply transition transform hover:-translate-y-1 hover:shadow-2xl; }
    .badge-glow { @apply shadow-lg shadow-purple-500/50; }
    .like-btn.liked { @apply text-purple-600; }
    .like-btn.liked svg { @apply fill-purple-600; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50">
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <img src="{{ auth()->user()->avatar_url ? asset('storage/'.auth()->user()->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->first_name).'&background=8b5cf6&color=fff' }}" 
                         class="w-24 h-24 rounded-full border-4 border-white shadow-2xl object-cover">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">Xin chào, {{ auth()->user()->first_name }}!</h1>
                        <p class="text-xl opacity-90">Hôm nay bạn sẽ lan tỏa điều tốt đẹp nào?</p>
                    </div>
                </div>
                <div class="text-center bg-white/20 backdrop-blur-md rounded-2xl p-6">
                    <div class="text-5xl font-bold">{{ $stats['total_hours'] ?? 0 }}</div>
                    <div class="text-lg opacity-90">Giờ tình nguyện</div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-2xl shadow-xl p-6 text-center card-hover border border-purple-100">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center text-white text-2xl">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="text-3xl font-bold text-purple-700">{{ $stats['total_hours'] ?? 0 }}</div>
                <div class="text-gray-600">Tổng giờ</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-6 text-center card-hover border border-purple-100">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-full flex items-center justify-center text-white text-2xl">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_applications'] ?? 0 }}</div>
                <div class="text-gray-600">Đơn chờ duyệt</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-6 text-center card-hover border border-purple-100">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white text-2xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="text-3xl font-bold text-green-600">{{ $stats['accepted_applications'] ?? 0 }}</div>
                <div class="text-gray-600">Được chấp nhận</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-6 text-center card-hover border border-purple-100">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center text-white text-2xl">
                    <i class="fas fa-star"></i>
                </div>
                <div class="text-3xl font-bold text-pink-600">{{ number_format($stats['rating'] ?? 0, 1) }}</div>
                <div class="text-gray-600">Đánh giá</div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl shadow-xl border border-purple-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold">Gợi Ý Dành Riêng Cho Bạn</h3>
                            <a href="{{ route('opportunities.index') }}" class="btn-gradient text-sm">Xem Tất Cả</a>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        @forelse($recommendations as $opportunity)
                            <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-purple-50 transition card-hover">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                        <i class="{{ $opportunity->category->icon ?? 'fas fa-heart' }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h4 class="font-bold text-lg text-purple-800">
                                        <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" class="hover:text-purple-600">
                                            {{ $opportunity->title }}
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-building"></i> {{ $opportunity->organization->organization_name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt"></i> {{ $opportunity->location }} • 
                                        <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($opportunity->start_date)->format('d/m/Y') }}
                                    </p>
                                    <div class="mt-2">
                                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold badge-glow">
                                            Match: {{ $opportunity->match_score ?? 85 }}%
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    {{-- SỬA LỖI 1 & 2: Tên route đúng là volunteer.applications.create và truyền ID trực tiếp --}}
                                    <a href="{{ route('volunteer.applications.create', $opportunity->opportunity_id) }}" 
                                       class="btn-gradient text-sm">Ứng Tuyển Ngay</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i class="fas fa-search text-6xl text-purple-300 mb-4"></i>
                                <p class="text-xl text-gray-600">Chưa có gợi ý phù hợp</p>
                                <a href="{{ route('volunteer.profile.edit') }}" class="mt-4 inline-block btn-gradient">
                                    Cập Nhật Hồ Sơ Để Nhận Gợi Ý Tốt Hơn
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl border border-purple-100">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white p-6">
                        <h3 class="text-2xl font-bold">Đơn Ứng Tuyển Gần Đây</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-purple-700 border-b border-purple-200">
                                        <th class="pb-3">Cơ Hội</th>
                                        <th class="pb-3">Tổ Chức</th>
                                        <th class="pb-3">Ngày Nộp</th>
                                        <th class="pb-3">Trạng Thái</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentApplications as $app)
                                        <tr class="border-b border-purple-100 hover:bg-purple-50 transition">
                                            <td class="py-4">
                                                <a href="{{ route('opportunities.show', $app->opportunity->opportunity_id) }}" class="font-medium text-purple-800 hover:text-purple-600">
                                                    {{ Str::limit($app->opportunity->title, 40) }}
                                                </a>
                                            </td>
                                            <td class="py-4 text-gray-600">{{ $app->opportunity->organization->organization_name }}</td>
                                            <td class="py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($app->applied_date)->format('d/m/Y') }}</td>
                                            <td class="py-4">
                                                @php
                                                    $status = $app->status;
                                                    $colors = [
                                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                                        'Accepted' => 'bg-green-100 text-green-800',
                                                        'Rejected' => 'bg-red-100 text-red-800',
                                                        'Under Review' => 'bg-blue-100 text-blue-800'
                                                    ];
                                                @endphp
                                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                            <td class="py-4 text-right">
                                                {{-- SỬA LỖI TÊN ROUTE: volunteer.applications.show --}}
                                                <a href="{{ route('volunteer.applications.show', $app->application_id) }}" class="text-purple-600 hover:text-purple-800">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-12 text-gray-500">
                                                <i class="fas fa-file-alt text-6xl mb-4 text-purple-300"></i>
                                                <p class="text-xl">Chưa có đơn ứng tuyển nào</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-purple-100">
                    <h3 class="text-xl font-bold text-purple-800 mb-6">Hoạt Động Gần Đây</h3>
                    <canvas id="activityChart" height="240"></canvas>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border border-purple-100">
                    <h3 class="text-xl font-bold text-purple-800 mb-6">Hành Động Nhanh</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('opportunities.index') }}" class="bg-gradient-to-br from-purple-500 to-purple-700 text-white p-4 rounded-xl text-center hover:shadow-xl transition card-hover">
                            <i class="fas fa-search text-2xl mb-2"></i>
                            <span class="block font-semibold">Tìm Cơ Hội</span>
                        </a>
                        <a href="{{ route('volunteer.activities.create') }}" class="bg-gradient-to-br from-green-500 to-emerald-600 text-white p-4 rounded-xl text-center hover:shadow-xl transition card-hover">
                            <i class="fas fa-plus text-2xl mb-2"></i>
                            <span class="block font-semibold">Log Giờ</span>
                        </a>
                        <a href="{{ route('volunteer.profile.edit') }}" class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white p-4 rounded-xl text-center hover:shadow-xl transition card-hover">
                            <i class="fas fa-user-edit text-2xl mb-2"></i>
                            <span class="block font-semibold">Hồ Sơ</span>
                        </a>
                        <a href="{{ route('volunteer.analytics') }}" class="bg-gradient-to-br from-orange-500 to-red-600 text-white p-4 rounded-xl text-center hover:shadow-xl transition card-hover">
                            <i class="fas fa-chart-bar text-2xl mb-2"></i>
                            <span class="block font-semibold">Thống Kê</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 border border-purple-100">
                    <h3 class="text-xl font-bold text-purple-800 mb-6">Thành Tích Nổi Bật</h3>
                    <div class="space-y-4">
                        @forelse($achievements ?? [] as $achievement)
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                                <div class="text-3xl">{{ $achievement['icon'] }}</div>
                                <div>
                                    <div class="font-bold text-purple-800">{{ $achievement['title'] }}</div>
                                    <div class="text-sm text-gray-600">{{ $achievement['description'] ?? '' }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-medal text-6xl text-purple-300 mb-4"></i>
                                <p class="text-gray-600">Hoàn thành hoạt động để nhận thành tích!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // SỬA LỖI 3: Lấy dữ liệu từ biến $chartData của Controller
    // Vì $chartData là mảng ['labels' => ..., 'data' => ...], ta cần lấy đúng key
    const chartConfig = {!! json_encode($chartData ?? ['labels' => [], 'data' => []]) !!};

    // Activity Chart
    const ctx = document.getElementById('activityChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: chartConfig.labels, // Lấy labels từ mảng
                datasets: [{
                    label: 'Giờ tình nguyện',
                    data: chartConfig.data, // Lấy data từ mảng
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#8b5cf6',
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
</script>
@endpush
@endsection