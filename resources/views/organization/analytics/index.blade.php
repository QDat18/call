@extends('layouts.organization')

@section('title', 'Analytics & Insights')
@section('breadcrumb', 'Analytics')

@section('content')
<div class="space-y-6" x-data="analyticsData()">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Analytics & Insights</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Track your organization's performance and impact</p>
        </div>
        
        <div class="flex items-center gap-3">
            <select x-model="dateRange" @change="loadData()" 
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white">
                <option value="7">Last 7 days</option>
                <option value="30">Last 30 days</option>
                <option value="90">Last 3 months</option>
                <option value="365">Last year</option>
                <option value="all">All time</option>
            </select>
            <button @click="exportReport()" 
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center gap-2">
                <i class="fas fa-download"></i>
                <span>Export</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                </div>
                <span class="text-sm bg-white/20 px-3 py-1 rounded-full" x-text="(stats.opportunities_growth > 0 ? '+' : '') + stats.opportunities_growth + '%'"></span>
            </div>
            <h3 class="text-3xl font-bold mb-1" x-text="stats.total_opportunities">0</h3>
            <p class="text-blue-100 text-sm">Total Opportunities</p>
            <div class="mt-3 flex items-center gap-2 text-sm">
                <span x-text="stats.active_opportunities">0</span>
                <span class="text-blue-200">currently active</span>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-2xl"></i>
                </div>
                <span class="text-sm bg-white/20 px-3 py-1 rounded-full" x-text="(stats.applications_growth > 0 ? '+' : '') + stats.applications_growth + '%'"></span>
            </div>
            <h3 class="text-3xl font-bold mb-1" x-text="stats.total_applications">0</h3>
            <p class="text-green-100 text-sm">Total Applications</p>
            <div class="mt-3 flex items-center gap-2 text-sm">
                <span x-text="stats.pending_applications">0</span>
                <span class="text-green-200">pending review</span>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <span class="text-sm bg-white/20 px-3 py-1 rounded-full" x-text="(stats.volunteers_growth > 0 ? '+' : '') + stats.volunteers_growth + '%'"></span>
            </div>
            <h3 class="text-3xl font-bold mb-1" x-text="stats.active_volunteers">0</h3>
            <p class="text-purple-100 text-sm">Active Volunteers</p>
            <div class="mt-3 flex items-center gap-2 text-sm">
                <span x-text="stats.new_volunteers">0</span>
                <span class="text-purple-200">joined this month</span>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <span class="text-sm bg-white/20 px-3 py-1 rounded-full" x-text="(stats.hours_growth > 0 ? '+' : '') + stats.hours_growth + '%'"></span>
            </div>
            <h3 class="text-3xl font-bold mb-1" x-text="formatNumber(stats.total_hours)">0</h3>
            <p class="text-orange-100 text-sm">Volunteer Hours</p>
            <div class="mt-3 flex items-center gap-2 text-sm">
                <span x-text="stats.verified_hours">0</span>
                <span class="text-orange-200">verified hours</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Applications Over Time</h2>
                <div class="flex gap-2 bg-gray-100 dark:bg-gray-700 p-1 rounded-lg">
                    <button @click="chartType = 'line'; updateCharts()" 
                        :class="chartType === 'line' ? 'bg-white dark:bg-gray-600 text-green-600 shadow' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'" 
                        class="px-3 py-1 rounded text-sm transition-all">Line</button>
                    <button @click="chartType = 'bar'; updateCharts()" 
                        :class="chartType === 'bar' ? 'bg-white dark:bg-gray-600 text-green-600 shadow' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'" 
                        class="px-3 py-1 rounded text-sm transition-all">Bar</button>
                </div>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="applicationsChart"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Application Status</h2>
            <div class="flex items-center justify-center h-[200px]">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="text-center p-3 bg-yellow-50 dark:bg-yellow-900/10 rounded-lg">
                    <p class="text-2xl font-bold text-yellow-600" x-text="stats.pending_applications">0</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Pending</p>
                </div>
                <div class="text-center p-3 bg-green-50 dark:bg-green-900/10 rounded-lg">
                    <p class="text-2xl font-bold text-green-600" x-text="stats.accepted_applications">0</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Accepted</p>
                </div>
                <div class="text-center p-3 bg-red-50 dark:bg-red-900/10 rounded-lg">
                    <p class="text-2xl font-bold text-red-600" x-text="stats.rejected_applications">0</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Rejected</p>
                </div>
                <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-600 dark:text-gray-400" x-text="stats.withdrawn_applications">0</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Withdrawn</p>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm h-full">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Top Opportunities</h2>
            <div class="space-y-4 overflow-y-auto max-h-[300px] custom-scrollbar">
                <template x-if="topOpportunities.length === 0">
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">No data available</p>
                </template>
                <template x-for="(opp, index) in topOpportunities" :key="index">
                    <div class="flex items-center gap-4 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition">
                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600 dark:text-green-400 font-bold text-sm" x-text="index + 1"></div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 dark:text-white truncate" x-text="opp.title"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="opp.category"></p>
                        </div>
                        <div class="text-right whitespace-nowrap">
                            <p class="text-lg font-bold text-green-600" x-text="opp.applications"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">apps</p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Volunteer Engagement</h2>
            <div class="relative h-[300px] w-full">
                <canvas id="engagementChart"></canvas>
            </div>
        </div>

    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Performance Metrics</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="relative inline-flex items-center justify-center w-24 h-24 mb-3">
                    <svg class="transform -rotate-90 w-24 h-24">
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-200 dark:text-gray-600"/>
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" 
                            :stroke-dasharray="251.2" 
                            :stroke-dashoffset="251.2 - (251.2 * (stats.acceptance_rate || 0) / 100)"
                            class="text-green-600 transition-all duration-1000"/>
                    </svg>
                    <span class="absolute text-xl font-bold text-gray-900 dark:text-white" x-text="(stats.acceptance_rate || 0) + '%'"></span>
                </div>
                <p class="font-medium text-gray-900 dark:text-white">Acceptance Rate</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Applications accepted</p>
            </div>

            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="relative inline-flex items-center justify-center w-24 h-24 mb-3">
                    <svg class="transform -rotate-90 w-24 h-24">
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-200 dark:text-gray-600"/>
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" 
                            :stroke-dasharray="251.2" 
                            :stroke-dashoffset="251.2 - (251.2 * Math.min((stats.avg_response_time || 0), 10) / 10)"
                            class="text-blue-600 transition-all duration-1000"/>
                    </svg>
                    <span class="absolute text-xl font-bold text-gray-900 dark:text-white" x-text="(stats.avg_response_time || 0)"></span>
                </div>
                <p class="font-medium text-gray-900 dark:text-white">Avg Response Time</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Days to respond</p>
            </div>

            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="relative inline-flex items-center justify-center w-24 h-24 mb-3">
                    <svg class="transform -rotate-90 w-24 h-24">
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-200 dark:text-gray-600"/>
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" 
                            :stroke-dasharray="251.2" 
                            :stroke-dashoffset="251.2 - (251.2 * (stats.completion_rate || 0) / 100)"
                            class="text-purple-600 transition-all duration-1000"/>
                    </svg>
                    <span class="absolute text-xl font-bold text-gray-900 dark:text-white" x-text="(stats.completion_rate || 0) + '%'"></span>
                </div>
                <p class="font-medium text-gray-900 dark:text-white">Completion Rate</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Opportunities completed</p>
            </div>

            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="relative inline-flex items-center justify-center w-24 h-24 mb-3">
                    <svg class="transform -rotate-90 w-24 h-24">
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-200 dark:text-gray-600"/>
                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" 
                            :stroke-dasharray="251.2" 
                            :stroke-dashoffset="251.2 - (251.2 * (stats.retention_rate || 0) / 100)"
                            class="text-orange-600 transition-all duration-1000"/>
                    </svg>
                    <span class="absolute text-xl font-bold text-gray-900 dark:text-white" x-text="(stats.retention_rate || 0) + '%'"></span>
                </div>
                <p class="font-medium text-gray-900 dark:text-white">Retention Rate</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Returning volunteers</p>
            </div>

        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Performance by Category</h2>
        <div class="relative h-[300px] w-full">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Recent Activities</h2>
        <div class="space-y-4">
            <template x-if="recentActivities.length === 0">
                <p class="text-center text-gray-500 dark:text-gray-400">No recent activities</p>
            </template>
            <template x-for="(activity, index) in recentActivities" :key="index">
                <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" :class="activity.iconBg">
                        <i :class="activity.icon + ' ' + activity.iconColor"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-900 dark:text-white" x-text="activity.title"></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" x-text="activity.description"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-2" x-text="activity.time"></p>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>

@push('scripts')
<script>
function analyticsData() {
    return {
        dateRange: '30',
        chartType: 'line',
        // Khởi tạo giá trị mặc định để tránh lỗi undefined
        stats: {
            total_opportunities: 0, active_opportunities: 0, opportunities_growth: 0,
            total_applications: 0, pending_applications: 0, accepted_applications: 0,
            rejected_applications: 0, withdrawn_applications: 0, applications_growth: 0,
            active_volunteers: 0, new_volunteers: 0, volunteers_growth: 0,
            total_hours: 0, verified_hours: 0, hours_growth: 0,
            acceptance_rate: 0, avg_response_time: 0, completion_rate: 0, retention_rate: 0
        },
        topOpportunities: [],
        recentActivities: [],
        chartDataStorage: null, // Lưu trữ data để vẽ lại khi đổi loại biểu đồ
        charts: {
            applications: null,
            status: null,
            engagement: null,
            category: null
        },

        init() {
            this.loadData();
        },

        async loadData() {
            // SỬA 1: Dùng route helper thay vì hardcode URL
            // const url = "{{ route('organization.analytics.data') }}?range=" + this.dateRange;
            const url = "{{ route('organization.analytics.data') }}?range=" + this.dateRange;
            
            try {
                const response = await fetch(url);
                
                // Check response status
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                
                if (data.success) {
                    this.stats = data.stats;
                    this.topOpportunities = data.topOpportunities;
                    this.recentActivities = data.recentActivities;
                    this.chartDataStorage = data.chartData;
                    
                    this.$nextTick(() => {
                        this.initCharts(data.chartData);
                    });
                } else {
                    console.error('Server returned error:', data.message);
                    showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading analytics data:', error);
                // Hiển thị thông báo lỗi rõ ràng hơn
                showToast('Failed to load analytics data. Check console.', 'error');
            }
        },

        updateCharts() {
            if (this.chartDataStorage) {
                this.initCharts(this.chartDataStorage);
            }
        },

        initCharts(data) {
            // Destroy existing charts
            Object.values(this.charts).forEach(chart => {
                if (chart) chart.destroy();
            });

            // Applications Over Time Chart
            const ctx1 = document.getElementById('applicationsChart');
            if (ctx1 && data.applicationsOverTime) {
                this.charts.applications = new Chart(ctx1, {
                    type: this.chartType,
                    data: {
                        labels: data.applicationsOverTime.labels,
                        datasets: [{
                            label: 'Applications',
                            data: data.applicationsOverTime.data,
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: this.chartType === 'line' ? 'rgba(34, 197, 94, 0.1)' : 'rgba(34, 197, 94, 0.7)',
                            tension: 0.4,
                            fill: true,
                            borderWidth: this.chartType === 'line' ? 2 : 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                    }
                });
            }

            // Status Distribution Pie Chart
            const ctx2 = document.getElementById('statusChart');
            if (ctx2) {
                this.charts.status = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Accepted', 'Rejected', 'Withdrawn'],
                        datasets: [{
                            data: [
                                this.stats.pending_applications || 0,
                                this.stats.accepted_applications || 0,
                                this.stats.rejected_applications || 0,
                                this.stats.withdrawn_applications || 0
                            ],
                            backgroundColor: [
                                'rgb(234, 179, 8)',
                                'rgb(34, 197, 94)',
                                'rgb(239, 68, 68)',
                                'rgb(156, 163, 175)'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // Volunteer Engagement Chart
            const ctx3 = document.getElementById('engagementChart');
            if (ctx3 && data.engagement) {
                this.charts.engagement = new Chart(ctx3, {
                    type: 'line',
                    data: {
                        labels: data.engagement.labels,
                        datasets: [{
                            label: 'Active Volunteers',
                            data: data.engagement.data,
                            borderColor: 'rgb(168, 85, 247)',
                            backgroundColor: 'rgba(168, 85, 247, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                    }
                });
            }

            // Category Performance Chart
            const ctx4 = document.getElementById('categoryChart');
            if (ctx4 && data.categoryPerformance) {
                this.charts.category = new Chart(ctx4, {
                    type: 'bar',
                    data: {
                        labels: data.categoryPerformance.labels,
                        datasets: [{
                            label: 'Opportunities',
                            data: data.categoryPerformance.opportunities,
                            backgroundColor: 'rgba(34, 197, 94, 0.7)'
                        }, {
                            label: 'Applications',
                            data: data.categoryPerformance.applications,
                            backgroundColor: 'rgba(59, 130, 246, 0.7)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'top' } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        },

        formatNumber(num) {
            return new Intl.NumberFormat().format(num || 0);
        },

        exportReport() {
            // SỬA 2: Dùng route helper cho export
            window.location.href = "{{ route('organization.analytics.export') }}?range=" + this.dateRange;
        }
    }
}
</script>
@endpush
@endsection 