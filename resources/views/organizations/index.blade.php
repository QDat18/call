@extends('layouts.app')

@section('title', 'Tổ Chức')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl shadow-lg p-8 mb-8 text-white">
            <h1 class="text-4xl font-bold mb-2">Tổ Chức Tình Nguyện</h1>
            <p class="text-green-100">Khám phá các tổ chức uy tín đang tìm kiếm tình nguyện viên</p>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-6">
            <form method="GET" action="{{ route('organizations.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <!-- Search -->
                <div class="md:col-span-2">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Tìm kiếm tổ chức..." 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Type Filter -->
                <div>
                    <select name="type" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="">Tất cả loại hình</option>
                        @foreach($organizationTypes as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Đánh giá cao nhất</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="volunteers" {{ request('sort') == 'volunteers' ? 'selected' : '' }}>Nhiều TNV nhất</option>
                        <option value="opportunities" {{ request('sort') == 'opportunities' ? 'selected' : '' }}>Nhiều cơ hội nhất</option>
                    </select>
                </div>

                <div class="md:col-span-4">
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                        <i class="fas fa-search mr-2"></i>Tìm kiếm
                    </button>
                </div>
            </form>
        </div>

        <!-- Results -->
        <div class="mb-4 text-gray-600 dark:text-gray-400">
            Tìm thấy <strong>{{ $organizations->total() }}</strong> tổ chức
        </div>

        <!-- Organizations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($organizations as $org)
                <a href="{{ route('organizations.show', $org->org_id) }}" 
                   class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition block">
                    
                    <!-- Organization Header -->
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <img src="{{ $org->avatar_url ? Storage::url($org->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($org->organization_name).'&background=059669&color=fff' }}" 
                                 alt="{{ $org->organization_name }}"
                                 class="w-16 h-16 rounded-lg object-cover">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-lg text-gray-800 dark:text-white truncate">
                                    {{ $org->organization_name }}
                                    @if($org->isVerified())
                                        <i class="fas fa-check-circle text-blue-500 text-sm ml-1"></i>
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $org->organization_type }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-4 line-clamp-2">
                            {{ $org->description ?? 'Chưa có mô tả' }}
                        </p>

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t dark:border-gray-700">
                            <div class="text-center">
                                <div class="text-xl font-bold text-green-600">{{ $org->active_opportunities_count }}</div>
                                <div class="text-xs text-gray-500">Cơ hội</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xl font-bold text-blue-600">{{ $org->volunteer_count }}</div>
                                <div class="text-xs text-gray-500">TNV</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xl font-bold text-yellow-600">{{ number_format($org->rating, 1) }} ⭐</div>
                                <div class="text-xs text-gray-500">Đánh giá</div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-building text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Không tìm thấy tổ chức</h3>
                    <p class="text-gray-600 dark:text-gray-400">Thử thay đổi bộ lọc để xem thêm kết quả</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $organizations->appends(request()->query())->links() }}
        </div>

    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection