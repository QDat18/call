@extends('layouts.app')
@section('title', 'Chi Tiết Hoạt Động')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl border border-purple-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-8">
                <div class="flex items-center gap-6">
                    <div class="text-6xl">{{ $activity->opportunity->category->icon ?? 'Heart' }}</div>
                    <div>
                        <h1 class="text-3xl font-bold">{{ $activity->opportunity->title }}</h1>
                        <p class="text-xl opacity-90 mt-2">{{ $activity->organization->organization_name }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <i class="fas fa-calendar-alt text-2xl text-purple-600"></i>
                            <div>
                                <div class="font-semibold text-purple-800">Ngày hoạt động</div>
                                <div class="text-xl">{{ $activity->activity_date->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <i class="fas fa-clock text-2xl text-purple-600"></i>
                            <div>
                                <div class="font-semibold text-purple-800">Số giờ</div>
                                <div class="text-xl font-bold text-purple-700">{{ $activity->hours_worked }} giờ</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="font-bold text-xl text-purple-800 mb-4">Mô tả chi tiết</h3>
                    <p class="text-gray-700 leading-relaxed text-lg bg-purple-50 p-6 rounded-2xl">
                        {{ $activity->activity_description }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-bold text-xl text-purple-800 mb-4">Trạng thái xác nhận</h3>
                    <div class="flex items-center gap-4">
                        <span class="px-6 py-3 rounded-full text-lg font-bold 
                            {{ $activity->status == 'Verified' ? 'bg-green-100 text-green-800' : 
                               ($activity->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $activity->status }}
                        </span>
                        @if($activity->verifier)
                            <div class="text-sm text-gray-600">
                                Đã xác nhận bởi: <span class="font-semibold">{{ $activity->verifier->first_name }}</span>
                                <br>
                                Ngày: {{ $activity->verified_at?->format('d/m/Y H:i') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-8 border-t border-purple-100 flex justify-center gap-6">
                <a href="{{ route('volunteer.activities.index') }}" 
                   class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:shadow-2xl transition">
                    Quay Lại Danh Sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection