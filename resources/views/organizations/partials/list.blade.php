<div class="mb-4 flex justify-between items-center text-gray-600 dark:text-gray-400">
    <span>Tìm thấy <strong>{{ $organizations->total() }}</strong> tổ chức phù hợp</span>
</div>

@if($organizations->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($organizations as $org)
            <a href="{{ route('organizations.show', $org->org_id) }}" 
               class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 block overflow-hidden">
                
                <div class="p-6">
                    {{-- Header Card --}}
                    <div class="flex items-start space-x-4 mb-4">
                        <div class="relative shrink-0">
                            <img src="{{ $org->avatar_url ? Storage::url($org->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($org->organization_name).'&background=10b981&color=fff' }}" 
                                 alt="{{ $org->organization_name }}"
                                 class="w-16 h-16 rounded-xl object-cover shadow-sm group-hover:scale-105 transition-transform duration-300">
                            @if($org->isVerified())
                                <div class="absolute -bottom-2 -right-2 bg-white dark:bg-gray-800 rounded-full p-1">
                                    <i class="fas fa-check-circle text-blue-500 text-lg"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-gray-800 dark:text-white truncate group-hover:text-green-600 transition-colors">
                                {{ $org->organization_name }}
                            </h3>
                            <span class="inline-block px-2 py-0.5 mt-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-md">
                                {{ $org->organization_type }}
                            </span>
                        </div>
                    </div>

                    {{-- Description --}}
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 min-h-[40px] mb-4">
                        {{ $org->description ?? 'Chưa có mô tả giới thiệu về tổ chức này.' }}
                    </p>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-3 gap-2 py-3 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="text-center border-r border-gray-200 dark:border-gray-600 last:border-0">
                            <div class="text-lg font-bold text-green-600">{{ $org->active_opportunities_count }}</div>
                            <div class="text-[10px] uppercase tracking-wider text-gray-500">Cơ hội</div>
                        </div>
                        <div class="text-center border-r border-gray-200 dark:border-gray-600 last:border-0">
                            <div class="text-lg font-bold text-blue-600">{{ $org->volunteer_count }}</div>
                            <div class="text-[10px] uppercase tracking-wider text-gray-500">TNV</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-yellow-500 flex items-center justify-center gap-1">
                                {{ number_format($org->rating, 1) }} <i class="fas fa-star text-xs"></i>
                            </div>
                            <div class="text-[10px] uppercase tracking-wider text-gray-500">Đánh giá</div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8 pagination-container">
        {{ $organizations->appends(request()->query())->links() }}
    </div>
@else
    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
        <div class="bg-gray-50 dark:bg-gray-700 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-search text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Không tìm thấy tổ chức nào</h3>
        <p class="text-gray-500 dark:text-gray-400">Hãy thử thay đổi từ khóa hoặc bộ lọc của bạn</p>
        <button onclick="resetFilters()" class="mt-4 text-green-600 font-medium hover:underline">
            Xóa bộ lọc
        </button>
    </div>
@endif