@extends('layouts.volunteer')

@section('title', 'Chi Tiết Đơn: ' . $application->opportunity->title)

@section('content')
<div class="min-h-screen bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ route('volunteer.dashboard') }}" class="text-gray-500 hover:text-purple-600 transition"><i class="fas fa-home"></i></a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li><a href="{{ route('volunteer.applications.my') }}" class="text-gray-500 hover:text-purple-600 font-medium transition">Đơn của tôi</a></li>
                <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
                <li class="text-purple-600 font-bold" aria-current="page">Chi tiết đơn</li>
            </ol>
        </nav>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="relative bg-gradient-to-r from-purple-600 to-indigo-700 p-8 sm:p-12 overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm mb-4 border border-white/10">
                            <i class="fas fa-building mr-2"></i> {{ $application->opportunity->organization->organization_name }}
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                            {{ $application->opportunity->title }}
                        </h1>
                        <p class="mt-2 text-purple-100 flex items-center gap-2 text-sm">
                            <i class="far fa-clock"></i> Ứng tuyển: {{ $application->applied_date->format('d/m/Y') }} 
                            <span class="w-1 h-1 bg-purple-300 rounded-full"></span>
                            {{ $application->applied_date->diffForHumans() }}
                        </p>
                    </div>
                    
                    <div class="flex flex-col items-end">
                        @php
                            $statusColors = [
                                'Pending' => 'bg-yellow-400 text-yellow-900',
                                'Under Review' => 'bg-blue-400 text-blue-900',
                                'Accepted' => 'bg-green-400 text-green-900',
                                'Rejected' => 'bg-red-400 text-red-900',
                                'Withdrawn' => 'bg-gray-400 text-gray-900'
                            ];
                            $statusIcons = [
                                'Pending' => 'fa-hourglass-half',
                                'Under Review' => 'fa-eye',
                                'Accepted' => 'fa-check-circle',
                                'Rejected' => 'fa-times-circle',
                                'Withdrawn' => 'fa-ban'
                            ];
                            $colorClass = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800';
                            $iconClass = $statusIcons[$application->status] ?? 'fa-circle';
                        @endphp
                        <span class="px-5 py-2 rounded-xl font-bold shadow-lg {{ $colorClass }} flex items-center gap-2 transform hover:scale-105 transition">
                            <i class="fas {{ $iconClass }}"></i> {{ $application->status }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3">
                <div class="lg:col-span-2 p-8 sm:p-10 border-r border-gray-100">
                    
                    <section class="mb-10">
                        <h2 class="flex items-center text-xl font-bold text-gray-800 mb-4 group">
                            <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mr-3 group-hover:bg-purple-600 group-hover:text-white transition">1</span>
                            Lý do ứng tuyển
                        </h2>
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 text-gray-700 leading-relaxed whitespace-pre-line hover:border-purple-200 transition">
                            {{ $application->motivation_letter }}
                        </div>
                    </section>

                    <section class="mb-10">
                        <h2 class="flex items-center text-xl font-bold text-gray-800 mb-4 group">
                            <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3 group-hover:bg-blue-600 group-hover:text-white transition">2</span>
                            Kinh nghiệm liên quan
                        </h2>
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 text-gray-700 leading-relaxed whitespace-pre-line hover:border-blue-200 transition">
                            {{ $application->relevant_experience ?? 'Không có thông tin' }}
                        </div>
                    </section>

                    <section>
                        <h2 class="flex items-center text-xl font-bold text-gray-800 mb-4 group">
                            <span class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center mr-3 group-hover:bg-green-600 group-hover:text-white transition">3</span>
                            Thời gian sẵn sàng
                        </h2>
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 text-gray-700 leading-relaxed whitespace-pre-line hover:border-green-200 transition">
                            {{ $application->availability_note ?? 'Linh hoạt' }}
                        </div>
                    </section>
                </div>

                <div class="lg:col-span-1 bg-gray-50/50 p-8 sm:p-10">
                    
                    @if($application->organization_notes)
                        <div class="mb-8 bg-yellow-50 border border-yellow-200 rounded-2xl p-5 shadow-sm">
                            <h3 class="text-sm font-bold text-yellow-800 uppercase tracking-wider mb-2">
                                <i class="fas fa-sticky-note mr-1"></i> Phản hồi từ tổ chức
                            </h3>
                            <p class="text-yellow-900 text-sm italic">"{{ $application->organization_notes }}"</p>
                        </div>
                    @endif

                    <h3 class="text-lg font-bold text-gray-800 mb-6">Tiến độ xử lý</h3>
                    <div class="relative border-l-2 border-purple-200 ml-3 space-y-8 pb-4">
                        <div class="relative pl-8">
                            <span class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-purple-600 border-2 border-white shadow"></span>
                            <h4 class="text-sm font-bold text-gray-900">Đã nộp đơn</h4>
                            <p class="text-xs text-gray-500">{{ $application->applied_date->format('H:i - d/m/Y') }}</p>
                        </div>

                        @if($application->reviewed_date)
                        <div class="relative pl-8">
                            <span class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-blue-500 border-2 border-white shadow"></span>
                            <h4 class="text-sm font-bold text-gray-900">Đã xem xét</h4>
                            <p class="text-xs text-gray-500">{{ $application->reviewed_date->format('H:i - d/m/Y') }}</p>
                        </div>
                        @endif

                        <div class="relative pl-8">
                            <span class="absolute -left-[9px] top-0 w-4 h-4 rounded-full {{ $application->status == 'Accepted' ? 'bg-green-500' : ($application->status == 'Rejected' ? 'bg-red-500' : 'bg-gray-300') }} border-2 border-white shadow animate-pulse"></span>
                            <h4 class="text-sm font-bold text-gray-900">Hiện tại: {{ $application->status }}</h4>
                            <p class="text-xs text-gray-500">
                                {{ $application->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        @if($application->status == 'Pending')
                            <form method="POST" action="{{ route('volunteer.applications.withdraw', $application->application_id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn rút đơn này không?');">
                                @csrf
                                <button type="submit" class="w-full mb-3 bg-white border-2 border-red-100 text-red-600 px-6 py-3 rounded-xl font-bold hover:bg-red-50 hover:border-red-200 transition shadow-sm flex items-center justify-center gap-2">
                                    <i class="fas fa-undo-alt"></i> Rút đơn ứng tuyển
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('volunteer.applications.my') }}" class="w-full bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-300 transition flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection