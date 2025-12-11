@extends('layouts.admin')

@section('title', 'Chi tiết Đơn ứng tuyển')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-6">
    <nav class="flex text-sm font-medium text-gray-500 mb-6">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a></li>
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li><a href="{{ route('admin.applications.index') }}" class="hover:text-indigo-600 transition">Đơn ứng tuyển</a></li>
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li class="text-gray-900 truncate">#{{ $application->application_id }}</li>
        </ol>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-gray-900">Đơn #{{ $application->application_id }}</h1>
                @php
                    $statusStyles = [
                        'Pending' => ['bg-yellow-50', 'text-yellow-700', 'border-yellow-200'],
                        'Under Review' => ['bg-blue-50', 'text-blue-700', 'border-blue-200'],
                        'Accepted' => ['bg-green-50', 'text-green-700', 'border-green-200'],
                        'Rejected' => ['bg-red-50', 'text-red-700', 'border-red-200'],
                        'Withdrawn' => ['bg-gray-50', 'text-gray-700', 'border-gray-200'],
                    ];
                    $style = $statusStyles[$application->status] ?? ['bg-gray-50', 'text-gray-700', 'border-gray-200'];
                @endphp
                <span class="px-3 py-1 text-xs font-bold rounded-full border {{ implode(' ', $style) }}">
                    {{ $application->status }}
                </span>
            </div>
            <p class="text-gray-500 text-sm mt-1 flex items-center gap-2">
                <i class="far fa-clock"></i> Nộp ngày: {{ $application->applied_date->format('d/m/Y H:i') }}
                <span class="text-gray-300">|</span>
                <span class="text-gray-400">{{ $application->applied_date->diffForHumans() }}</span>
            </p>
        </div>
        
        <div class="flex gap-3">
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition shadow-sm font-medium text-sm flex items-center gap-2">
                <i class="fas fa-print"></i> In đơn
            </button>
            <a href="{{ route('admin.applications.index') }}" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl hover:bg-indigo-100 transition font-medium text-sm flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-indigo-500 rounded-full"></span>
                    Thông tin Cơ hội
                </h2>
                
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 border border-gray-200 bg-white">
                        @if($application->opportunity->organization->user && $application->opportunity->organization->user->avatar_url)
                            <img src="{{ Storage::url($application->opportunity->organization->user->avatar_url) }}" 
                                 alt="Org Avatar" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-indigo-100 text-indigo-500 font-bold text-2xl">
                                {{ substr($application->opportunity->organization->organization_name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-gray-900 truncate" title="{{ $application->opportunity->title }}">
                            {{ $application->opportunity->title }}
                        </h3>
                        <p class="text-sm text-gray-500 font-medium mb-2">
                            {{ $application->opportunity->organization->organization_name }}
                        </p>
                        
                        <div class="flex flex-wrap gap-2">
                            @if($application->opportunity->category)
                                <span class="px-2 py-1 bg-white border border-gray-200 text-gray-600 rounded-lg text-xs font-medium flex items-center gap-1">
                                    <i class="{{ $application->opportunity->category->icon ?? 'fas fa-tag' }} text-indigo-500"></i>
                                    {{ $application->opportunity->category->category_name }}
                                </span>
                            @endif
                            <span class="px-2 py-1 bg-white border border-gray-200 text-gray-600 rounded-lg text-xs font-medium flex items-center gap-1">
                                <i class="fas fa-map-marker-alt text-red-500"></i>
                                {{ $application->opportunity->location }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="p-3 bg-blue-50 rounded-xl border border-blue-100">
                        <p class="text-xs text-blue-600 font-bold uppercase mb-1">Ngày bắt đầu</p>
                        <p class="font-medium text-gray-900">{{ $application->opportunity->start_date ? $application->opportunity->start_date->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl border border-purple-100">
                        <p class="text-xs text-purple-600 font-bold uppercase mb-1">Cam kết thời gian</p>
                        <p class="font-medium text-gray-900">{{ $application->opportunity->time_commitment ?? 'Không yêu cầu' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-green-500 rounded-full"></span>
                    Thư nguyện vọng (Motivation Letter)
                </h2>
                <div class="prose prose-sm max-w-none text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-200 whitespace-pre-line">
                    {{ $application->motivation_letter }}
                </div>
            </div>

            @if($application->relevant_experience || $application->availability_note)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($application->relevant_experience)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-3 text-sm uppercase text-indigo-600">Kinh nghiệm liên quan</h3>
                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ $application->relevant_experience }}</p>
                </div>
                @endif

                @if($application->availability_note)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-3 text-sm uppercase text-orange-600">Khả năng tham gia</h3>
                    <p class="text-sm text-gray-600">{{ $application->availability_note }}</p>
                </div>
                @endif
            </div>
            @endif

            @if($application->organization_notes)
            <div class="bg-yellow-50 rounded-2xl shadow-sm border border-yellow-200 p-6">
                <h2 class="text-lg font-bold text-yellow-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-sticky-note"></i> Ghi chú từ Tổ chức
                </h2>
                <p class="text-yellow-700 text-sm italic">"{{ $application->organization_notes }}"</p>
            </div>
            @endif

        </div>

        <div class="space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                
                <div class="relative z-10 -mt-2">
                    <div class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow-md overflow-hidden bg-white">
                        @if($application->volunteer->avatar_url)
                            <img src="{{ Storage::url($application->volunteer->avatar_url) }}" 
                                 alt="Volunteer Avatar" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400 text-3xl font-bold">
                                {{ substr($application->volunteer->first_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mt-3">
                        {{ $application->volunteer->first_name }} {{ $application->volunteer->last_name }}
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $application->volunteer->email }}</p>
                    
                    <div class="grid grid-cols-2 gap-2 mb-4 text-left">
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <p class="text-xs text-gray-500">SĐT</p>
                            <p class="font-medium text-sm text-gray-900 truncate">{{ $application->volunteer->phone ?? 'N/A' }}</p>
                        </div>
                         <div class="bg-gray-50 p-2 rounded-lg">
                            <p class="text-xs text-gray-500">Thành phố</p>
                            <p class="font-medium text-sm text-gray-900 truncate">{{ $application->volunteer->city ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <a href="{{ route('admin.users.show', $application->volunteer->user_id) }}" 
                       class="block w-full py-2 bg-indigo-50 text-indigo-600 font-bold rounded-xl text-sm hover:bg-indigo-100 transition">
                        Xem hồ sơ chi tiết
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Thống kê & Lịch sử</h3>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-indigo-600">
                            {{ $application->volunteer->volunteerProfile->total_volunteer_hours ?? 0 }}
                        </div>
                        <div class="text-xs text-gray-500 font-medium uppercase">Giờ làm</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600 flex items-center justify-center gap-1">
                            {{ number_format($application->volunteer->volunteerProfile->volunteer_rating ?? 0, 1) }} <i class="fas fa-star text-xs"></i>
                        </div>
                        <div class="text-xs text-gray-500 font-medium uppercase">Đánh giá</div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                            <div class="w-0.5 h-full bg-blue-100 my-1"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase">Đã nộp</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->applied_date->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if($application->reviewed_date)
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                            <div class="w-0.5 h-full bg-purple-100 my-1"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase">Đã xem xét</p>
                            <p class="text-sm font-medium text-gray-900">{{ $application->reviewed_date->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase">Trạng thái hiện tại</p>
                            <p class="text-sm font-bold text-green-700">{{ $application->status }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection