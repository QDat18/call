{{-- resources/views/posts/components/post-card.blade.php --}}
<div
    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition duration-300">
    <div class="p-5">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('user.public-profile', $post->user_id) }}" class="flex-shrink-0">
                    @php
                        // 1. Xác định tên để hiển thị trên Avatar mặc định (nếu chưa có ảnh)
                        $displayName = 'User';
                        if ($post->user) {
                            if ($post->user->user_type === 'Organization' && $post->user->organization) {
                                $displayName = $post->user->organization->organization_name;
                            } else {
                                $displayName = $post->user->first_name . ' ' . $post->user->last_name;
                            }
                        }

                        // 2. Xác định đường dẫn ảnh
                        $avatarSrc = 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=random&color=fff&size=128';

                        // Nếu user đã upload avatar thì dùng ảnh đó
                        if ($post->user && $post->user->avatar_url) {
                            $avatarSrc = asset('storage/' . $post->user->avatar_url);
                        }
                    @endphp

                    <img src="{{ $avatarSrc }}" alt="{{ $displayName }}"
                        class="w-10 h-10 rounded-full object-cover border border-gray-100 dark:border-gray-700">
                </a>

                <div>
                    <a href="{{ route('user.public-profile', $post->user_id) }}"
                        class="font-semibold text-gray-900 dark:text-gray-100 hover:underline text-sm">
                        {{ $post->getUserDisplayName() }}
                        {!! $post->getUserBadge() !!}
                    </a>

                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-0.5 space-x-2">
                        <span>{{ $post->published_at->diffForHumans() }}</span>
                        <span>•</span>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-{{ $post->getTypeColor() }}-600 dark:text-{{ $post->getTypeColor() }}-400">
                            {{ $post->getTypeLabel() }}
                        </span>
                    </div>
                </div>
            </div>

            @if(Auth::id() === $post->user_id)
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-10 py-1"
                        style="display: none;">
                        <a href="{{ route('posts.edit', $post->post_id) }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Edit</a>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-3">
            <a href="{{ route('posts.show', $post->post_id) }}" class="block group">
                @if($post->title)
                    <h3
                        class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                        {{ $post->title }}
                    </h3>
                @endif
                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed line-clamp-3">
                    {{ Str::limit($post->content, 200) }}
                </p>
            </a>

            @if($post->image_url)
                <div class="mt-3 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                    <a href="{{ route('posts.show', $post->post_id) }}">
                        <img src="{{ $post->image_url }}" alt="Post Image"
                            class="w-full h-64 object-cover hover:opacity-95 transition">
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div
        class="px-5 py-3 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div class="flex space-x-6">
            <button class="flex items-center space-x-1.5 text-gray-500 hover:text-pink-600 transition group">
                <i class="far fa-heart group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-medium">{{ $post->likes_count }}</span>
            </button>

            <a href="{{ route('posts.show', $post->post_id) }}"
                class="flex items-center space-x-1.5 text-gray-500 hover:text-blue-600 transition group">
                <i class="far fa-comment group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-medium">{{ $post->comments_count }}</span>
            </a>

            <button class="flex items-center space-x-1.5 text-gray-500 hover:text-green-600 transition group">
                <i class="far fa-share-square group-hover:scale-110 transition-transform"></i>
            </button>
        </div>

        <div class="text-xs text-gray-400">
            {{ $post->views_count }} views
        </div>
    </div>
</div>

<script>
    function togglePostActions(postId) {
        const menu = document.getElementById(`post-actions-${postId}`);
        menu.classList.toggle('hidden');

        // Close other open menus
        document.querySelectorAll('[id^="post-actions-"]').forEach(otherMenu => {
            if (otherMenu.id !== `post-actions-${postId}`) {
                otherMenu.classList.add('hidden');
            }
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('[onclick*="togglePostActions"]')) {
            document.querySelectorAll('[id^="post-actions-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
</script>