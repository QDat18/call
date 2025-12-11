{{-- resources/views/posts/components/post-card.blade.php --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 mb-4">

    {{-- Header --}}
    <div class="p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('user.public-profile', $post->user_id) }}" class="flex-shrink-0">
                    @php
                        $displayName = 'User';
                        if ($post->user) {
                            if ($post->user->user_type === 'Organization' && $post->user->organization) {
                                $displayName = $post->user->organization->organization_name;
                            } else {
                                $displayName = $post->user->first_name . ' ' . $post->user->last_name;
                            }
                        }
                        $avatarSrc = $post->getUserAvatar(); 
                    @endphp

                    <img src="{{ $avatarSrc }}" alt="{{ $displayName }}" class="w-10 h-10 rounded-full object-cover">
                </a>

                <div class="flex-1">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('user.public-profile', $post->user_id) }}"
                            class="font-semibold text-gray-900 dark:text-gray-100 hover:underline text-[15px]">
                            {{ $displayName }}
                        </a>
                        {!! $post->getUserBadge() !!}
                    </div>

                    <div class="flex items-center space-x-1 text-[13px] text-gray-500 dark:text-gray-400">
                        <span>{{ $post->published_at->diffForHumans() }}</span>
                        <span>·</span>
                        <i class="fas fa-globe-americas text-[11px]"></i>
                    </div>
                </div>
            </div>

            {{-- Dropdown Menu --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 transition">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50"
                    style="display: none;">

                    {{-- Owner Options --}}
                    @if(Auth::id() === $post->user_id)
                        <a href="{{ route('posts.edit', $post->post_id) }}"
                            class="flex items-center px-3 py-2.5 text-[15px] text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                <i class="fas fa-pen text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div>
                                <div class="font-semibold">Edit post</div>
                                <div class="text-[13px] text-gray-500">Make changes to your post</div>
                            </div>
                        </a>

                        <button onclick="togglePinPost({{ $post->post_id }})"
                            class="w-full flex items-center px-3 py-2.5 text-[15px] text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                <i class="fas fa-thumbtack text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold">Pin post</div>
                                <div class="text-[13px] text-gray-500">Feature at top of feed</div>
                            </div>
                        </button>

                        <button onclick="changeAudience({{ $post->post_id }})"
                            class="w-full flex items-center px-3 py-2.5 text-[15px] text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                <i class="fas fa-globe-americas text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold">Edit audience</div>
                                <div class="text-[13px] text-gray-500">Control who can see this</div>
                            </div>
                        </button>

                        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

                        <button onclick="deletePost({{ $post->post_id }})"
                            class="w-full flex items-center px-3 py-2.5 text-[15px] text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                <i class="fas fa-trash text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold">Move to trash</div>
                                <div class="text-[13px] text-gray-500">Items in trash are deleted after 30 days</div>
                            </div>
                        </button>
                    @else
                        {{-- Non-owner Options --}}
                        <button onclick="savePost({{ $post->post_id }})"
                            class="w-full flex items-center px-3 py-2.5 text-[15px] text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                <i class="far fa-bookmark text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold">Save post</div>
                                <div class="text-[13px] text-gray-500">Add this to your saved items</div>
                            </div>
                        </button>

                        <button class="w-full flex items-center px-3 py-2.5 text-[15px] text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                <i class="fas fa-eye-slash text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold">Hide post</div>
                                <div class="text-[13px] text-gray-500">See fewer posts like this</div>
                            </div>
                        </button>

                        <button class="w-full flex items-center px-3 py-2.5 text-[15px] text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                <i class="fas fa-user-times text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold">Unfollow {{ $displayName }}</div>
                                <div class="text-[13px] text-gray-500">Stop seeing posts but stay connected</div>
                            </div>
                        </button>

                        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

                        {{-- Nút Report đã sửa tên hàm --}}
                        <button onclick="openReportModal({{ $post->post_id }})"
                            class="w-full flex items-center px-3 py-2.5 text-[15px] text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                                <i class="fas fa-flag text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div class="text-left">
                                <div class="font-semibold">Report post</div>
                                <div class="text-[13px] text-gray-500">I'm concerned about this post</div>
                            </div>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="mt-3">
            <a href="{{ route('posts.show', $post->post_id) }}" class="block">
                @if($post->title)
                    <h3 class="text-[17px] font-semibold text-gray-900 dark:text-gray-100 mb-1">
                        {{ $post->title }}
                    </h3>
                @endif
                <p class="text-[15px] text-gray-900 dark:text-gray-100 whitespace-pre-line">
                    {{ Str::limit($post->content, 300) }}
                </p>
            </a>
        </div>
    </div>

    {{-- Media Grid --}}
    @if($post->media->count() > 0)
        <div class="mt-1 grid gap-1 overflow-hidden border-t border-b border-gray-100 dark:border-gray-700
            {{ $post->media->count() == 1 ? 'grid-cols-1' : 'grid-cols-2' }} 
            {{ $post->media->count() >= 3 ? 'h-96' : '' }}">

            @foreach($post->media->take(4) as $index => $item)
                @php
                    $colSpan = ($post->media->count() == 3 && $index == 0) ? 'row-span-2' : '';
                    $isLastItem = $index === 3;
                    $moreCount = $post->media->count() - 4;
                @endphp

                <div class="relative {{ $colSpan }} bg-black h-full group overflow-hidden">
                    @if($item->file_type == 'image')
                        <img src="{{ asset('storage/' . $item->file_path) }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-105 cursor-pointer"
                            onclick="openLightbox({{ json_encode($post->media) }}, {{ $index }})">
                    @else
                        <div class="w-full h-full relative">
                            <video src="{{ asset('storage/' . $item->file_path) }}" 
                                   controls preload="metadata"
                                   class="w-full h-full object-cover" 
                                   id="video-{{ $post->post_id }}-{{ $index }}"></video>
                            
                            {{-- Nút mở Fullscreen --}}
                            <button onclick="openLightbox({{ json_encode($post->media) }}, {{ $index }})"
                                class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full backdrop-blur-sm transition z-10 opacity-0 group-hover:opacity-100">
                                <i class="fas fa-expand text-sm"></i>
                            </button>
                        </div>
                    @endif

                    @if($isLastItem && $moreCount > 0)
                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center backdrop-blur-sm cursor-pointer z-20"
                            onclick="openLightbox({{ json_encode($post->media) }}, {{ $index }})">
                            <span class="text-white text-3xl font-bold">+{{ $moreCount }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Stats Bar --}}
    <div class="px-4 py-2 flex items-center justify-between text-[15px] text-gray-500 dark:text-gray-400">
        <div class="flex items-center space-x-1">
            @if($post->likes_count > 0)
                <div class="flex items-center -space-x-1">
                    <div class="w-[18px] h-[18px] rounded-full bg-blue-500 flex items-center justify-center border-2 border-white dark:border-gray-800">
                        <i class="fas fa-thumbs-up text-white text-[10px]"></i>
                    </div>
                    <div class="w-[18px] h-[18px] rounded-full bg-red-500 flex items-center justify-center border-2 border-white dark:border-gray-800">
                        <i class="fas fa-heart text-white text-[10px]"></i>
                    </div>
                </div>
                <span class="ml-2 hover:underline cursor-pointer">{{ $post->likes_count }}</span>
            @endif
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('posts.show', $post->post_id) }}" class="hover:underline">
                @if($post->comments_count > 0)
                    <span>{{ $post->comments_count }} comments</span>
                @else
                    <span>0 comments</span>
                @endif
            </a>
            <span class="hover:underline cursor-pointer">{{ number_format($post->views_count) }} views</span>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="border-t border-gray-200 dark:border-gray-700 px-2 py-1">
        <div class="flex items-center justify-around">
            {{-- Like --}}
            <button onclick="toggleLike({{ $post->post_id }})" id="like-btn-{{ $post->post_id }}"
                class="flex-1 flex items-center justify-center space-x-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ $post->isLikedByUser(Auth::id()) ? 'text-blue-600' : 'text-gray-600 dark:text-gray-400' }}">
                <i class="{{ $post->isLikedByUser(Auth::id()) ? 'fas' : 'far' }} fa-thumbs-up text-xl"></i>
                <span class="font-semibold text-[15px]">Like</span>
            </button>

            {{-- Comment --}}
            <a href="{{ route('posts.show', $post->post_id) }}"
                class="flex-1 flex items-center justify-center space-x-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition text-gray-600 dark:text-gray-400">
                <i class="far fa-comment text-xl"></i>
                <span class="font-semibold text-[15px]">Comment</span>
            </a>

            {{-- Share --}}
            <button onclick="sharePost({{ $post->post_id }})"
                class="flex-1 flex items-center justify-center space-x-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition text-gray-600 dark:text-gray-400">
                <i class="far fa-share-square text-xl"></i>
                <span class="font-semibold text-[15px]">Share</span>
            </button>
        </div>
    </div>
</div>