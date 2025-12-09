{{-- resources/views/volunteer/analytics/index.blade.php --}}
@extends('layouts.volunteer')

@section('title', 'Thống kê hoạt động')

@section('content')
    <div class="h-48 bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 absolute top-0 left-0 w-full -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">
        
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20">
                <li><a href="{{ route('volunteer.dashboard') }}" class="text-purple-100 hover:text-white transition"><i class="fas fa-home"></i></a></li>
                <li><i class="fas fa-chevron-right text-purple-200 text-xs"></i></li>
                <li class="text-white font-bold" aria-current="page">Thống kê cá nhân</li>
            </ol>
        </nav>

        <div class="text-center mb-12 relative">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 drop-shadow-md">
                Hành Trình Tình Nguyện
            </h1>
            <p class="text-purple-100 text-lg font-medium">Nhìn lại những dấu ấn ý nghĩa bạn đã tạo ra</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-2xl p-6 shadow-xl border border-purple-50 flex items-center hover:-translate-y-1 transition duration-300">
                <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 text-3xl mr-5">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Tổng giờ làm</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $metrics['total_volunteer_hours'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-xl border border-green-50 flex items-center hover:-translate-y-1 transition duration-300">
                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-green-600 text-3xl mr-5">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Hoạt động xong</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $metrics['accepted_applications'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-xl border border-blue-50 flex items-center hover:-translate-y-1 transition duration-300">
                <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 text-3xl mr-5">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Đơn đã gửi</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $metrics['total_applications'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-chart-line text-purple-600"></i> Xu hướng tham gia
                    </h3>
                    <span class="text-xs font-semibold bg-purple-100 text-purple-700 px-3 py-1 rounded-full">12 tháng qua</span>
                </div>
                <div class="p-6">
                    <div class="relative h-80 w-full">
                        <canvas id="hoursChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-heart text-pink-500"></i> Lĩnh vực yêu thích
                    </h3>
                    <span class="text-xs font-semibold bg-pink-100 text-pink-700 px-3 py-1 rounded-full">Top quan tâm</span>
                </div>
                <div class="p-6 flex items-center justify-center">
                    <div class="relative h-80 w-full flex justify-center">
                        <canvas id="fieldChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 relative rounded-3xl overflow-hidden shadow-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
            <div class="relative p-10 md:p-14 text-center text-white">
                <i class="fas fa-quote-left text-4xl text-purple-300 mb-4 inline-block opacity-50"></i>
                <p class="text-2xl md:text-3xl font-bold italic leading-relaxed mb-4">
                    "Bạn không thay đổi thế giới trong một ngày, nhưng bạn thay đổi nó bằng mỗi giờ bạn cho đi."
                </p>
                <div class="flex items-center justify-center gap-2 opacity-90">
                    <span class="h-0.5 w-8 bg-white"></span>
                    <span class="text-sm font-semibold uppercase tracking-widest">VolunteerConnect</span>
                    <span class="h-0.5 w-8 bg-white"></span>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // === BIỂU ĐỒ LINE: GIỜ THEO THỜI GIAN ===
        const ctxHours = document.getElementById('hoursChart').getContext('2d');
        
        // Tạo gradient cho line chart
        const gradientHours = ctxHours.createLinearGradient(0, 0, 0, 400);
        gradientHours.addColorStop(0, 'rgba(139, 92, 246, 0.5)'); // Purple
        gradientHours.addColorStop(1, 'rgba(139, 92, 246, 0.0)');

        new Chart(ctxHours, {
            type: 'line',
            data: {
                labels: @json($monthlyHours->pluck('month_year')),
                datasets: [{
                    label: 'Giờ đóng góp',
                    data: @json($monthlyHours->pluck('total_hours')),
                    borderColor: '#8b5cf6',
                    backgroundColor: gradientHours,
                    tension: 0.4, // Đường cong mềm mại
                    fill: true,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#8b5cf6',
                    pointBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#1f2937',
                        bodyColor: '#8b5cf6',
                        bodyFont: { weight: 'bold' },
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#f3f4f6', borderDash: [5, 5] },
                        ticks: { font: { family: "'Inter', sans-serif" } }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { font: { family: "'Inter', sans-serif" } }
                    }
                }
            }
        });

        // === BIỂU ĐỒ DONUT: LĨNH VỰC YÊU THÍCH ===
        const fieldLabels = @json($fieldLabels);
        const fieldValues = @json($fieldValues);
        
        // Kiểm tra nếu không có dữ liệu thì hiển thị dummy
        const hasData = fieldValues.length > 0 && fieldValues.some(val => val > 0);
        
        const chartData = hasData ? {
            labels: fieldLabels,
            datasets: [{
                data: fieldValues,
                backgroundColor: [
                    '#8b5cf6', '#ec4899', '#f59e0b', '#10b981',
                    '#3b82f6', '#ef4444', '#a855f7', '#fb923c'
                ],
                borderColor: '#fff',
                borderWidth: 2,
                hoverOffset: 10
            }]
        } : {
            labels: ['Chưa có dữ liệu'],
            datasets: [{
                data: [1],
                backgroundColor: ['#e5e7eb'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        };

        new Chart(document.getElementById('fieldChart'), {
            type: 'doughnut',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', // Làm vòng tròn mỏng hơn
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { 
                            padding: 20, 
                            usePointStyle: true, 
                            pointStyle: 'circle',
                            font: { size: 12, family: "'Inter', sans-serif" } 
                        }
                    },
                    tooltip: {
                        enabled: hasData, // Tắt tooltip nếu không có data
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        bodyColor: '#1f2937',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        callbacks: {
                            label: ctx => {
                                const total = ctx.dataset.data.reduce((a,b) => a + b, 0);
                                const percent = Math.round((ctx.parsed / total) * 100);
                                return ` ${ctx.label}: ${ctx.parsed} (${percent}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush