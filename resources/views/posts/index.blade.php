@extends('layouts.app')

@section('title', 'Community Feed')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4">

            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100">Community Feed</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Connect with volunteers and organizations making a
                    difference</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <!-- Left Sidebar - Filters -->
                <div class="lg:col-span-1">
                    @include('posts.components.filter-sidebar')
                </div>

                <!-- Main Feed -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Create Post Quick Action (for logged in users) -->
                    @auth
                        @include('posts.components.create-post-quick')
                    @endauth

                    <!-- Pinned Posts -->
                    {{-- @if($pinnedPosts->count() > 0)
                    @include('posts.components.pinned-posts', ['pinnedPosts' => $pinnedPosts])
                    @endif --}}
                    @if($pinnedCampaigns->isNotEmpty())
                        {{-- ƯU TIÊN 1: HIỂN THỊ SLIDER CHIẾN DỊCH QUYÊN GÓP --}}
                        <div class="mb-6">
                            <div class="swiper main-campaign-slider" style="border-radius: 8px; overflow: hidden;">
                                <div class="swiper-wrapper">
                                    @foreach($pinnedCampaigns as $campaign)
                                        <div class="swiper-slide">
                                            <div class="relative bg-gradient-to-r from-red-500 to-pink-600 text-white p-6"
                                                style="background-image: url('{{ $campaign->banner_image_url ? asset('storage/' . $campaign->banner_image_url) : '' }}'); background-size: cover; background-position: center;">

                                                <div class="absolute inset-0 bg-black opacity-40"></div>

                                                <div class="relative z-10">
                                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded">KÊU
                                                        GỌI QUYÊN GÓP</span>
                                                    <h2 class="text-2xl font-bold mt-2">{{ $campaign->title }}</h2>

                                                    @php
                                                        $progress = ($campaign->current_amount > 0 && $campaign->target_amount > 0)
                                                            ? ($campaign->current_amount / $campaign->target_amount) * 100 : 0;
                                                        $progress = min($progress, 100);
                                                    @endphp
                                                    <div class="w-full bg-gray-700 rounded-full h-2.5 mt-4">
                                                        <div class="bg-yellow-400 h-2.5 rounded-full"
                                                            style="width: {{ $progress }}%"></div>
                                                    </div>
                                                    <div class="flex justify-between text-xs mt-2">
                                                        <span>Đã đạt: {{ number_format($campaign->current_amount) }} VNĐ</span>
                                                        <span>Mục tiêu: {{ number_format($campaign->target_amount) }} VNĐ</span>
                                                    </div>

                                                    <a href="{{ route('campaign.show', $campaign->id) }}"
                                                        class="inline-block bg-white text-red-600 font-bold px-6 py-2 rounded-full mt-4 hover:bg-gray-100 text-sm">
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

                    @elseif($pinnedPosts->isNotEmpty())
                        {{-- ƯU TIÊN 2: NẾU KHÔNG CÓ CHIẾN DỊCH, HIỂN THỊ BÀI GHIM CŨ --}}
                        @include('posts.components.pinned-posts', ['pinnedPosts' => $pinnedPosts])
                    @endif
                    <!-- Posts Feed -->
                    @forelse($posts as $post)
                        @include('posts.components.post-card', ['post' => $post])
                    @empty
                        @include('posts.components.empty-state')
                    @endforelse

                    <!-- Pagination -->
                    @if($posts->hasPages())
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @endif

                </div>

                <!-- Right Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    @include('posts.components.trending-sidebar')
                    @include('posts.components.top-contributors')
                    @include('posts.components.quick-stats')
                </div>

            </div>
        </div>
    </div>

    <!-- Report Modal -->
    @include('posts.components.report-modal')

    <!-- Share Modal -->
    @include('posts.components.share-modal')

    @push('scripts')
        {{--
        <script src="{{ asset('js/posts.js') }}"></script> --}}
    @endpush

    @push('scripts')
        {{-- Thêm thư viện Swiper (bạn có thể đưa vào layout chính) --}}
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Khởi tạo Swiper
                const swiper = new Swiper('.main-campaign-slider', {
                    loop: {{ $pinnedCampaigns->count() > 1 ? 'true' : 'false' }}, // Chỉ lặp nếu có nhiều hơn 1 slide
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
        </script>
    @endpush
@endsection