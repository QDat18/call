@extends('layouts.volunteer')
@section('title', 'Hoạt Động Tình Nguyện')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                    Hoạt Động Tình Nguyện
                </h1>
                <p class="mt-2 text-gray-600">Theo dõi và quản lý lịch sử hoạt động của bạn</p>
            </div>
            <a href="{{ route('volunteer.activities.create') }}" 
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i> Log Giờ Mới
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            @forelse($activities as $activity)
                <div class="group p-6 border-b border-gray-100 hover:bg-gray-50 transition duration-150 ease-in-out last:border-b-0">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div class="flex items-start gap-5">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-transform duration-200">
                                {{-- Assuming category icon is a font awesome class or emoji --}}
                                @if(isset($activity->opportunity->category->icon))
                                    <i class="{{ $activity->opportunity->category->icon ?? 'fas fa-heart' }}"></i> 
                                @else
                                    <i class="fas fa-heart"></i>
                                @endif
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition-colors">
                                    <a href="{{ route('volunteer.activities.show', $activity->activity_id) }}">
                                        {{ $activity->opportunity->title }}
                                    </a>
                                </h3>
                                <p class="text-sm font-medium text-gray-600 flex items-center gap-1 mt-1">
                                    <i class="fas fa-building text-gray-400 text-xs"></i>
                                    {{ $activity->organization->organization_name }}
                                </p>
                                
                                <div class="flex flex-wrap items-center gap-4 mt-3 text-sm text-gray-500">
                                    <div class="flex items-center gap-1 bg-gray-100 px-2 py-1 rounded-md">
                                        <i class="far fa-calendar-alt text-gray-400"></i>
                                        <span>{{ $activity->activity_date->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 bg-purple-50 text-purple-700 px-2 py-1 rounded-md font-medium">
                                        <i class="far fa-clock"></i>
                                        <span>{{ $activity->hours_worked }} giờ</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-shrink-0">
                            @php
                                $statusClass = match($activity->status) {
                                    'Verified' => 'bg-green-100 text-green-700 border-green-200',
                                    'Pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    'Rejected', 'Disputed' => 'bg-red-100 text-red-700 border-red-200',
                                    default => 'bg-gray-100 text-gray-700 border-gray-200'
                                };
                                $statusIcon = match($activity->status) {
                                    'Verified' => 'fa-check-circle',
                                    'Pending' => 'fa-clock',
                                    'Rejected', 'Disputed' => 'fa-times-circle',
                                    default => 'fa-info-circle'
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                <i class="fas {{ $statusIcon }} mr-1.5"></i>
                                {{ $activity->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 px-4">
                    <div class="w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clipboard-list text-4xl text-purple-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Chưa có hoạt động nào</h3>
                    <p class="text-gray-500 max-w-sm mx-auto mb-8">Bạn chưa ghi nhận giờ tình nguyện nào. Hãy bắt đầu hành trình của mình ngay hôm nay!</p>
                    <a href="{{ route('volunteer.activities.create') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-purple-600 hover:bg-purple-700 shadow-lg hover:shadow-xl transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i> Bắt Đầu Log Giờ
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection