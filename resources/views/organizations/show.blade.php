@extends('layouts.app')

@section('title', $organization->organization_name . ' - Volunteer Connect')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 pb-12">
    
    {{-- 1. HERO BANNER SECTION --}}
    <div class="relative h-64 md:h-80 bg-gradient-to-r from-green-600 to-emerald-800 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        {{-- Breadcrumb (On Banner) --}}
        <div class="absolute top-6 left-0 w-full px-4 sm:px-6 lg:px-8 z-10">
            <nav class="flex text-green-100 text-sm font-medium" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Trang chủ</a></li>
                    <li><i class="fas fa-chevron-right text-xs mx-2 opacity-50"></i></li>
                    <li><a href="{{ route('organizations.index') }}" class="hover:text-white transition">Tổ chức</a></li>
                    <li><i class="fas fa-chevron-right text-xs mx-2 opacity-50"></i></li>
                    <li class="text-white truncate max-w-[150px] md:max-w-xs">{{ $organization->organization_name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-24">
        
        {{-- 2. PROFILE HEADER CARD --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 p-6 md:p-8 mb-8">
            <div class="flex flex-col md:flex-row items-start gap-6">
                
                {{-- Avatar --}}
                <div class="relative shrink-0 mx-auto md:mx-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl p-1.5 bg-white dark:bg-gray-700 shadow-md">
                        <img src="{{ $organization->avatar_url ? Storage::url($organization->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($organization->organization_name).'&background=10b981&color=fff&size=256' }}" 
                             alt="{{ $organization->organization_name }}"
                             class="w-full h-full rounded-xl object-cover bg-gray-50">
                    </div>
                    @if($organization->isVerified())
                        <div class="absolute -bottom-3 -right-3 bg-white dark:bg-gray-800 rounded-full p-1.5 shadow-sm" title="Tổ chức đã xác minh">
                            <i class="fas fa-check-circle text-blue-500 text-2xl"></i>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 text-center md:text-left w-full">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div>
                            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">
                                {{ $organization->organization_name }}
                            </h1>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-sm">
                                <span class="px-3 py-1 rounded-full bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 font-medium border border-green-100 dark:border-green-800">
                                    {{ $organization->organization_type }}
                                </span>
                                @if($organization->founded_year)
                                    <span class="text-gray-500 dark:text-gray-400 flex items-center">
                                        <i class="fas fa-birthday-cake mr-1.5"></i> Thành lập {{ $organization->founded_year }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex gap-3 justify-center md:justify-end">
                            <button onclick="shareOrganization()" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition flex items-center gap-2">
                                <i class="fas fa-share-alt"></i> <span class="hidden sm:inline">Chia sẻ</span>
                            </button>
                            </div>
                    </div>

                    {{-- Stats Row --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <div class="text-center px-4 border-r border-gray-100 dark:border-gray-700 last:border-0">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active_opportunities'] }}</div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Cơ hội đang mở</div>
                        </div>
                        <div class="text-center px-4 border-r border-gray-100 dark:border-gray-700 last:border-0">
                            <div class="text-2xl font-bold text-blue-600">{{ $stats['volunteer_count'] }}</div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tình nguyện viên</div>
                        </div>
                        <div class="text-center px-4 border-r border-gray-100 dark:border-gray-700 last:border-0">
                            <div class="text-2xl font-bold text-yellow-500 flex items-center justify-center gap-1">
                                {{ number_format($stats['rating'], 1) }} <i class="fas fa-star text-sm"></i>
                            </div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Đánh giá trung bình</div>
                        </div>
                        <div class="text-center px-4">
                            <div class="text-2xl font-bold text-purple-600">{{ $stats['total_opportunities'] }}</div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tổng dự án</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- 3. LEFT COLUMN: CONTENT --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- About Section --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2 border-b pb-4 dark:border-gray-700">
                        <i class="fas fa-info-circle text-green-600"></i>
                        Về chúng tôi
                    </h2>
                    
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Giới thiệu chung</h3>
                        <p class="whitespace-pre-line leading-relaxed mb-6">
                            {{ $organization->description ?? 'Tổ chức này chưa cập nhật phần giới thiệu.' }}
                        </p>

                        @if($organization->mission_statement)
                            <div class="bg-green-50 dark:bg-green-900/20 p-5 rounded-xl border-l-4 border-green-500">
                                <h3 class="text-lg font-bold text-green-800 dark:text-green-300 mt-0 mb-2">
                                    <i class="fas fa-bullseye mr-2"></i>Sứ mệnh hoạt động
                                </h3>
                                <p class="mb-0 text-green-900 dark:text-green-100 italic">
                                    "{{ $organization->mission_statement }}"
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Recent Opportunities List --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                    <div class="flex justify-between items-center mb-6 border-b pb-4 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fas fa-hand-holding-heart text-red-500"></i>
                            Cơ hội tình nguyện
                        </h2>
                        @if($recentOpportunities->count() > 0)
                            <a href="{{ route('opportunities.index', ['q' => $organization->organization_name]) }}" class="text-sm font-bold text-green-600 hover:text-green-700 hover:underline">
                                Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endif
                    </div>

                    <div class="space-y-4">
                        @forelse($recentOpportunities as $opportunity)
                            <div class="group relative bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-green-500 dark:hover:border-green-500 hover:shadow-md transition-all duration-300 p-5">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    {{-- Date Box --}}
                                    <div class="hidden sm:flex flex-col items-center justify-center w-16 h-16 bg-green-50 dark:bg-green-900/30 rounded-xl text-green-700 dark:text-green-300 shrink-0">
                                        <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($opportunity->created_at)->format('M') }}</span>
                                        <span class="text-xl font-extrabold">{{ \Carbon\Carbon::parse($opportunity->created_at)->format('d') }}</span>
                                    </div>

                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <span class="inline-block px-2 py-0.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-white rounded bg-{{ $opportunity->category->color ?? 'blue' }}-500" style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}">
                                                    {{ $opportunity->category->category_name ?? 'General' }}
                                                </span>
                                                <h3 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-green-600 transition-colors mb-1">
                                                    <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}">
                                                        {{ $opportunity->title }}
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mt-2">
                                            <span class="flex items-center"><i class="fas fa-map-marker-alt w-4 text-red-400"></i> {{ Str::limit($opportunity->location, 20) }}</span>
                                            <span class="flex items-center"><i class="fas fa-clock w-4 text-orange-400"></i> {{ $opportunity->time_commitment }}</span>
                                            <span class="flex items-center"><i class="fas fa-users w-4 text-blue-400"></i> {{ $opportunity->volunteers_registered }}/{{ $opportunity->volunteers_needed }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 sm:mt-0 sm:self-center">
                                        <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold text-sm rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                                            Chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-600">
                                <div class="w-16 h-16 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm">
                                    <i class="fas fa-folder-open text-gray-300 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">Hiện tại chưa có cơ hội nào đang mở.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- 4. RIGHT COLUMN: SIDEBAR --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Contact Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                        <i class="fas fa-address-book text-blue-500"></i>
                        Thông tin liên hệ
                    </h3>
                    
                    <ul class="space-y-4">
                        @if($organization->contact_person)
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center shrink-0">
                                <i class="fas fa-user text-blue-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold">Người liên hệ</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $organization->contact_person }}</p>
                            </div>
                        </li>
                        @endif

                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center shrink-0">
                                <i class="fas fa-envelope text-green-500 text-xs"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold">Email</p>
                                <a href="mailto:{{ $organization->email }}" class="text-sm font-medium text-green-600 hover:underline truncate block" title="{{ $organization->email }}">
                                    {{ $organization->email }}
                                </a>
                            </div>
                        </li>

                        @if($organization->phone)
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center shrink-0">
                                <i class="fas fa-phone text-purple-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold">Điện thoại</p>
                                <a href="tel:{{ $organization->phone }}" class="text-sm font-medium text-gray-800 dark:text-gray-200 hover:text-green-600 transition">
                                    {{ $organization->phone }}
                                </a>
                            </div>
                        </li>
                        @endif

                        @if($organization->website)
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center shrink-0">
                                <i class="fas fa-globe text-orange-500 text-xs"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold">Website</p>
                                <a href="{{ $organization->website }}" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-green-600 hover:underline truncate block">
                                    {{ parse_url($organization->website, PHP_URL_HOST) ?? $organization->website }} <i class="fas fa-external-link-alt text-[10px] ml-1"></i>
                                </a>
                            </div>
                        </li>
                        @endif
                    </ul>

                    @if($organization->registration_number)
                        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <p class="text-xs text-gray-400 text-center">
                                Mã số đăng ký: <span class="font-mono text-gray-600 dark:text-gray-300">{{ $organization->registration_number }}</span>
                            </p>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function shareOrganization() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $organization->organization_name }} - Volunteer Connect',
                text: 'Hãy xem qua tổ chức tình nguyện tuyệt vời này trên Volunteer Connect!',
                url: window.location.href,
            })
            .then(() => console.log('Successful share'))
            .catch((error) => console.log('Error sharing', error));
        } else {
            // Fallback copy to clipboard
            navigator.clipboard.writeText(window.location.href);
            alert('Đã sao chép liên kết hồ sơ tổ chức!');
        }
    }
</script>
@endpush