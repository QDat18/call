{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">

        {{-- HERO SECTION --}}
        <section class="relative w-full h-[600px] lg:h-screen overflow-hidden">
            <video class="absolute inset-0 w-full h-full object-cover" autoplay loop muted playsinline>
                <source src="{{ asset('videos/hero-volunteer.mp4') }}" type="video/mp4">
            </video>

            <div class="absolute inset-0 bg-black/60"></div>

            <div class="relative z-10 h-full flex items-center justify-center">
                <div class="max-w-4xl mx-auto px-4 text-center text-white">

                    <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight leading-tight">
                        Connect, Volunteer, <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">
                            Make Impact
                        </span>
                    </h1>

                    <p class="text-xl md:text-2xl mb-10 text-gray-200 max-w-2xl mx-auto font-light">
                        Join thousands of volunteers making a difference in Vietnam
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 rounded-full font-bold text-lg transition transform hover:scale-105 shadow-lg hover:shadow-indigo-500/30">
                            Get Started
                        </a>
                        <a href="{{ route('opportunities.index') }}"
                            class="px-8 py-4 bg-white/10 hover:bg-white/20 border border-white/30 backdrop-blur-md rounded-full font-bold text-lg transition">
                            Browse Opportunities
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 -mt-10 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 text-center transform hover:-translate-y-1 transition duration-300">
                    <div class="text-4xl font-bold text-indigo-600 mb-1">{{ $stats['total_volunteers'] ?? 0 }}</div>
                    <div class="text-gray-600 dark:text-gray-400 font-medium">Active Volunteers</div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 text-center transform hover:-translate-y-1 transition duration-300">
                    <div class="text-4xl font-bold text-green-600 mb-1">{{ $stats['total_opportunities'] ?? 0 }}</div>
                    <div class="text-gray-600 dark:text-gray-400 font-medium">Opportunities</div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 text-center transform hover:-translate-y-1 transition duration-300">
                    <div class="text-4xl font-bold text-purple-600 mb-1">{{ $stats['total_hours'] ?? 0 }}</div>
                    <div class="text-gray-600 dark:text-gray-400 font-medium">Hours Volunteered</div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 text-center transform hover:-translate-y-1 transition duration-300">
                    <div class="text-4xl font-bold text-orange-600 mb-1">{{ $stats['total_organizations'] ?? 0 }}</div>
                    <div class="text-gray-600 dark:text-gray-400 font-medium">Organizations</div>
                </div>

            </div>
        </section>
        {{-- === NEW SECTION: BẢNG VÀNG VINH DANH === --}}
        <section class="max-w-7xl mx-auto px-4 py-16 relative z-10">
            {{-- Khung nền Gradient Đen-Tím sang trọng --}}
            <div
                class="relative rounded-[2.5rem] overflow-hidden bg-[#0F172A] shadow-2xl shadow-indigo-500/20 border border-white/10">

                {{-- Hiệu ứng nền (Blobs phát sáng) --}}
                <div
                    class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-yellow-500 rounded-full mix-blend-screen filter blur-[100px] opacity-20 animate-pulse">
                </div>
                <div
                    class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-purple-600 rounded-full mix-blend-screen filter blur-[100px] opacity-20">
                </div>

                <div class="relative z-10 px-6 py-12 md:p-16 flex flex-col md:flex-row items-center justify-between gap-12">

                    {{-- Cột Trái: Tiêu đề & CTA --}}
                    <div class="md:w-1/3 text-center md:text-left space-y-6">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-yellow-400/10 border border-yellow-400/20 text-yellow-300 font-bold text-xs uppercase tracking-widest">
                            <i class="fas fa-crown text-sm"></i> Bảng vàng tháng 12
                        </div>

                        <h2 class="text-4xl md:text-5xl font-black text-white leading-tight">
                            Vinh Danh <br>
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-amber-400 to-yellow-500 drop-shadow-sm">
                                Trái Tim Vàng
                            </span>
                        </h2>

                        <p class="text-slate-300 text-lg leading-relaxed">
                            Cùng chúc mừng những cá nhân xuất sắc nhất đã cống hiến không ngừng nghỉ cho cộng đồng.
                        </p>

                        <div class="pt-2">
                            <a href="{{ route('leaderboard.index') }}"
                                class="group inline-flex items-center gap-3 px-8 py-4 bg-white text-slate-900 font-bold rounded-2xl transition-all duration-300 hover:bg-yellow-400 hover:scale-105 hover:shadow-lg hover:shadow-yellow-400/50">
                                Xem Bảng Xếp Hạng
                                <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Cột Phải: Top 3 Cards (Thiết kế bục vinh quang) --}}
                    <div class="md:w-2/3 w-full grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">

                        {{-- Vị trí số 2 (Trái) --}}
                        @if(isset($topVolunteers[1]))
                            <div
                                class="order-2 sm:order-1 bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-6 flex flex-col items-center text-center transform hover:-translate-y-2 transition duration-300">
                                <div class="relative mb-4">
                                    <img src="{{ $topVolunteers[1]->user->avatar_url ? asset('storage/' . $topVolunteers[1]->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($topVolunteers[1]->user->first_name) . '&background=random' }}"
                                        class="w-16 h-16 rounded-full object-cover border-4 border-slate-300 shadow-lg">
                                    <div
                                        class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-slate-300 text-slate-800 text-xs font-bold px-2 py-0.5 rounded shadow-sm">
                                        #2</div>
                                </div>
                                <h3 class="text-white font-bold text-lg truncate w-full">
                                    {{ $topVolunteers[1]->user->first_name }}</h3>
                                <p class="text-slate-400 text-sm mb-3">Bạc</p>
                                <span
                                    class="bg-slate-700/50 text-slate-200 px-3 py-1 rounded-lg text-sm font-mono">{{ $topVolunteers[1]->total_volunteer_hours }}h</span>
                            </div>
                        @endif

                        {{-- Vị trí số 1 (Giữa - To nhất) --}}
                        @if(isset($topVolunteers[0]))
                            <div
                                class="order-1 sm:order-2 bg-gradient-to-b from-yellow-500/20 to-amber-900/20 backdrop-blur-md border border-yellow-500/30 rounded-3xl p-8 flex flex-col items-center text-center transform scale-110 shadow-2xl shadow-yellow-900/20 relative z-10">
                                <div class="absolute -top-6">
                                    <i class="fas fa-crown text-4xl text-yellow-400 drop-shadow-lg animate-bounce"
                                        style="animation-duration: 3s;"></i>
                                </div>
                                <div class="relative mb-4 mt-2">
                                    <img src="{{ $topVolunteers[0]->user->avatar_url ? asset('storage/' . $topVolunteers[0]->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($topVolunteers[0]->user->first_name) . '&background=random' }}"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-yellow-400 shadow-xl shadow-yellow-500/20">
                                    <div
                                        class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-yellow-400 text-yellow-900 text-sm font-bold px-3 py-0.5 rounded shadow-sm">
                                        #1</div>
                                </div>
                                <h3 class="text-white font-bold text-xl truncate w-full">
                                    {{ $topVolunteers[0]->user->first_name }}</h3>
                                <p class="text-yellow-200 text-sm mb-4 font-medium">Quán Quân</p>
                                <span
                                    class="bg-yellow-500 text-yellow-900 px-4 py-1.5 rounded-xl font-bold font-mono text-lg">{{ $topVolunteers[0]->total_volunteer_hours }}h</span>
                            </div>
                        @endif

                        {{-- Vị trí số 3 (Phải) --}}
                        @if(isset($topVolunteers[2]))
                            <div
                                class="order-3 sm:order-3 bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-6 flex flex-col items-center text-center transform hover:-translate-y-2 transition duration-300">
                                <div class="relative mb-4">
                                    <img src="{{ $topVolunteers[2]->user->avatar_url ? asset('storage/' . $topVolunteers[2]->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($topVolunteers[2]->user->first_name) . '&background=random' }}"
                                        class="w-16 h-16 rounded-full object-cover border-4 border-orange-700 shadow-lg">
                                    <div
                                        class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-orange-700 text-orange-100 text-xs font-bold px-2 py-0.5 rounded shadow-sm">
                                        #3</div>
                                </div>
                                <h3 class="text-white font-bold text-lg truncate w-full">
                                    {{ $topVolunteers[2]->user->first_name }}</h3>
                                <p class="text-slate-400 text-sm mb-3">Đồng</p>
                                <span
                                    class="bg-slate-700/50 text-slate-200 px-3 py-1 rounded-lg text-sm font-mono">{{ $topVolunteers[2]->total_volunteer_hours }}h</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
        {{-- POSTS FEED SECTION --}}
        <section class="max-w-7xl mx-auto px-4 py-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Community Stories</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Latest updates from our volunteer community</p>
                </div>
                <a href="{{ route('posts.index') }}"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    View All Posts
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Latest Posts (2 columns) --}}
                <div class="lg:col-span-2 space-y-6">
                    @forelse($latestPosts->take(5) as $post)
                        @include('posts.components.post-card', ['post' => $post, 'compact' => false])
                    @empty
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center">
                            <i class="fas fa-newspaper text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">No posts yet. Be the first to share!</p>
                        </div>
                    @endforelse

                    @if($latestPosts->count() > 5)
                        <div class="text-center">
                            <a href="{{ route('posts.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                Load more posts →
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">

                    {{-- Featured/Pinned Post --}}
                    @if($featuredPost)
                        <div
                            class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border-2 border-yellow-400 dark:border-yellow-600 rounded-lg p-6">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-star text-yellow-500 mr-2"></i>
                                <span class="font-bold text-gray-900 dark:text-gray-100">Featured Story</span>
                            </div>
                            <a href="{{ route('posts.show', $featuredPost->post_id) }}">
                                @if($featuredPost->image_url)
                                    <img src="{{ $featuredPost->image_url }}" class="w-full h-40 object-cover rounded-lg mb-3">
                                @endif
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $featuredPost->title ?: Str::limit($featuredPost->content, 60) }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ Str::limit($featuredPost->content, 120) }}
                                </p>
                            </a>
                        </div>
                    @endif

                    {{-- Trending Topics --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4">🔥 Trending Now</h3>
                        <div class="space-y-3">
                            @foreach($trendingPosts as $trending)
                                <a href="{{ route('posts.show', $trending->post_id) }}"
                                    class="block p-3 hover:bg-gray-50 dark:hover:bg-gray-750 rounded-lg transition">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-2">
                                        {{ $trending->title ?: Str::limit($trending->content, 50) }}
                                    </p>
                                    <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        <span><i
                                                class="fas fa-fire text-orange-500 mr-1"></i>{{ $trending->views_count }}</span>
                                        <span><i class="fas fa-heart text-red-500 mr-1"></i>{{ $trending->likes_count }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            @auth
                                <a href="{{ route('posts.create') }}"
                                    class="block w-full px-4 py-3 bg-indigo-600 text-white rounded-lg text-center hover:bg-indigo-700 transition">
                                    <i class="fas fa-plus-circle mr-2"></i>Share Your Story
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                    class="block w-full px-4 py-3 bg-indigo-600 text-white rounded-lg text-center hover:bg-indigo-700 transition">
                                    Join Community
                                </a>
                            @endauth
                            <a href="{{ route('opportunities.index') }}"
                                class="block w-full px-4 py-3 border-2 border-indigo-600 text-indigo-600 rounded-lg text-center hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition">
                                Find Opportunities
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- FEATURED OPPORTUNITIES --}}
        <section class="bg-white dark:bg-gray-800 py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Featured Opportunities</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($featuredOpportunities as $opportunity)
                        {{-- Opportunity card component --}}
                    @endforeach
                </div>
            </div>
        </section>

        {{-- SUCCESS METRICS --}}
        <section class="max-w-7xl mx-auto px-4 py-16">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl p-12 text-white text-center">
                <h2 class="text-4xl font-bold mb-4">Making Real Impact Together</h2>
                <p class="text-xl text-green-100 mb-8">Join our community of change-makers</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="text-5xl font-bold">{{ $impactStats['lives_touched'] ?? '10K+' }}</div>
                        <div class="text-green-100 mt-2">Lives Touched</div>
                    </div>
                    <div>
                        <div class="text-5xl font-bold">{{ $impactStats['projects_completed'] ?? '500+' }}</div>
                        <div class="text-green-100 mt-2">Projects Completed</div>
                    </div>
                    <div>
                        <div class="text-5xl font-bold">{{ $impactStats['communities_served'] ?? '63' }}</div>
                        <div class="text-green-100 mt-2">Communities Served</div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection