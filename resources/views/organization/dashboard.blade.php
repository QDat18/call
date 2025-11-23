@extends('layouts.organization')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    Welcome back, {{ $organization->organization_name }}! 
                    @if($organization->verification_status === 'Verified')
                        <i class="fas fa-check-circle text-blue-300"></i>
                    @endif
                </h1>
                <p class="text-green-100">Here's what's happening with your volunteer activities today</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chart-line text-6xl text-white opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Active Opportunities -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Active Opportunities</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['active_opportunities'] }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        Total: {{ $stats['total_opportunities'] }}
                    </p>
                </div>
                <div class="w-14 h-14 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-2xl text-green-600 dark:text-green-400"></i>
                </div>
            </div>
            <a href="{{ route('organization.opportunities.index') }}" 
               class="text-sm text-green-600 dark:text-green-400 hover:underline mt-4 inline-block">
                View all →
            </a>
        </div>

        <!-- Pending Applications -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Pending Applications</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['pending_applications'] }}</h3>
                    @if($stats['pending_applications'] > 0)
                        <p class="text-xs text-orange-500 mt-2">
                            <i class="fas fa-exclamation-circle"></i> Needs attention
                        </p>
                    @else
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">All caught up!</p>
                    @endif
                </div>
                <div class="w-14 h-14 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
            </div>
            <a href="{{ route('organization.applications.index') }}" 
               class="text-sm text-orange-600 dark:text-orange-400 hover:underline mt-4 inline-block">
                Review now →
            </a>
        </div>

        <!-- Active Volunteers -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Volunteers</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['volunteer_count'] }}</h3>
                    <p class="text-xs text-green-500 mt-2">
                        <i class="fas fa-arrow-up"></i> Growing
                    </p>
                </div>
                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <a href="{{ route('organization.volunteers.index') }}" 
               class="text-sm text-blue-600 dark:text-blue-400 hover:underline mt-4 inline-block">
                View all →
            </a>
        </div>

        <!-- Rating -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Organization Rating</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white">
                        {{ number_format($stats['rating'], 1) }}
                        <span class="text-yellow-500">⭐</span>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Based on reviews</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-2xl text-yellow-600 dark:text-yellow-400"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Opportunities -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow">
                <div class="p-6 border-b dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-clipboard-list text-green-600 mr-3"></i>
                            Recent Opportunities
                        </h2>
                        <a href="{{ route('organization.opportunities.create') }}" 
                           class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition">
                            <i class="fas fa-plus mr-2"></i>Create New
                        </a>
                    </div>
                </div>

                <div class="divide-y dark:divide-gray-700">
                    @forelse($recentOpportunities as $opportunity)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="font-semibold text-gray-800 dark:text-white">
                                            {{ $opportunity->title }}
                                        </h3>
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($opportunity->status === 'Active')
                                                bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300
                                            @elseif($opportunity->status === 'Paused')
                                                bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300
                                            @else
                                                bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                            @endif">
                                            {{ $opportunity->status }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                        <span>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $opportunity->start_date ? \Carbon\Carbon::parse($opportunity->start_date)->format('M d, Y') : 'Not set' }}
                                        </span>
                                        <span>
                                            <i class="fas fa-users mr-1"></i>
                                            {{ $opportunity->volunteers_registered ?? 0 }}/{{ $opportunity->volunteers_needed }}
                                        </span>
                                        <span>
                                            <i class="fas fa-file-alt mr-1"></i>
                                            {{ $opportunity->applications_count }} applications
                                        </span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('organization.opportunities.show', $opportunity->opportunity_id) }}" 
                                   class="ml-4 text-green-600 dark:text-green-400 hover:text-green-700">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <i class="fas fa-clipboard-list text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">No opportunities yet</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Create your first opportunity to start connecting with volunteers</p>
                            <a href="{{ route('organization.opportunities.create') }}" 
                               class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                <i class="fas fa-plus mr-2"></i>Create Opportunity
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">

            <!-- Pending Applications List -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow">
                <div class="p-6 border-b dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
                        <i class="fas fa-bell text-orange-600 mr-2"></i>
                        Pending Reviews
                    </h3>
                </div>

                <div class="divide-y dark:divide-gray-700 max-h-96 overflow-y-auto">
                    @forelse($pendingApplications->take(5) as $application)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $application->volunteer->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($application->volunteer->first_name.' '.$application->volunteer->last_name).'&background=059669&color=fff' }}" 
                                     alt="Avatar" 
                                     class="w-10 h-10 rounded-full">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                                        {{ $application->volunteer->first_name }} {{ $application->volunteer->last_name }}
                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 truncate">
                                        {{ $application->opportunity->title }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        {{ $application->applied_date->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 mt-3">
                                <a href="{{ route('organization.applications.show', $application->application_id) }}" 
                                   class="flex-1 text-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition">
                                    Review
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <i class="fas fa-check-circle text-4xl text-green-300 dark:text-green-700 mb-2"></i>
                            <p class="text-sm text-gray-600 dark:text-gray-400">No pending applications</p>
                        </div>
                    @endforelse
                </div>

                @if($pendingApplications->count() > 5)
                    <div class="p-4 border-t dark:border-gray-700">
                        <a href="{{ route('organization.applications.index') }}" 
                           class="text-sm text-green-600 dark:text-green-400 hover:underline">
                            View all {{ $pendingApplications->count() }} applications →
                        </a>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-600 mr-2"></i>
                    Quick Actions
                </h3>

                <div class="space-y-2">
                    <a href="{{ route('organization.opportunities.create') }}" 
                       class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fas fa-plus text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">Create Opportunity</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Post new volunteer position</p>
                        </div>
                    </a>

                    <a href="{{ route('organization.volunteers.index') }}" 
                       class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">Manage Volunteers</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">View volunteer list</p>
                        </div>
                    </a>

                    <a href="{{ route('organization.analytics.index') }}" 
                       class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fas fa-chart-bar text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">View Analytics</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Track performance</p>
                        </div>
                    </a>

                    <a href="{{ route('conversations.index') }}" 
                       class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fas fa-comments text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">Messages</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Chat with volunteers</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Verification Status -->
            @if($organization->verification_status !== 'Verified')
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl shadow p-6 border border-blue-200 dark:border-blue-800">
                <div class="text-center">
                    <i class="fas fa-shield-alt text-4xl text-blue-600 dark:text-blue-400 mb-3"></i>
                    <h3 class="font-bold text-gray-800 dark:text-white mb-2">Get Verified</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                        Earn trust badge and increase applications by 3x
                    </p>
                    <a href="{{ route('organization.verification.request') }}" 
                       class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm">
                        <i class="fas fa-check-circle"></i>
                        <span>Apply Now</span>
                    </a>
                </div>
            </div>
            @endif

        </div>

    </div>

    <!-- Activity Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                <i class="fas fa-chart-line text-green-600 mr-3"></i>
                Activity Overview
            </h2>
            <select class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white">
                <option>Last 7 days</option>
                <option>Last 30 days</option>
                <option>Last 3 months</option>
            </select>
        </div>

        <canvas id="activityChart" height="80"></canvas>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get data from controller
    const chartData = @json($chartData);

    const ctx = document.getElementById('activityChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'New Applications',
                        data: chartData.applications,
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 3
                    },
                    {
                        label: 'New Activities',
                        data: chartData.activities,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: { family: "'Inter', sans-serif", size: 11 }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection