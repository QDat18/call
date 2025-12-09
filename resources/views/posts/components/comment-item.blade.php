{{-- Comment Item Component - Facebook Style --}}
@php
    $isOwner = Auth::check() && Auth::id() === $comment->user_id;
    $maxLevel = 2; // Maximum nesting level
@endphp

<div class="flex gap-2 {{ $level > 0 ? 'ml-10' : '' }}" id="comment-{{ $comment->comment_id }}">
    {{-- Avatar --}}
    <a href="{{ route('user.public-profile', $comment->user_id) }}" class="shrink-0">
        <img src="{{ $comment->user->avatar_url ? asset('storage/'.$comment->user->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->first_name) }}" 
             class="w-8 h-8 rounded-full object-cover hover:opacity-90 transition">
    </a>

    <div class="flex-1 min-w-0">
        {{-- Comment Bubble --}}
        <div class="inline-block">
            <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl px-3 py-2 inline-block relative group">
                {{-- Dropdown Menu --}}
                @if($isOwner)
                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                            class="w-6 h-6 flex items-center justify-center rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <i class="fas fa-ellipsis-h text-xs text-gray-500"></i>
                    </button>
                    <div x-show="open" x-cloak
                         class="absolute right-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-600 py-1 z-10">
                        <button onclick="deleteComment({{ $comment->comment_id }})" 
                                class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-trash text-xs"></i>
                            <span>Xóa</span>
                        </button>
                    </div>
                </div>
                @endif

                {{-- Author Name --}}
                <a href="{{ route('user.public-profile', $comment->user_id) }}" 
                   class="font-semibold text-[13px] text-gray-900 dark:text-white hover:underline block mb-0.5">
                    {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                </a>

                {{-- Comment Content --}}
                <div class="text-[15px] text-gray-800 dark:text-gray-200 whitespace-pre-line break-words {{ $isOwner ? 'pr-8' : '' }}">
                    {{ $comment->content }}
                </div>
            </div>
        </div>

        {{-- Actions Bar --}}
        <div class="flex items-center gap-4 mt-1 px-3 text-xs font-semibold">
            {{-- Like Button --}}
            <button onclick="likeComment({{ $comment->comment_id }})" 
                    id="comment-like-{{ $comment->comment_id }}"
                    class="hover:underline transition {{ $comment->isLikedByUser(Auth::id()) ? 'text-blue-600' : 'text-gray-500 dark:text-gray-400' }}">
                Thích
            </button>

            {{-- Reply Button --}}
            @if($level < $maxLevel)
                <button onclick="replyToComment({{ $comment->comment_id }}, '{{ $comment->user->first_name }} {{ $comment->user->last_name }}')" 
                        class="text-gray-500 dark:text-gray-400 hover:underline transition">
                    Phản hồi
                </button>
            @endif

            {{-- Timestamp --}}
            <span class="text-gray-500 dark:text-gray-400">
                {{ $comment->created_at->diffForHumans() }}
            </span>

            {{-- Like Count --}}
            @if($comment->likes_count > 0)
                <div class="flex items-center gap-1">
                    <span class="text-blue-600">
                        <i class="fas fa-thumbs-up text-[10px]"></i>
                    </span>
                    <span id="comment-like-count-{{ $comment->comment_id }}" class="text-gray-600 dark:text-gray-400">
                        {{ $comment->likes_count }}
                    </span>
                </div>
            @else
                <span id="comment-like-count-{{ $comment->comment_id }}" class="hidden text-gray-600 dark:text-gray-400"></span>
            @endif
        </div>

        {{-- Nested Replies --}}
        @if($comment->replies && $comment->replies->count() > 0)
            <div class="mt-3 space-y-3">
                @foreach($comment->replies as $reply)
                    @include('posts.components.comment-item', ['comment' => $reply, 'level' => $level + 1])
                @endforeach
            </div>
        @endif
    </div>
</div>