@extends('layouts.app')

@section('title', 'Tìm Kiếm Cơ Hội - Volunteer Connect')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800">Khám Phá Cơ Hội</h1>
                <p class="text-gray-500 mt-1">Tìm kiếm các hoạt động tình nguyện phù hợp với bạn</p>
            </div>
            <a href="{{ route('opportunities.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center transition">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {{-- SIDEBAR FILTER --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <div class="mb-6 pb-4 border-b border-gray-100">
                        <h2 class="font-bold text-gray-800 text-lg">Tìm Kiếm</h2>
                    </div>

                    <form action="{{ route('search') }}" method="GET" id="searchForm">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Từ khóa</label>
                                <div class="relative">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                    <input type="text" name="q" value="{{ request('q') }}" placeholder="VD: Dạy học..." 
                                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Địa điểm</label>
                                <select name="location" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm bg-white">
                                    <option value="">Tất cả địa điểm</option>
                                    <option value="Hà Nội" {{ request('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                    <option value="Hồ Chí Minh" {{ request('location') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                    <option value="Đà Nẵng" {{ request('location') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                    <option value="Remote" {{ request('location') == 'Remote' ? 'selected' : '' }}>Làm từ xa</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Danh mục</label>
                                <select name="category" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm bg-white">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach($categories ?? [] as $cat)
                                        <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Thời gian</label>
                                <select name="time_commitment" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm bg-white">
                                    <option value="">Mọi thời gian</option>
                                    <option value="1-2 hours">1-2 giờ/tuần</option>
                                    <option value="3-5 hours">3-5 giờ/tuần</option>
                                    <option value="Flexible">Linh hoạt</option>
                                    <option value="Remote">Làm từ xa</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 mt-2">
                                <i class="fas fa-search mr-2"></i> Tìm Kiếm
                            </button>
                            
                            <a href="{{ route('search') }}" class="block text-center text-sm text-gray-500 hover:text-indigo-600 transition">
                                Đặt lại bộ lọc
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="lg:col-span-3">
                <div class="bg-indigo-50 rounded-2xl p-8 border border-indigo-100 text-center mb-8">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-indigo-600 text-2xl">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-indigo-900 mb-2">Bắt đầu hành trình tình nguyện</h2>
                    <p class="text-indigo-700 max-w-lg mx-auto">Sử dụng bộ lọc bên trái để tìm kiếm cơ hội phù hợp nhất với kỹ năng và thời gian của bạn.</p>
                </div>

                @if(isset($opportunities) && $opportunities->count() > 0)
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="font-bold text-gray-800">Cơ hội mới nhất</h3>
                        <a href="{{ route('search') }}?sort=latest" class="text-sm text-indigo-600 font-medium hover:underline">Xem tất cả</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($opportunities->take(4) as $opportunity)
                            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">
                                <div class="p-6 flex flex-col flex-grow">
                                    {{-- Badge --}}
                                    <div class="flex justify-between items-start mb-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm" style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}">
                                            {{ $opportunity->category->category_name ?? 'General' }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition">
                                        <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}">{{ $opportunity->title }}</a>
                                    </h3>
                                    
                                    <p class="text-sm text-gray-500 mb-4 flex items-center gap-2">
                                        <i class="fas fa-building text-gray-400"></i> {{ $opportunity->organization->organization_name }}
                                    </p>

                                    {{-- Skills Fix --}}
                                    @if($opportunity->required_skills)
                                        @php
                                            $rawSkills = $opportunity->required_skills;
                                            $skills = is_array($rawSkills) ? $rawSkills : explode(',', $rawSkills);
                                            $skills = array_filter($skills, function($v) { return !empty(trim($v)); });
                                        @endphp
                                        <div class="flex flex-wrap gap-1 mb-4 mt-auto">
                                            @foreach($skills as $skill)
                                                @if($loop->index < 2)
                                                <span class="px-2 py-1 bg-gray-50 text-gray-600 text-xs rounded border border-gray-100">{{ trim($skill) }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-2">
                                        <span><i class="fas fa-map-marker-alt text-indigo-500 mr-1"></i> {{ Str::limit($opportunity->location, 10) }}</span>
                                        <span><i class="fas fa-clock text-orange-500 mr-1"></i> {{ $opportunity->time_commitment }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection