@extends('layouts.volunteer')
@section('title', 'Chi Tiết Hoạt Động')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <nav class="flex items-center justify-between mb-8">
            <a href="{{ route('volunteer.activities.index') }}" class="inline-flex items-center text-gray-500 hover:text-purple-600 font-medium transition-colors">
                <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-2 shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </div>
                Quay lại danh sách
            </a>
            
            <div class="text-sm text-gray-400 font-mono">ID: #{{ $activity->activity_id }}</div>
        </nav>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 p-8 sm:p-10 text-white relative overflow-hidden">
                <div class="absolute right-0 top-0 h-full w-1/3 bg-white/10 skew-x-12 transform translate-x-12"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row gap-6 items-start md:items-center">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-4xl shadow-inner border border-white/20">
                        <i class="{{ $activity->opportunity->category->icon ?? 'fas fa-heart' }}"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-2 opacity-90 text-sm font-medium uppercase tracking-wide">
                            <i class="fas fa-building"></i>
                            {{ $activity->organization->organization_name }}
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight mb-2">
                            {{ $activity->opportunity->title }}
                        </h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30 backdrop-blur-sm">
                             {{ $activity->opportunity->category->category_name ?? 'General' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-8 sm:p-10">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 bg-gray-50 rounded-2xl border border-gray-100 mb-10 gap-4">
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">Trạng thái</h3>
                        <div class="flex items-center">
                            @php
                                $statusColor = match($activity->status) {
                                    'Verified' => 'text-green-600',
                                    'Pending' => 'text-yellow-600',
                                    'Disputed' => 'text-red-600',
                                    default => 'text-gray-600'
                                };
                                $statusIcon = match($activity->status) {
                                    'Verified' => 'fa-check-circle',
                                    'Pending' => 'fa-hourglass-half',
                                    'Disputed' => 'fa-exclamation-circle',
                                    default => 'fa-circle'
                                };
                            @endphp
                            <i class="fas {{ $statusIcon }} {{ $statusColor }} text-xl mr-2"></i>
                            <span class="text-2xl font-bold {{ $statusColor }}">{{ $activity->status }}</span>
                        </div>
                    </div>
                    
                    @if($activity->status == 'Verified' && $activity->verified_date)
                    <div class="text-left sm:text-right">
                        <div class="text-gray-500 text-xs mb-1">Xác nhận ngày</div>
                        <div class="font-medium text-gray-800 flex items-center sm:justify-end">
                            <i class="far fa-calendar-check mr-2 text-gray-400"></i>
                            {{ $activity->verified_date->format('d/m/Y H:i') }}
                        </div>
                        @if($activity->verifier)
                        <div class="text-xs text-gray-500 mt-1">Bởi: {{ $activity->verifier->first_name }}</div>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="grid md:grid-cols-2 gap-10">
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-gray-900 font-bold text-lg mb-4 flex items-center">
                                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3 text-sm">
                                    <i class="far fa-calendar"></i>
                                </span>
                                Thời gian
                            </h3>
                            <div class="pl-11">
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Ngày thực hiện</p>
                                    <p class="text-xl text-gray-800 font-medium">{{ $activity->activity_date->format('l, d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Tổng thời gian</p>
                                    <p class="text-xl text-indigo-600 font-bold">{{ $activity->hours_worked }} giờ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                         <h3 class="text-gray-900 font-bold text-lg mb-4 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mr-3 text-sm">
                                <i class="far fa-file-alt"></i>
                            </span>
                            Nội dung công việc
                        </h3>
                        <div class="pl-11">
                            <div class="bg-white border-l-4 border-orange-200 p-4 rounded-r-lg shadow-sm">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $activity->activity_description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($activity->impact_notes)
                <div class="mt-10 pt-8 border-t border-gray-100">
                    <h3 class="text-gray-900 font-bold text-lg mb-4 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center mr-3 text-sm">
                            <i class="far fa-comment-dots"></i>
                        </span>
                        Ghi chú từ tổ chức
                    </h3>
                    <div class="pl-11">
                         <p class="text-gray-600 italic">"{{ $activity->impact_notes }}"</p>
                    </div>
                </div>
                @endif
            </div>

            <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400">Created {{ $activity->created_at ? $activity->created_at->diffForHumans() : 'N/A' }}</p>
                
                @if($activity->status == 'Pending')
                <form action="#" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy log này?')">
                    {{-- Assuming you might add a delete/cancel route later --}}
                    {{-- @csrf @method('DELETE') --}}
                    {{-- <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hủy yêu cầu</button> --}}
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection