@extends('layouts.app')

@section('title', 'Community Feed')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="max-w-[1440px] mx-auto px-4 py-4">
            <div class="grid grid-cols-12 gap-4">

                <!-- Left Sidebar - Fixed Position -->
                <div class="col-span-3 hidden lg:block">
                    <div class="sticky top-20 space-y-2">
                        @auth
                            <!-- User Quick Profile -->
                            <a href="{{ route('profile') }}"
                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-800 transition">
                                <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name) }}"
                                    class="w-9 h-9 rounded-full object-cover">
                                <span class="font-semibold text-gray-900 dark:text-white text-sm">{{ Auth::user()->first_name }}
                                    {{ Auth::user()->last_name }}</span>
                            </a>
                        @endauth

                        <!-- Navigation Links -->
                        <a href="{{ route('connections.index', ['status' => 'accepted']) }}"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-800 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-user-friends text-blue-600 text-lg"></i>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white text-sm">Bạn bè</span>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-800 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-lg"></i>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white text-sm">Nhóm</span>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-800 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-bookmark text-purple-600 text-lg"></i>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white text-sm">Đã lưu</span>
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-800 transition">
                            <div class="w-9 h-9 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-red-600 text-lg"></i>
                            </div>
                            <span class="font-semibold text-gray-900 dark:text-white text-sm">Sự kiện</span>
                        </a>

                        <hr class="border-gray-300 dark:border-gray-700 my-2">

                        <div class="px-2">
                            <h3 class="text-gray-500 dark:text-gray-400 font-semibold text-xs mb-2">CHIẾN DỊCH CỦA BẠN</h3>
                            <!-- Add shortcuts here -->
                        </div>
                    </div>
                </div>

                <!-- Main Feed - Center -->
                <div class="col-span-12 lg:col-span-6 space-y-4">

                    <!-- Campaign Slider -->
                    @if($pinnedCampaigns->isNotEmpty())
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                            <div class="swiper main-campaign-slider rounded-lg overflow-hidden">
                                <div class="swiper-wrapper">
                                    @foreach($pinnedCampaigns as $campaign)
                                        <div class="swiper-slide">
                                            <div class="relative h-64"
                                                style="background-image: url('{{ $campaign->banner_image_url ? asset('storage/' . $campaign->banner_image_url) : '' }}'); background-size: cover; background-position: center;">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                                                </div>
                                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                                    <span
                                                        class="inline-block px-3 py-1 bg-red-600 rounded-full text-xs font-bold mb-2">QUYÊN
                                                        GÓP</span>
                                                    <h2 class="text-2xl font-bold mb-3">{{ $campaign->title }}</h2>

                                                    @php
                                                        $progress = ($campaign->current_amount > 0 && $campaign->target_amount > 0)
                                                            ? ($campaign->current_amount / $campaign->target_amount) * 100 : 0;
                                                        $progress = min($progress, 100);
                                                    @endphp

                                                    <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progress }}%">
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-between text-sm mb-3">
                                                        <span>{{ number_format($campaign->current_amount) }} VNĐ</span>
                                                        <span>{{ number_format($campaign->target_amount) }} VNĐ</span>
                                                    </div>

                                                    <a href="{{ route('campaign.show', $campaign->id) }}"
                                                        class="inline-block bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg font-semibold transition">
                                                        Quyên góp ngay
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    @endif

                    <!-- Create Post Card -->
                    @auth
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                            <div class="flex gap-3 mb-3">
                                <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name) }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                <a href="{{ route('posts.create') }}"
                                    class="flex-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full px-4 py-2.5 text-left text-gray-500 dark:text-gray-400 transition cursor-pointer">
                                    Bạn đang nghĩ gì?
                                </a>
                            </div>
                            <hr class="border-gray-200 dark:border-gray-700 mb-3">
                            <div class="grid grid-cols-3 gap-2">
                                <a href="{{ route('posts.create') }}"
                                    class="flex items-center justify-center gap-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <i class="fas fa-video text-red-500 text-xl"></i>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300 text-sm">Video trực tiếp</span>
                                </a>
                                <a href="{{ route('posts.create') }}"
                                    class="flex items-center justify-center gap-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <i class="fas fa-image text-green-500 text-xl"></i>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300 text-sm">Ảnh/video</span>
                                </a>
                                <a href="{{ route('posts.create') }}"
                                    class="flex items-center justify-center gap-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <i class="fas fa-smile text-yellow-500 text-xl"></i>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300 text-sm">Cảm xúc</span>
                                </a>
                            </div>
                        </div>
                    @endauth

                    <!-- Posts Feed -->
                    @forelse($posts as $post)
                        @include('posts.components.post-card', ['post' => $post])
                    @empty
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center">
                            <i class="fas fa-inbox text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Chưa có bài viết nào</h3>
                            <p class="text-gray-500 dark:text-gray-400">Hãy là người đầu tiên chia sẻ điều gì đó!</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if($posts->hasPages())
                        <div class="mt-4">
                            {{ $posts->links() }}
                        </div>
                    @endif

                </div>

                <!-- Right Sidebar - Contacts & Trending -->
                <div class="col-span-3 hidden lg:block">
                    <div class="sticky top-20 space-y-4">
                        <!-- Sponsored / Trending -->
                        <div>
                            <h3 class="text-gray-500 dark:text-gray-400 font-semibold text-sm px-2 mb-2">NỔI BẬT</h3>
                            @include('posts.components.trending-sidebar')
                        </div>

                        <hr class="border-gray-300 dark:border-gray-700">

                        <!-- Contacts -->
                        <div>
                            <div class="flex items-center justify-between px-2 mb-2">
                                <h3 class="text-gray-500 dark:text-gray-400 font-semibold text-sm">NGƯỜI LIÊN HỆ</h3>
                                <i class="fas fa-ellipsis-h text-gray-500 text-sm cursor-pointer"></i>
                            </div>
                            @include('posts.components.top-contributors')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('posts.components.report-modal')
    @include('posts.components.share-modal')

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const swiper = new Swiper('.main-campaign-slider', {
                    loop: {{ $pinnedCampaigns->count() > 1 ? 'true' : 'false' }},
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                });
            });

            async function toggleLike(postId) {
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
                        location.reload();
                    } else {
                        if (data.message) alert(data.message);
                        else window.location.href = '{{ route("login") }}';
                    }
                } catch (error) {
                    console.error('Error liking post:', error);
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
                        location.reload();
                    } else {
                        if (data.message) alert(data.message);
                        else window.location.href = '{{ route("login") }}';
                    }
                } catch (error) {
                    console.error('Error bookmarking post:', error);
                }
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
                        location.reload();
                    }
                } catch (error) {
                    console.error(error);
                    alert('Đã xảy ra lỗi');
                }
            }
        </script>
    @endpush

@endsection