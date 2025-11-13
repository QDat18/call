@extends('layouts.app')

@section('title', $organization->organization_name)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Organization Header -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-6">
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                <img src="{{ $organization->avatar_url ? Storage::url($organization->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($organization->organization_name).'&background=059669&color=fff' }}" 
                     alt="{{ $organization->organization_name }}"
                     class="w-32 h-32 rounded-xl object-cover">
                
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                            {{ $organization->organization_name }}
                        </h1>
                        @if($organization->isVerified())
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm flex items-center">
                                <i class="fas fa-check-circle mr-1"></i> Đã xác thực
                            </span>
                        @endif
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $organization->organization_type }}</p>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <div class="text-2xl font-bold text-green-600">{{ $stats['active_opportunities'] }}</div>
                            <div class="text-sm text-gray-500">Cơ hội đang mở</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-blue-600">{{ $stats['volunteer_count'] }}</div>
                            <div class="text-sm text-gray-500">Tình nguyện viên</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-yellow-600">{{ number_format($stats['rating'], 1) }} ⭐</div>
                            <div class="text-sm text-gray-500">Đánh giá</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-purple-600">{{ $stats['total_opportunities'] }}</div>
                            <div class="text-sm text-gray-500">Tổng cơ hội</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- About -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-info-circle text-green-600 mr-2"></i>
                        Giới thiệu
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">
                        {{ $organization->description ?? 'Chưa có mô tả' }}
                    </p>
                </div>

                @if($organization->mission_statement)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-bullseye text-green-600 mr-2"></i>
                        Sứ mệnh
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">
                        {{ $organization->mission_statement }}
                    </p>
                </div>
                @endif

                <!-- Recent Opportunities -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-clipboard-list text-green-600 mr-2"></i>
                        Cơ hội gần đây
                    </h2>
                    
                    <div class="space-y-4">
                        @forelse($recentOpportunities as $opportunity)
                            <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                               class="block p-4 border dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800 dark:text-white mb-2">{{ $opportunity->title }}</h3>
                                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                            <span class="flex items-center">
                                                <i class="fas fa-tag mr-1 text-green-600"></i>
                                                {{ $opportunity->category->category_name ?? 'N/A' }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fas fa-map-marker-alt mr-1 text-red-600"></i>
                                                {{ $opportunity->location }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fas fa-users mr-1 text-blue-600"></i>
                                                {{ $opportunity->volunteers_registered }}/{{ $opportunity->volunteers_needed }}
                                            </span>
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 mt-2"></i>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-clipboard text-gray-300 text-4xl mb-2"></i>
                                <p class="text-gray-500">Chưa có cơ hội nào</p>
                            </div>
                        @endforelse
                    </div>

                    @if($recentOpportunities->count() > 0)
                        <a href="{{ route('opportunities.index', ['org_id' => $organization->org_id]) }}" 
                           class="block text-center mt-4 text-green-600 hover:underline">
                            Xem tất cả cơ hội →
                        </a>
                    @endif
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Contact Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-address-card text-green-600 mr-2"></i>
                        Thông tin liên hệ
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        @if($organization->contact_person)
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-user text-gray-400 mt-1"></i>
                            <div>
                                <div class="text-gray-500">Người liên hệ</div>
                                <div class="text-gray-800 dark:text-white font-medium">{{ $organization->contact_person }}</div>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start space-x-3">
                            <i class="fas fa-envelope text-gray-400 mt-1"></i>
                            <div>
                                <div class="text-gray-500">Email</div>
                                <a href="mailto:{{ $organization->email }}" 
                                   class="text-green-600 hover:underline break-all">
                                    {{ $organization->email }}
                                </a>
                            </div>
                        </div>

                        @if($organization->phone)
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-phone text-gray-400 mt-1"></i>
                            <div>
                                <div class="text-gray-500">Điện thoại</div>
                                <a href="tel:{{ $organization->phone }}" 
                                   class="text-green-600 hover:underline">
                                    {{ $organization->phone }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($organization->website)
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-globe text-gray-400 mt-1"></i>
                            <div>
                                <div class="text-gray-500">Website</div>
                                <a href="{{ $organization->website }}" 
                                   target="_blank"
                                   class="text-green-600 hover:underline break-all">
                                    {{ str_replace(['http://', 'https://'], '', $organization->website) }}
                                    <i class="fas fa-external-link-alt text-xs ml-1"></i>
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($organization->founded_year)
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-calendar-alt text-gray-400 mt-1"></i>
                            <div>
                                <div class="text-gray-500">Thành lập</div>
                                <div class="text-gray-800 dark:text-white font-medium">{{ $organization->founded_year }}</div>
                            </div>
                        </div>
                        @endif

                        @if($organization->registration_number)
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-id-card text-gray-400 mt-1"></i>
                            <div>
                                <div class="text-gray-500">Mã đăng ký</div>
                                <div class="text-gray-800 dark:text-white font-medium">{{ $organization->registration_number }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Back Button -->
                <a href="{{ route('organizations.index') }}" 
                   class="block w-full px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-center hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại danh sách
                </a>

            </div>

        </div>

    </div>
</div>
@endsection