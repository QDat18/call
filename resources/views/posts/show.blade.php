@extends('layouts.app')

@section('title', $post->title ?: 'Chi tiết bài viết')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-4">
        <div class="max-w-3xl mx-auto px-4">

            {{-- Back Button --}}
            <div class="mb-4">
                <a href="{{ route('posts.index') }}"
                    class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>

            {{-- Main Post Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">

                {{-- Header --}}
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('user.public-profile', $post->user_id) }}">
                                <img src="{{ $post->getUserAvatar() }}"
                                    class="w-10 h-10 rounded-full object-cover hover:opacity-90 transition">
                            </a>
                            <div>
                                <a href="{{ route('user.public-profile', $post->user_id) }}"
                                    class="font-semibold text-gray-900 dark:text-white hover:underline block">
                                    {{ $post->getUserDisplayName() }}
                                </a>
                                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                    <span>{{ $post->published_at->diffForHumans() }}</span>
                                    <span>·</span>
                                    <i class="fas fa-globe-americas"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Options --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <i class="fas fa-ellipsis-h text-gray-500"></i>
                            </button>
                            <div x-show="open" x-cloak
                                class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-700 rounded-lg shadow-xl border border-gray-200 dark:border-gray-600 py-2 z-10">
                                <button onclick="toggleBookmark({{ $post->post_id }})"
                                    class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i class="fas fa-bookmark w-5"></i>
                                    <div class="text-left">
                                        <div class="font-semibold">
                                            {{ $post->isBookmarkedByUser(Auth::id()) ? 'Bỏ lưu' : 'Lưu bài viết' }}
                                        </div>
                                        <div class="text-xs text-gray-500">Thêm vào danh sách đã lưu</div>
                                    </div>
                                </button>

                                @if(Auth::check() && Auth::id() === $post->user_id)
                                    <hr class="my-2 border-gray-200 dark:border-gray-600">
                                    <a href="{{ route('posts.edit', $post->post_id) }}"
                                        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-pen w-5"></i>
                                        <div class="text-left">
                                            <div class="font-semibold">Chỉnh sửa bài viết</div>
                                        </div>
                                    </a>
                                    <button onclick="deletePost({{ $post->post_id }})"
                                        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-trash w-5"></i>
                                        <div class="text-left">
                                            <div class="font-semibold">Xóa bài viết</div>
                                        </div>
                                    </button>
                                @else
                                    <hr class="my-2 border-gray-200 dark:border-gray-600">
                                    <button onclick="openReportModal({{ $post->post_id }})"
                                        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fas fa-flag w-5"></i>
                                        <div class="text-left">
                                            <div class="font-semibold">Báo cáo bài viết</div>
                                            <div class="text-xs text-gray-500">Tôi lo ngại về bài viết này</div>
                                        </div>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    @if($post->title)
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h1>
                    @endif

                    <div class="text-gray-800 dark:text-gray-200 whitespace-pre-line text-[15px] leading-relaxed">
                        {{ $post->content }}
                    </div>
                </div>

                {{-- Image --}}
                {{-- Media (Images/Videos) --}}
                @if($post->media->count() > 0)
                    <div class="border-t border-b border-gray-200 dark:border-gray-700 mt-4">
                        {{-- Grid hiển thị ảnh: Nếu 1 ảnh thì full, nhiều ảnh thì chia cột --}}
                        <div class="grid gap-1 {{ $post->media->count() > 1 ? 'grid-cols-2' : 'grid-cols-1' }}">
                            @foreach($post->media as $media)
                                <div class="relative bg-black group">
                                    @if($media->file_type == 'image')
                                        <img src="{{ asset('storage/' . $media->file_path) }}" alt="Post media"
                                            class="w-full h-auto max-h-[600px] object-contain mx-auto">
                                    @elseif($media->file_type == 'video')
                                        <video controls class="w-full h-auto max-h-[600px] mx-auto">
                                            <source src="{{ asset('storage/' . $media->file_path) }}">
                                            Trình duyệt của bạn không hỗ trợ thẻ video.
                                        </video>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Stats --}}
                <div class="px-4 py-2 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-1">
                        @if($post->likes_count > 0)
                            <div class="flex -space-x-1">
                                <span
                                    class="w-5 h-5 rounded-full bg-blue-600 flex items-center justify-center ring-1 ring-white dark:ring-gray-800">
                                    <i class="fas fa-thumbs-up text-white text-[10px]"></i>
                                </span>
                                <span
                                    class="w-5 h-5 rounded-full bg-red-600 flex items-center justify-center ring-1 ring-white dark:ring-gray-800">
                                    <i class="fas fa-heart text-white text-[10px]"></i>
                                </span>
                                <span
                                    class="w-5 h-5 rounded-full bg-yellow-500 flex items-center justify-center ring-1 ring-white dark:ring-gray-800">
                                    <i class="fas fa-laugh text-white text-[10px]"></i>
                                </span>
                            </div>
                            <button onclick="showLikesModal({{ $post->post_id }})"
                                class="ml-2 hover:underline cursor-pointer font-medium text-gray-600 dark:text-gray-400">
                                {{ $post->likes_count }}
                            </button>
                        @endif
                    </div>

                    <div class="flex gap-3">
                        <button onclick="document.getElementById('comment-content').focus()"
                            class="hover:underline cursor-pointer">
                            {{ $post->comments_count }} bình luận
                        </button>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="border-t border-gray-200 dark:border-gray-700 px-2 py-1">
                    <div class="grid grid-cols-3 gap-1">
                        <button onclick="toggleLike({{ $post->post_id }})" id="like-btn-{{ $post->post_id }}"
                            class="flex items-center justify-center gap-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition
                                            {{ $post->isLikedByUser(Auth::id()) ? 'text-blue-600' : 'text-gray-600 dark:text-gray-400' }}">
                            <i class="fas fa-thumbs-up text-lg"></i>
                            <span class="font-semibold text-[15px]">Thích</span>
                        </button>

                        <button onclick="document.getElementById('comment-content').focus()"
                            class="flex items-center justify-center gap-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition">
                            <i class="fas fa-comment text-lg"></i>
                            <span class="font-semibold text-[15px]">Bình luận</span>
                        </button>

                        <button onclick="sharePost({{ $post->post_id }})"
                            class="flex items-center justify-center gap-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition">
                            <i class="fas fa-share text-lg"></i>
                            <span class="font-semibold text-[15px]">Chia sẻ</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Comments Section --}}
            @if($post->allow_comments)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4" id="comments-section">

                    @auth
                        {{-- Write Comment --}}
                        <div class="flex gap-2 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name) }}"
                                class="w-8 h-8 rounded-full object-cover">

                            <div class="flex-1">
                                <form action="{{ route('posts.comment', $post->post_id) }}" method="POST" id="comment-form">
                                    @csrf
                                    <input type="hidden" name="parent_id" id="parent_id_input">

                                    <div class="relative">
                                        <div id="reply-indicator"
                                            class="hidden mb-2 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-xs text-blue-600 dark:text-blue-400 flex items-center justify-between">
                                            <span>Đang trả lời <b id="reply-to-username"></b></span>
                                            <button type="button" onclick="cancelReply()"
                                                class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <div class="flex items-start gap-2">
                                            <div class="flex-1 relative">
                                                <textarea name="content" id="comment-content" rows="1"
                                                    class="w-full bg-gray-100 dark:bg-gray-700 rounded-full px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none text-sm pr-10"
                                                    placeholder="Viết bình luận..."
                                                    onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); this.form.requestSubmit(); }"></textarea>
                                                <button type="submit"
                                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-blue-600 hover:text-blue-700 p-1">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700 text-center">
                            <p class="text-gray-600 dark:text-gray-400">
                                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Đăng nhập</a> để
                                bình luận
                            </p>
                        </div>
                    @endauth

                    {{-- Comments List --}}
                    <div class="space-y-3" id="comments-list">
                        @forelse($post->comments as $comment)
                            @include('posts.components.comment-item', ['comment' => $comment, 'level' => 0])
                        @empty
                            <div class="text-center py-8">
                                <i class="far fa-comments text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Chưa có bình luận nào. Hãy là người đầu tiên
                                    bình luận!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Likes Modal --}}
    <div id="likes-modal"
        class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full shadow-2xl max-h-[80vh] flex flex-col">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Người đã thích</h3>
                <button onclick="document.getElementById('likes-modal').classList.add('hidden')"
                    class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <i class="fas fa-times text-gray-500"></i>
                </button>
            </div>
            <div class="p-4 overflow-y-auto flex-1" id="likes-list">
                <div class="flex items-center justify-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle Like with animation
            async function toggleLike(postId) {
                const btn = document.getElementById(`like-btn-${postId}`);
                const isLiked = btn.classList.contains('text-blue-600');

                // Optimistic UI update
                if (isLiked) {
                    btn.classList.remove('text-blue-600');
                    btn.classList.add('text-gray-600', 'dark:text-gray-400');
                } else {
                    btn.classList.remove('text-gray-600', 'dark:text-gray-400');
                    btn.classList.add('text-blue-600');
                    // Add bounce animation
                    btn.style.transform = 'scale(1.2)';
                    setTimeout(() => btn.style.transform = 'scale(1)', 200);
                }

                try {
                    const response = await fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });
                    const data = await response.json();

                    if (data.success) {
                        // Update like count
                        location.reload(); // Or update dynamically
                    } else {
                        // Revert on error
                        if (isLiked) {
                            btn.classList.add('text-blue-600');
                            btn.classList.remove('text-gray-600', 'dark:text-gray-400');
                        } else {
                            btn.classList.remove('text-blue-600');
                            btn.classList.add('text-gray-600', 'dark:text-gray-400');
                        }

                        if (data.message) {
                            alert(data.message);
                        } else {
                            window.location.href = '{{ route("login") }}';
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    // Revert on error
                    if (isLiked) {
                        btn.classList.add('text-blue-600');
                        btn.classList.remove('text-gray-600', 'dark:text-gray-400');
                    } else {
                        btn.classList.remove('text-blue-600');
                        btn.classList.add('text-gray-600', 'dark:text-gray-400');
                    }
                }
            }

            async function toggleBookmark(postId) {
                try {
                    const response = await fetch(`/posts/${postId}/bookmark`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });
                    const data = await response.json();

                    if (data.success) {
                        // Show notification
                        showNotification(data.bookmarked ? 'Đã lưu bài viết' : 'Đã bỏ lưu bài viết');
                        setTimeout(() => location.reload(), 500);
                    } else {
                        if (data.message) alert(data.message);
                        else window.location.href = '{{ route("login") }}';
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            function showNotification(message) {
                const notification = document.createElement('div');
                notification.className = 'fixed bottom-4 left-1/2 -translate-x-1/2 bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 2000);
            }

            async function deletePost(postId) {
                if (!confirm('Bạn có chắc chắn muốn xóa bài viết này?')) return;

                try {
                    const response = await fetch(`/posts/${postId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        showNotification('Đã xóa bài viết');
                        setTimeout(() => window.location.href = '{{ route("posts.index") }}', 1000);
                    }
                } catch (error) {
                    console.error(error);
                    alert('Đã xảy ra lỗi');
                }
            }

            function sharePost(postId) {
                // Share functionality
                const url = window.location.href;
                if (navigator.share) {
                    navigator.share({
                        title: '{{ $post->title }}',
                        url: url
                    }).catch(err => console.log('Error sharing:', err));
                } else {
                    // Fallback: Copy to clipboard
                    navigator.clipboard.writeText(url).then(() => {
                        showNotification('Đã sao chép liên kết');
                    });
                }
            }

            async function showLikesModal(postId) {
                const modal = document.getElementById('likes-modal');
                const list = document.getElementById('likes-list');

                modal.classList.remove('hidden');
                list.innerHTML = '<div class="flex items-center justify-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i></div>';

                try {
                    const response = await fetch(`/posts/${postId}/likes`);
                    const data = await response.json();

                    if (data.likes && data.likes.length > 0) {
                        list.innerHTML = data.likes.map(user => `
                                                    <a href="/user/${user.user_id}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                        <img src="${user.avatar_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name)}" 
                                                             class="w-10 h-10 rounded-full object-cover">
                                                        <div class="flex-1">
                                                            <div class="font-semibold text-gray-900 dark:text-white">${user.name}</div>
                                                        </div>
                                                        <div class="text-blue-600 text-xl">
                                                            <i class="fas fa-thumbs-up"></i>
                                                        </div>
                                                    </a>
                                                `).join('');
                    } else {
                        list.innerHTML = '<p class="text-center text-gray-500 py-8">Chưa có ai thích bài viết này</p>';
                    }
                } catch (error) {
                    list.innerHTML = '<p class="text-center text-red-500 py-8">Đã xảy ra lỗi</p>';
                }
            }

            function cancelReply() {
                document.getElementById('reply-indicator').classList.add('hidden');
                document.getElementById('parent_id_input').value = '';
                document.getElementById('comment-content').placeholder = 'Viết bình luận...';
            }

            // Auto-resize textarea
            const mainTextarea = document.getElementById('comment-content');
            if (mainTextarea) {
                mainTextarea.addEventListener('input', function () {
                    this.style.height = 'auto';
                    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
                });
            }

            // Reply to comment function
            function replyToComment(commentId, username) {
                document.getElementById('parent_id_input').value = commentId;
                document.getElementById('reply-to-username').textContent = username;
                document.getElementById('reply-indicator').classList.remove('hidden');
                document.getElementById('comment-content').focus();
                document.getElementById('comment-content').placeholder = `Trả lời ${username}...`;
            }

            // Like comment function
            async function likeComment(commentId) {
                const btn = document.getElementById(`comment-like-${commentId}`);
                const countSpan = document.getElementById(`comment-like-count-${commentId}`);

                try {
                    const response = await fetch(`/comments/${commentId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });
                    const data = await response.json();

                    if (data.success) {
                        if (data.liked) {
                            btn.classList.add('text-blue-600');
                            btn.classList.remove('text-gray-500');
                        } else {
                            btn.classList.remove('text-blue-600');
                            btn.classList.add('text-gray-500');
                        }

                        if (countSpan) {
                            countSpan.textContent = data.likes_count || '';
                            if (data.likes_count > 0) {
                                countSpan.classList.remove('hidden');
                            } else {
                                countSpan.classList.add('hidden');
                            }
                        }
                    } else {
                        if (!data.message) {
                            window.location.href = '{{ route("login") }}';
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            // Delete comment function
            async function deleteComment(commentId) {
                if (!confirm('Bạn có chắc chắn muốn xóa bình luận này?')) return;

                try {
                    const response = await fetch(`/comments/${commentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });
                    const data = await response.json();

                    if (data.success) {
                        showNotification('Đã xóa bình luận');
                        setTimeout(() => location.reload(), 500);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Đã xảy ra lỗi');
                }
            }
        </script>

        <style>
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translate(-50%, 10px);
                }

                to {
                    opacity: 1;
                    transform: translate(-50%, 0);
                }
            }

            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }

            [x-cloak] {
                display: none !important;
            }
        </style>
    @endpush
    @include('posts.components.report-modal')
@endsection