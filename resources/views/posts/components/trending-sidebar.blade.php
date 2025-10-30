<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 sticky top-4">
    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
        <i class="fas fa-fire text-orange-500 mr-2"></i>Trending Posts
    </h3>
    <div class="space-y-3">
        @php
            $trending = App\Models\Post::published()
                ->where('published_at', '>=', now()->subDays(7))
                ->orderByRaw('(views_count * 1 + likes_count * 2 + comments_count * 3) DESC')
                ->take(5)
                ->get();
        @endphp
        @foreach($trending as $index => $trend)
        <a href="{{ route('posts.show', $trend->post_id) }}" 
           class="block hover:bg-gray-50 dark:hover:bg-gray-750 p-3 rounded-lg transition">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-orange-400 to-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-2">
                        {{ $trend->title ?: Str::limit($trend->content, 50) }}
                    </p>
                    <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <span><i class="fas fa-eye mr-1"></i>{{ $trend->views_count }}</span>
                        <span><i class="fas fa-heart mr-1"></i>{{ $trend->likes_count }}</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>