@extends('layouts.app')

@section('title', 'Kết Quả Tìm Kiếm - Volunteer Connect')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header & Sort --}}
        <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-search text-indigo-600"></i> Kết Quả Tìm Kiếm
                </h1>
                <p class="text-gray-500 mt-2">
                    @if($opportunities->total() > 0)
                        Tìm thấy <strong class="text-indigo-600">{{ $opportunities->total() }}</strong> kết quả
                        @if(request('q')) cho "<strong>{{ request('q') }}</strong>" @endif
                    @else
                        Không tìm thấy kết quả nào
                    @endif
                </p>
            </div>
            
            {{-- Sorting --}}
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 font-medium">Sắp xếp:</span>
                <form id="sortForm" action="{{ route('search') }}" method="GET">
                    {{-- Giữ lại các filter hiện có khi sort --}}
                    @foreach(request()->except(['sort', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" 
                            class="px-4 py-2 pr-8 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white shadow-sm">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Phổ biến nhất</option>
                        <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Hạn nộp đơn</option>
                        <option value="nearest" {{ request('sort') == 'nearest' ? 'selected' : '' }}>Bắt đầu sớm</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            {{-- SIDEBAR FILTERS --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-100">
                        <i class="fas fa-filter text-indigo-600"></i>
                        <h2 class="font-bold text-gray-800">Bộ Lọc</h2>
                    </div>

                    <form action="{{ route('search') }}" method="GET" id="resultsFilterForm">
                        <input type="hidden" name="q" value="{{ request('q') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        
                        {{-- Category --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Danh Mục</label>
                            <select name="category" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories ?? [] as $category)
                                <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Location --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Địa Điểm</label>
                            <select name="location" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="">Tất cả địa điểm</option>
                                <option value="Hà Nội" {{ request('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                <option value="Hồ Chí Minh" {{ request('location') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                <option value="Đà Nẵng" {{ request('location') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                <option value="Remote" {{ request('location') == 'Remote' ? 'selected' : '' }}>Làm từ xa</option>
                            </select>
                        </div>

                        {{-- Experience --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kinh Nghiệm</label>
                            <select name="experience_needed" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="">Tất cả cấp độ</option>
                                <option value="No experience" {{ request('experience_needed') == 'No experience' ? 'selected' : '' }}>Không yêu cầu</option>
                                <option value="Some experience" {{ request('experience_needed') == 'Some experience' ? 'selected' : '' }}>Có chút kinh nghiệm</option>
                                <option value="Experienced" {{ request('experience_needed') == 'Experienced' ? 'selected' : '' }}>Có kinh nghiệm</option>
                            </select>
                        </div>

                        {{-- Time --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Thời Gian</label>
                            <select name="time_commitment" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="">Tất cả thời gian</option>
                                <option value="1-2 hours" {{ request('time_commitment') == '1-2 hours' ? 'selected' : '' }}>1-2 giờ/tuần</option>
                                <option value="3-5 hours" {{ request('time_commitment') == '3-5 hours' ? 'selected' : '' }}>3-5 giờ/tuần</option>
                                <option value="Flexible" {{ request('time_commitment') == 'Flexible' ? 'selected' : '' }}>Linh hoạt</option>
                                <option value="Remote" {{ request('time_commitment') == 'Remote' ? 'selected' : '' }}>Làm từ xa</option>
                            </select>
                        </div>

                        {{-- Actions --}}
                        <div class="grid gap-3">
                            <a href="{{ route('search.advanced') }}" class="block w-full py-2 bg-indigo-50 text-indigo-600 font-bold text-center rounded-lg hover:bg-indigo-600 hover:text-white transition text-sm">
                                <i class="fas fa-sliders-h mr-1"></i> Bộ Lọc Nâng Cao
                            </a>
                            <a href="{{ route('search') }}?q={{ request('q') }}" class="block w-full py-2 text-gray-500 font-medium text-center hover:text-gray-800 transition text-sm">
                                <i class="fas fa-redo mr-1"></i> Đặt Lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- RESULTS GRID --}}
            <div class="lg:col-span-3">
                @if($opportunities->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($opportunities as $opportunity)
                        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">
                            <div class="p-6 flex flex-col flex-grow">
                                {{-- Top Badge --}}
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold text-white flex items-center gap-1 shadow-sm"
                                          style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}">
                                        <i class="{{ $opportunity->category->icon ?? 'fas fa-heart' }} mr-1"></i>
                                        {{ $opportunity->category->category_name ?? 'General' }}
                                    </span>
                                    <span class="text-xs text-gray-400 flex items-center bg-gray-50 px-2 py-1 rounded-full">
                                        <i class="fas fa-eye mr-1"></i> {{ $opportunity->view_count ?? 0 }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition">
                                    <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}">
                                        {{ Str::limit($opportunity->title, 60) }}
                                    </a>
                                </h3>
                                
                                {{-- Organization --}}
                                <p class="text-sm text-gray-500 mb-3 flex items-center gap-2">
                                    <i class="fas fa-building text-gray-400"></i> 
                                    {{ Str::limit($opportunity->organization->organization_name, 25) }}
                                </p>

                                {{-- Description --}}
                                <p class="text-sm text-gray-500 mb-4 line-clamp-3 flex-grow">
                                    {{ Str::limit(strip_tags($opportunity->description), 100) }}
                                </p>

                                {{-- Skills (SỬA LỖI Ở ĐÂY) --}}
                                @if($opportunity->required_skills)
                                    @php
                                        // Kiểm tra an toàn: nếu là chuỗi thì explode, nếu là mảng thì giữ nguyên
                                        $rawSkills = $opportunity->required_skills;
                                        $skills = is_array($rawSkills) ? $rawSkills : explode(',', $rawSkills);
                                        $skills = array_filter($skills, function($v) { return !empty(trim($v)); });
                                    @endphp

                                    <div class="flex flex-wrap gap-1 mb-4">
                                        @foreach($skills as $skill)
                                            @if($loop->index < 2)
                                            <span class="px-2 py-1 bg-green-50 text-green-700 text-xs rounded border border-green-100">
                                                <i class="fas fa-check mr-1"></i>{{ trim($skill) }}
                                            </span>
                                            @endif
                                        @endforeach
                                        @if(count($skills) > 2)
                                            <span class="px-2 py-1 bg-gray-50 text-gray-500 text-xs rounded border border-gray-100">
                                                +{{ count($skills) - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                {{-- Footer --}}
                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                                    <div class="flex flex-col text-xs text-gray-500 gap-1">
                                        <span class="flex items-center"><i class="fas fa-map-marker-alt w-4 text-indigo-500"></i> {{ Str::limit($opportunity->location, 12) }}</span>
                                        <span class="flex items-center"><i class="fas fa-clock w-4 text-orange-500"></i> {{ $opportunity->time_commitment }}</span>
                                    </div>
                                    <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                                       class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition shadow-md shadow-indigo-200">
                                        Chi Tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    {{-- Pagination --}}
                    @if($opportunities->hasPages())
                    <div class="mt-8 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                        {{ $opportunities->appends(request()->query())->links() }}
                    </div>
                    @endif

                @else
                    {{-- No Results State --}}
                    <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-gray-200">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-search text-gray-300 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Không tìm thấy kết quả phù hợp</h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">Hãy thử thay đổi từ khóa, giảm bớt bộ lọc hoặc chọn danh mục khác.</p>
                        
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('search') }}" class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">
                                Xóa bộ lọc
                            </a>
                            <a href="{{ route('search.advanced') }}" class="px-6 py-2 bg-white text-indigo-600 border border-indigo-200 font-bold rounded-xl hover:bg-indigo-50 transition">
                                Tìm nâng cao
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection