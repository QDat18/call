@extends('layouts.volunteer')

@section('title', 'Cơ hội đã lưu')

@section('content')
<div class="min-h-screen bg-slate-50 pb-12">
    {{-- Decorative Background --}}
    <div class="absolute top-0 inset-x-0 h-80 bg-gradient-to-b from-purple-100/50 to-slate-50 pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        
        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-800 tracking-tight mb-2">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                        Cơ hội yêu thích
                    </span>
                </h1>
                <p class="text-slate-500 text-lg">
                    Bạn đang lưu giữ <span class="font-bold text-purple-600">{{ $favorites->total() }}</span> cơ hội tiềm năng.
                </p>
            </div>

            <div class="flex gap-3">
                {{-- Nút Export --}}
                <a href="{{ route('volunteer.favorites.export') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-medium rounded-xl hover:bg-slate-50 hover:text-purple-600 transition shadow-sm">
                    <i class="fas fa-file-export"></i> Xuất Excel
                </a>
                
                {{-- Nút Tìm thêm --}}
                <a href="{{ route('opportunities.index') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 hover:shadow-lg hover:-translate-y-0.5 transition shadow-purple-200">
                    <i class="fas fa-plus"></i> Khám phá thêm
                </a>
            </div>
        </div>

        {{-- FILTER BAR --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-1 mb-8 sticky top-4 z-30 backdrop-blur-xl bg-white/90">
            <form method="GET" action="{{ route('volunteer.favorites.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-2">
                
                {{-- Search --}}
                <div class="md:col-span-5 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm cơ hội..."
                           class="w-full pl-10 pr-4 py-3 bg-slate-50 border-transparent rounded-xl focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition outline-none text-slate-700 font-medium">
                </div>

                {{-- Category --}}
                <div class="md:col-span-3">
                    <select name="category" onchange="this.form.submit()"
                            class="w-full px-4 py-3 bg-slate-50 border-transparent rounded-xl focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 cursor-pointer text-slate-700">
                        <option value="">📂 Tất cả danh mục</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                                {{ $cat->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort --}}
                <div class="md:col-span-3">
                    <select name="sort_by" onchange="this.form.submit()"
                            class="w-full px-4 py-3 bg-slate-50 border-transparent rounded-xl focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 cursor-pointer text-slate-700">
                        <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>🕒 Mới thêm gần đây</option>
                        <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>🔤 Tên A → Z</option>
                    </select>
                </div>

                {{-- Submit Button (Mobile only or for Search) --}}
                <div class="md:col-span-1">
                    <button type="submit" class="w-full h-full bg-slate-800 hover:bg-slate-900 text-white rounded-xl transition flex items-center justify-center">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- CONTENT LIST --}}
        <div id="favorites-container">
            @include('volunteer.favorites._list')
        </div>

    </div>
</div>
@endsection