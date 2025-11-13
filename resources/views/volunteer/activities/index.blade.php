@extends('layouts.app')
@section('title', 'Hoạt Động Tình Nguyện')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-purple-800">
                Hoạt Động Tình Nguyện
            </h1>
            <a href="{{ route('volunteer.activities.create') }}" 
               class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:shadow-2xl transition transform hover:scale-105">
                Log Giờ Mới
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl border border-purple-100 overflow-hidden">
            @forelse($activities as $activity)
                <div class="p-6 border-b border-purple-100 hover:bg-purple-50 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <div class="text-4xl">
                                {{ $activity->opportunity->category->icon ?? 'Heart' }}
                            </div>
                            <div>
                                <a href="{{ route('volunteer.activities.show', $activity->activity_id) }}" 
                                   class="text-xl font-bold text-purple-800 hover:text-purple-600">
                                    {{ $activity->opportunity->title }}
                                </a>
                                <p class="text-gray-600">
                                    {{ $activity->organization->organization_name }}
                                </p>
                                <div class="flex items-center gap-4 text-sm text-gray-500 mt-2">
                                    <span>{{ $activity->activity_date->format('d/m/Y') }}</span>
                                    <span>•</span>
                                    <span class="font-semibold text-purple-700">{{ $activity->hours_worked }} giờ</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-4 py-2 rounded-full text-sm font-bold 
                                {{ $activity->status == 'Verified' ? 'bg-green-100 text-green-800' : 
                                   ($activity->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $activity->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <i class="fas fa-calendar-times text-8xl text-purple-300 mb-6"></i>
                    <p class="text-2xl text-gray-600">Chưa có hoạt động nào</p>
                    <a href="{{ route('volunteer.activities.create') }}" 
                       class="mt-6 inline-block bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:shadow-2xl transition">
                        Bắt Đầu Log Giờ
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