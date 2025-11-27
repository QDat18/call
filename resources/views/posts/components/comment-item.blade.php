@props(['comment', 'level' => 0])

@php
    $isReply = $level > 0;
@endphp

<div class="comment-item {{ $isReply ? 'ml-10 mt-2' : 'mt-3' }}">
    
    <div class="flex items-start space-x-2 group">
        {{-- AVATAR COMMENTER --}}
        <a href="{{ route('user.public-profile', $comment->user_id) }}" class="flex-shrink-0 mt-0.5">
            <img src="{{ $comment->user->avatar_url ? asset('storage/' . $comment->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->first_name . ' ' . $comment->user->last_name) . '&background=random&color=fff' }}" 
                 class="w-8 h-8 rounded-full object-cover">
        </a>

        <div class="flex-1 min-w-0">
            <div class="relative">
                <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl px-3 py-2 inline-block max-w-full">
                    {{-- Tên người bình luận --}}
                    <a href="{{ route('user.public-profile', $comment->user_id) }}" 
                       class="font-semibold text-[13px] text-gray-900 dark:text-gray-100 hover:underline block">
                        {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                    </a>

                    {{-- Nội dung bình luận --}}
                    <p class="text-[15px] text-gray-900 dark:text-gray-100 mt-0.5 break-words whitespace-pre-wrap">{{ $comment->content }}</p>
                </div>
                
                {{-- Nút xóa (chỉ hiện khi hover và là chủ sở hữu) --}}
                @if(Auth::id() === $comment->user_id || (Auth::check() && Auth::user()->user_type === 'Admin'))
                <div class="absolute -right-1 top-0 opacity-0 group-hover:opacity-100 transition-opacity">
                    <form action="{{ route('comments.destroy', $comment->comment_id) }}" method="POST" onsubmit="return confirm('Delete this comment?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-6 h-6 bg-white dark:bg-gray-600 text-gray-500 hover:text-red-600 dark:hover:text-red-400 rounded-full shadow-sm hover:shadow flex items-center justify-center border border-gray-200 dark:border-gray-500 transition">
                            <i class="fas fa-times text-[10px]"></i>
                        </button>
                    </form>
                </div>
                @endif
            </div>

            {{-- Action Links --}}
            <div class="flex items-center space-x-3 mt-0.5 ml-3 text-[12px]">
                <button onclick="toggleCommentLike({{ $comment->comment_id }})" 
                        class="font-semibold text-gray-500 dark:text-gray-400 hover:underline transition">
                    Like
                </button>
                
                @auth
                <button onclick="replyToComment('{{ $comment->comment_id }}', '{{ $comment->user->first_name }} {{ $comment->user->last_name }}')" 
                        class="font-semibold text-gray-500 dark:text-gray-400 hover:underline transition">
                    Reply
                </button>
                @endauth
                
                <span class="text-gray-500 dark:text-gray-400">
                    {{ $comment->created_at->diffForHumans() }}
                </span>

                {{-- Like count (if any) --}}
                @if(isset($comment->likes_count) && $comment->likes_count > 0)
                <div class="flex items-center space-x-1">
                    <div class="flex items-center -space-x-1">
                        <div class="w-4 h-4 rounded-full bg-blue-500 flex items-center justify-center border border-white dark:border-gray-800">
                            <i class="fas fa-thumbs-up text-white text-[8px]"></i>
                        </div>
                    </div>
                    <span class="text-gray-600 dark:text-gray-400">{{ $comment->likes_count }}</span>
                </div>
                @endif
            </div>

            {{-- View Replies Button (if has replies) --}}
            @if($comment->replies && $comment->replies->count() > 0 && $level === 0)
                <button onclick="toggleReplies('replies-{{ $comment->comment_id }}')" 
                        class="flex items-center space-x-2 mt-2 ml-3 text-[13px] font-semibold text-gray-600 dark:text-gray-400 hover:underline">
                    <i class="fas fa-reply text-[11px]"></i>
                    <span>{{ $comment->replies->count() }} {{ $comment->replies->count() === 1 ? 'Reply' : 'Replies' }}</span>
                </button>
            @endif
        </div>
    </div>

    {{-- ĐỆ QUY: Hiển thị các replies (bình luận con) --}}
    @if($comment->replies && $comment->replies->count() > 0)
        <div class="replies-list" id="replies-{{ $comment->comment_id }}">
            @foreach($comment->replies as $reply)
                @include('posts.components.comment-item', ['comment' => $reply, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>

@if($level === 0)
<script>
function toggleReplies(id) {
    const repliesDiv = document.getElementById(id);
    if (repliesDiv) {
        repliesDiv.classList.toggle('hidden');
    }
}

function toggleCommentLike(commentId) {
    // Implement like functionality
    console.log('Like comment:', commentId);
}
</script>
@endif