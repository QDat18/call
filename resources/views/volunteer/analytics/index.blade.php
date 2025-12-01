{{-- resources/views/analytics/index.blade.php --}}
@extends('layouts.volunteer')

@section('title', 'Phân Tích & Thống Kê')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
    :root { --purple: #8b5cf6; --indigo: #4f46e5; }
    .gradient-purple { background: linear-gradient(135deg, #8b5cf6, #6b46c1); }
    .card-hover { @apply transition transform hover:-translate-y-1 hover:shadow-2xl; }
    .chart-container { height: 380px; }
    .btn-back { @apply bg-white border-2 border-purple-600 text-purple-600 font-bold px-6 py-3 rounded-xl hover:bg-purple-600 hover:text-white transition transform hover:scale-105 shadow-lg; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">

        <!-- NÚT QUAY LẠI DASHBOARD -->
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="btn-back inline-flex items-center gap-3">
                <i class="fas fa-arrow-left"></i>
                Quay Lại Dashboard
            </a>
        </div>

        <!-- ADMIN DASHBOARD -->
        @if(auth()->user()->user_type === 'Admin')
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-purple-800 mb-4">
                    <i class="fas fa-crown text-yellow-500"></i> Quản Trị Viên - Tổng Quan Hệ Thống
                </h1>
                <p class="text-xl text-gray-600">Toàn cảnh VolunteerConnect trong tầm tay bạn</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-2xl p-8 text-center shadow-xl card-hover">
                    <div class="text-5xl font-bold">{{ number_format($metrics['total_users'] ?? 0) }}</div>
                    <div class="text-lg mt-2">Tổng Người Dùng</div>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-2xl p-8 text-center shadow-xl card-hover">
                    <div class="text-5xl font-bold">{{ number_format($metrics['total_volunteers'] ?? 0) }}</div>
                    <div class="text-lg mt-2">Tình Nguyện Viên</div>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-2xl p-8 text-center shadow-xl card-hover">
                    <div class="text-5xl font-bold">{{ number_format($metrics['total_opportunities'] ?? 0) }}</div>
                    <div class="text-lg mt-2">Cơ Hội</div>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-red-600 text-white rounded-2xl p-8 text-center shadow-xl card-hover">
                    <div class="text-5xl font-bold">{{ number_format($metrics['total_volunteer_hours'] ?? 0) }}</div>
                    <div class="text-lg mt-2">Giờ Tình Nguyện</div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid lg:grid-cols-2 gap-8 mb-12">
                <div class="bg-white rounded-3xl shadow-2xl p-8 border border-purple-100 card-hover">
                    <h3 class="text-2xl font-bold text-purple-800 mb-6 text-center">
                        <i class="fas fa-users mr-3"></i> Xu Hướng Người Dùng (30 ngày)
                    </h3>
                    <div class="chart-container">
                        <canvas id="userTrendChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-2xl p-8 border border-purple-100 card-hover">
                    <h3 class="text-2xl font-bold text-purple-800 mb-6 text-center">
                        <i class="fas fa-chart-bar mr-3"></i> Giờ Tình Nguyện Theo Tháng
                    </h3>
                    <div class="chart-container">
                        <canvas id="monthlyHoursChart"></canvas>
                    </div>
                </div>
            </div>

        <!-- ORGANIZATION DASHBOARD -->
        @elseif(auth()->user()->user_type === 'Organization')
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-purple-800 mb-4">
                    <i class="fas fa-building text-indigo-600"></i> {{ auth()->user()->organization->organization_name }}
                </h1>
                <p class="text-xl text-gray-600">Hiệu suất tổ chức của bạn</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-3xl shadow-2xl p-10 text-center border border-purple-100 card-hover">
                    <div class="text-7xl font-bold text-purple-700 mb-4">{{ $metrics['total_opportunities'] ?? 0 }}</div>
                    <div class="text-2xl text-gray-700 font-semibold">Cơ Hội Đã Đăng</div>
                </div>
                <div class="bg-white rounded-3xl shadow-2xl p-10 text-center border border-green-100 card-hover">
                    <div class="text-7xl font-bold text-green-600 mb-4">{{ $metrics['total_applications'] ?? 0 }}</div>
                    <div class="text-2xl text-gray-700 font-semibold">Đơn Ứng Tuyển</div>
                </div>
                <div class="bg-white rounded-3xl shadow-2xl p-10 text-center border border-blue-100 card-hover">
                    <div class="text-7xl font-bold text-blue-600 mb-4">{{ $metrics['total_volunteer_hours'] ?? 0 }}</div>
                    <div class="text-2xl text-gray-700 font-semibold">Giờ Tình Nguyện</div>
                </div>
            </div>

            <!-- Organization Chart -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-purple-100 card-hover">
                <h3 class="text-2xl font-bold text-purple-800 mb-6 text-center">
                    <i class="fas fa-chart-line mr-3"></i> Giờ Tình Nguyện Của Tổ Chức (6 tháng)
                </h3>
                <div class="chart-container">
                    <canvas id="orgHoursChart"></canvas>
                </div>
            </div>

        <!-- VOLUNTEER DASHBOARD -->
        @else
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-purple-800 mb-4">
                    <i class="fas fa-heart text-pink-600"></i> Hành Trình Của Bạn, {{ auth()->user()->first_name }}!
                </h1>
                <p class="text-xl text-gray-600">Mỗi giờ bạn cống hiến đều thay đổi thế giới</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-3xl shadow-2xl p-10 text-center border border-purple-100 card-hover">
                    <div class="text-7xl font-bold text-purple-700 mb-4">{{ $metrics['total_volunteer_hours'] ?? 0 }}</div>
                    <div class="text-2xl text-gray-700 font-semibold">Giờ Tình Nguyện</div>
                </div>
                <div class="bg-white rounded-3xl shadow-2xl p-10 text-center border border-green-100 card-hover">
                    <div class="text-7xl font-bold text-green-600 mb-4">{{ $metrics['accepted_applications'] ?? 0 }}</div>
                    <div class="text-2xl text-gray-700 font-semibold">Đơn Thành Công</div>
                </div>
                <div class="bg-white rounded-3xl shadow-2xl p-10 text-center border border-blue-100 card-hover">
                    <div class="text-7xl font-bold text-blue-600 mb-4">{{ $metrics['total_applications'] ?? 0 }}</div>
                    <div class="text-2xl text-gray-700 font-semibold">Tổng Đơn Gửi</div>
                </div>
            </div>

            <!-- Volunteer Chart -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-purple-100 card-hover">
                <h3 class="text-2xl font-bold text-purple-800 mb-6 text-center">
                    <i class="fas fa-trophy mr-3"></i> Hành Trình Giờ Tình Nguyện Của Bạn
                </h3>
                <div class="chart-container">
                    <canvas id="volunteerHoursChart"></canvas>
                </div>
            </div>

            <!-- Motivation -->
            <div class="text-center bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-16 rounded-3xl shadow-2xl mt-12">
                <p class="text-5xl font-bold italic">"Bạn chính là anh hùng thầm lặng của cộng đồng!"</p>
                <p class="text-2xl mt-6 opacity-90">— VolunteerConnect Team</p>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dữ liệu từ Controller
    const userTrend = @json($userTrend ?? []);
    const monthlyHours = @json($monthlyHours ?? []);
    const volunteerMonthly = @json($volunteerMonthly ?? []); // Bạn cần thêm ở Controller
    const orgMonthly = @json($orgMonthly ?? []); // Bạn cần thêm ở Controller

    // ADMIN CHARTS
    @if(auth()->user()->user_type === 'Admin')
        new Chart(document.getElementById('userTrendChart'), {
            type: 'line',
            data: {
                labels: userTrend.map(d => new Date(d.date).toLocaleDateString('vi-VN')),
                datasets: [{
                    label: 'Người dùng mới',
                    data: userTrend.map(d => d.count),
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 6
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('monthlyHoursChart'), {
            type: 'bar',
            data: {
                labels: monthlyHours.map(m => `${m.month}/${m.year}`),
                datasets: [{
                    label: 'Tổng giờ',
                    data: monthlyHours.map(m => m.total_hours),
                    backgroundColor: '#8b5cf6',
                    borderRadius: 8
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    @endif

    // ORGANIZATION CHART
    @if(auth()->user()->user_type === 'Organization')
        new Chart(document.getElementById('orgHoursChart'), {
            type: 'line',
            data: {
                labels: orgMonthly.map(m => `${m.month}/${m.year}`),
                datasets: [{
                    label: 'Giờ tình nguyện',
                    data: orgMonthly.map(m => m.total_hours),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 8
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    @endif

    // VOLUNTEER CHART
    @if(auth()->user()->user_type === 'Volunteer')
        new Chart(document.getElementById('volunteerHoursChart'), {
            type: 'line',
            data: {
                labels: volunteerMonthly.map(m => `${m.month}/${m.year}`),
                datasets: [{
                    label: 'Giờ của bạn',
                    data: volunteerMonthly.map(m => m.total_hours),
                    borderColor: '#ec4899',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 8,
                    pointBackgroundColor: '#ec4899'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ctx.raw + ' giờ' } }
                }
            }
        });
    @endif
</script>
@endpush
@endsection