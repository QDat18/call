{{-- resources/views/favorites/index.blade.php --}}
@extends('layouts.volunteer')

@section('title', 'Cơ hội yêu thích')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-pink-50 dark:from-slate-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-purple-700 dark:text-purple-300 mb-4">
                <i class="fas fa-heart mr-4"></i> Cơ hội yêu thích
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                Bạn đang theo dõi <strong class="text-purple-600">{{ $favorites->total() }}</strong> cơ hội
            </p>
        </div>

        <!-- Bộ lọc (nếu chưa đăng nhập thì ẩn) -->
        @auth
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-6 mb-8">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm..." class="px-5 py-3 rounded-xl border focus:ring-purple-400">
                    <select name="category" class="px-5 py-3 rounded-xl border focus:ring-purple-400">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                    <select name="sort_by" class="px-5 py-3 rounded-xl border">
                        <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="title">Tên A→Z</option>
                    </select>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl">Lọc</button>
                </form>
            </div>
        @endauth

        <!-- Danh sách -->
        @include('volunteer.favorites._list')
    </div>
</div>
@endsection