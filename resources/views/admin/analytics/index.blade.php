@extends('layouts.admin')

@section('title', 'Thống kê & Báo cáo')
@section('breadcrumb', 'Analytics')

@section('content')
    <div class="space-y-8" x-data="analyticsDashboard()">

        <div
            class="relative bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl shadow-lg p-8 text-white overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Thống kê hệ thống</h2>

                    <p class="text-indigo-100 text-lg opacity-90">Theo dõi hiệu suất và tăng trưởng theo thời gian thực.</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.analytics.reports') }}"
                        class="bg-white text-indigo-600 px-5 py-2.5 rounded-xl font-bold shadow-lg hover:bg-indigo-50 transition flex items-center gap-2">
                        <i class="fas fa-file-export"></i>
                        <span class="hidden sm:inline">Xuất Báo Cáo</span>
                    </a>
                    <select x-model="period" @change="fetchData()"
                        class="bg-white/20 backdrop-blur-md text-white border border-white/30 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-white/50 focus:outline-none cursor-pointer option-black font-medium">
                        <option value="7days" class="text-gray-900">7 ngày qua</option>
                        <option value="30days" class="text-gray-900">30 ngày qua</option>
                        <option value="90days" class="text-gray-900">3 tháng qua</option>
                        <option value="year" class="text-gray-900">1 năm qua</option>
                    </select>

                    <button @click="fetchData()"
                        class="bg-white/20 backdrop-blur-md hover:bg-white/30 text-white p-2.5 rounded-xl transition border border-white/30"
                        title="Làm mới dữ liệu">
                        <i class="fas fa-sync-alt" :class="loading ? 'fa-spin' : ''"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <div class="z-10">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tổng thành viên</p>
                        <template x-if="loading">
                            <div class="h-8 w-24 bg-gray-200 dark:bg-gray-700 rounded animate-pulse mt-2"></div>
                        </template>
                        <template x-if="!loading">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1"
                                x-text="formatNumber(data.metrics.total_users)"></h3>
                        </template>

                        <div
                            class="mt-2 text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg w-fit flex items-center gap-1">
                            <i class="fas fa-arrow-up"></i>
                            <span x-text="data.metrics.new_users"></span> mới
                        </div>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-xl">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <div class="z-10">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Giờ tình nguyện</p>
                        <template x-if="loading">
                            <div class="h-8 w-24 bg-gray-200 dark:bg-gray-700 rounded animate-pulse mt-2"></div>
                        </template>
                        <template x-if="!loading">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1"
                                x-text="formatNumber(data.metrics.total_hours)"></h3>
                        </template>

                        <div
                            class="mt-2 text-xs font-medium text-purple-600 bg-purple-50 dark:bg-purple-900/20 px-2 py-1 rounded-lg w-fit flex items-center gap-1">
                            <i class="fas fa-clock mr-1"></i> Đã xác thực
                        </div>
                    </div>
                    <div class="p-3 bg-purple-50 dark:bg-purple-900/20 text-purple-600 rounded-xl">
                        <i class="fas fa-heart text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <div class="z-10">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tổ chức đối tác</p>
                        <template x-if="loading">
                            <div class="h-8 w-16 bg-gray-200 dark:bg-gray-700 rounded animate-pulse mt-2"></div>
                        </template>
                        <template x-if="!loading">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1"
                                x-text="formatNumber(data.metrics.total_orgs)"></h3>
                        </template>

                        <div
                            class="mt-2 text-xs font-medium text-orange-600 bg-orange-50 dark:bg-orange-900/20 px-2 py-1 rounded-lg w-fit">
                            Đã xác minh
                        </div>
                    </div>
                    <div class="p-3 bg-orange-50 dark:bg-orange-900/20 text-orange-600 rounded-xl">
                        <i class="fas fa-building text-xl"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <div class="z-10">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Đơn đăng ký</p>
                        <template x-if="loading">
                            <div class="h-8 w-20 bg-gray-200 dark:bg-gray-700 rounded animate-pulse mt-2"></div>
                        </template>
                        <template x-if="!loading">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1"
                                x-text="formatNumber(data.metrics.total_apps)"></h3>
                        </template>

                        <div
                            class="mt-2 text-xs font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-lg w-fit">
                            <span x-text="data.metrics.pending_apps"></span> chờ xử lý
                        </div>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-xl">
                        <i class="fas fa-file-contract text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Tăng trưởng người dùng</h3>

                <div class="relative w-full h-80">
                    <div x-show="loading"
                        class="absolute inset-0 flex items-center justify-center bg-white/80 dark:bg-gray-800/80 z-10">
                        <div class="w-10 h-10 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin">
                        </div>
                    </div>
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Trạng thái đơn</h3>

                <div class="relative w-full h-64 flex justify-center">
                    <div x-show="loading"
                        class="absolute inset-0 flex items-center justify-center bg-white/80 dark:bg-gray-800/80 z-10">
                        <div class="w-8 h-8 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
                    </div>
                    <canvas id="appStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Lĩnh vực hoạt động sôi nổi nhất</h3>

            <div class="relative w-full h-72">
                <div x-show="loading"
                    class="absolute inset-0 flex items-center justify-center bg-white/80 dark:bg-gray-800/80 z-10">
                    <div class="w-10 h-10 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
                </div>
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            function analyticsDashboard() {
                return {
                    period: '30days',
                    loading: true,
                    data: {
                        metrics: { total_users: 0, new_users: 0, total_hours: 0, total_orgs: 0, total_apps: 0, pending_apps: 0 },
                        charts: { user_growth: {}, app_status: {}, top_categories: {} }
                    },
                    charts: {}, // Store chart instances

                    init() {
                        this.fetchData();
                    },

                    formatNumber(num) {
                        return new Intl.NumberFormat('vi-VN').format(num);
                    },

                    async fetchData() {
                        this.loading = true;
                        try {
                            const response = await fetch(`{{ route('admin.analytics.data') }}?period=${this.period}`);
                            const result = await response.json();
                            this.data = result;
                            this.renderCharts(result.charts);
                        } catch (error) {
                            console.error("Error fetching analytics:", error);
                        } finally {
                            this.loading = false;
                        }
                    },

                    renderCharts(chartData) {
                        // 1. User Growth (Line)
                        this.createChart('userGrowthChart', 'line', {
                            labels: chartData.user_growth.labels,
                            datasets: [{
                                label: 'Thành viên mới',
                                data: chartData.user_growth.data,
                                borderColor: '#4f46e5',
                                backgroundColor: (ctx) => {
                                    const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                                    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
                                    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');
                                    return gradient;
                                },
                                fill: true,
                                tension: 0.4,
                                borderWidth: 2,
                                pointRadius: 3
                            }]
                        }, {
                            scales: { y: { beginAtZero: true, grid: { borderDash: [4, 4] } }, x: { grid: { display: false } } },
                            plugins: { legend: { display: false } }
                        });

                        // 2. App Status (Doughnut)
                        this.createChart('appStatusChart', 'doughnut', {
                            labels: chartData.app_status.labels,
                            datasets: [{
                                data: chartData.app_status.data,
                                backgroundColor: ['#FBBF24', '#10B981', '#EF4444', '#3B82F6'], // Amber, Emerald, Red, Blue
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        }, { cutout: '70%', plugins: { legend: { position: 'right' } } });

                        // 3. Top Categories (Bar)
                        this.createChart('categoriesChart', 'bar', {
                            labels: chartData.top_categories.labels,
                            datasets: [{
                                label: 'Số lượng cơ hội',
                                data: chartData.top_categories.data,
                                backgroundColor: '#8B5CF6', // Purple
                                borderRadius: 6,
                                barThickness: 30
                            }]
                        }, {
                            indexAxis: 'y', // Horizontal Bar
                            scales: { x: { beginAtZero: true } },
                            plugins: { legend: { display: false } }
                        });
                    },

                    createChart(id, type, data, options = {}) {
                        const ctx = document.getElementById(id);
                        if (!ctx) return;

                        // Destroy old chart if exists
                        if (this.charts[id]) {
                            this.charts[id].destroy();
                        }

                        this.charts[id] = new Chart(ctx, {
                            type: type,
                            data: data,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                ...options
                            }
                        });
                    }
                }
            }
        </script>
    @endpush
@endsection