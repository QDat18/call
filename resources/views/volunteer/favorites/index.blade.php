{{-- resources/views/volunteer/favorites/index.blade.php --}}
@extends('layouts.volunteer')

@section('title', 'Cơ hội yêu thích')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header siêu đẹp -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl shadow-2xl p-8 md:p-12 text-white mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold flex items-center gap-5">
                    <i class="fas fa-heart text-5xl md:text-6xl"></i>
                    Cơ hội yêu thích
                </h1>
                <p class="text-xl md:text-2xl mt-4 opacity-95">
                    Bạn đang lưu <strong class="text-4xl">{{ $favorites->total() }}</strong> cơ hội đặc biệt
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('favorites.export') ?? '#' }}" 
                   class="px-6 py-4 bg-white/20 backdrop-blur rounded-2xl hover:bg-white/30 transition flex items-center justify-center gap-3 font-medium">
                    <i class="fas fa-download"></i>
                    <span class="hidden sm:inline">Xuất CSV</span>
                </a>
                <a href="{{ route('opportunities.index') }}" 
                   class="px-8 py-4 bg-white text-purple-700 rounded-2xl hover:bg-purple-50 font-bold shadow-lg transition text-center">
                    Tìm thêm cơ hội
                </a>
            </div>
        </div>
    </div>

    <!-- Bộ lọc tìm kiếm -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-6 mb-8">
        <form method="GET" action="{{ route('volunteer.favorites.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tiêu đề, mô tả..."
                   class="px-6 py-4 rounded-2xl border border-purple-200 dark:border-purple-700 focus:ring-4 focus:ring-purple-100 dark:bg-slate-700">

            <select name="category" class="px-6 py-4 rounded-2xl border border-purple-200 dark:border-purple-700 focus:ring-4 focus:ring-purple-100 dark:bg-slate-700">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>

            <select name="sort_by" class="px-6 py-4 rounded-2xl border border-purple-200 dark:border-purple-700 focus:ring-4 focus:ring-purple-100 dark:bg-slate-700">
                <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Mới thêm trước</option>
                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Tên A → Z</option>
            </select>

            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transition">
                <i class="fas fa-search mr-2"></i> Tìm kiếm
            </button>
        </form>
    </div>

    <!-- Danh sách yêu thích -->
    @include('volunteer.favorites._list')
</div>
@endsection