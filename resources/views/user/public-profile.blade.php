@extends('layouts.app')

@section('title', $user->first_name . ' ' . $user->last_name)

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    
    {{-- Cover & Profile Header --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm">
        {{-- Cover Photo --}}
        <div class="h-80 bg-gradient-to-br from-purple-500 via-pink-500 to-red-500 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
        </div>
        
        {{-- Profile Info --}}
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between -mt-8 pb-4 border-b border-gray-200 dark:border-gray-700">
                
                {{-- Avatar & Name --}}
                <div class="flex flex-col md:flex-row items-center md:items-end gap-4">
                    <div class="relative">
                        <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($user->first_name.' '.$user->last_name).'&background=random&size=256' }}" 
                             class="w-40 h-40 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                        
                        {{-- User Type Badge --}}
                        <div class="absolute bottom-2 right-2">
                            @if($user->user_type === 'Organization')
                                <div class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center shadow-lg border-2 border-white dark:border-gray-800" title="Tổ chức">
                                    <i class="fas fa-building"></i>
                                </div>
                            @elseif($user->user_type === 'Admin')
                                <div class="w-10 h-10 bg-purple-500 text-white rounded-full flex items-center justify-center shadow-lg border-2 border-white dark:border-gray-800" title="Quản trị viên">
                                    <i class="fas fa-crown"></i>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center shadow-lg border-2 border-white dark:border-gray-800" title="Tình nguyện viên">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center md:text-left mb-3">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </h1>
                        
                        <p class="text-gray-500 dark:text-gray-400 mt-1">
                            {{ $user->posts_count }} bài viết
                        </p>
                        
                        @if($user->city)
                        <div class="flex items-center justify-center md:justify-start gap-2 text-sm text-gray-600 dark:text-gray-400 mt-2">
                            <i class="fas fa-map-marker-alt text-red-500"></i>
                            <span>{{ $user->city }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="flex gap-2 mb-3 justify-center md:justify-end">
                    @auth
                        @if(Auth::id() !== $user->user_id)
                            <button class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition flex items-center gap-2">
                                <i class="fas fa-user-plus"></i> Kết bạn
                            </button>
                            <button class="px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition flex items-center gap-2">
                                <i class="fas fa-comment"></i> Nhắn tin
                            </button>
                            <button class="w-10 h-10 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-lg transition flex items-center justify-center">
                                <i class="fas fa-ellipsis-h text-gray-700 dark:text-gray-300"></i>
                            </button>
                        @else
                            @if (Auth::user()->user_type === 'Volunteer')
                                <a href="{{ route('volunteer.profile.edit') }}" 
                                   class="px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition flex items-center gap-2">
                                    <i class="fas fa-pen"></i> Chỉnh sửa trang cá nhân
                                </a>
                            @elseif (Auth::user()->user_type === 'Organization')
                                <a href="{{ route('organization.profile.edit') }}" 
                                   class="px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition flex items-center gap-2">
                                    <i class="fas fa-pen"></i> Chỉnh sửa trang cá nhân
                                </a>
                            @endif
                            
                            {{-- <a href="{{ route('profile') }}" 
                               class="px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition flex items-center gap-2">
                                <i class="fas fa-pen"></i> Chỉnh sửa trang cá nhân --}}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Navigation Tabs --}}
            <div class="flex gap-2 pt-2 overflow-x-auto">
                <a href="#" class="px-4 py-3 text-blue-600 border-b-4 border-blue-600 font-semibold whitespace-nowrap">Bài viết</a>
                <a href="#" class="px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-lg font-semibold whitespace-nowrap">Giới thiệu</a>
                <a href="#" class="px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-lg font-semibold whitespace-nowrap">Bạn bè</a>
                <a href="#" class="px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-lg font-semibold whitespace-nowrap">Ảnh</a>
                <a href="#" class="px-4 py-3 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-lg font-semibold whitespace-nowrap">Video</a>
            </div>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="max-w-6xl mx-auto px-4 py-4">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
            
            {{-- Left Sidebar - Intro --}}
            <div class="lg:col-span-2 space-y-4">
                
                {{-- Intro Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Giới thiệu</h2>
                    
                    @if($user->bio)
                    <p class="text-gray-700 dark:text-gray-300 mb-4 text-center">{{ $user->bio }}</p>
                    @endif

                    <div class="space-y-3">
                        @if($user->city)
                        <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-map-marker-alt text-gray-400 w-5"></i>
                            <span>Sống tại <strong>{{ $user->city }}</strong></span>
                        </div>
                        @endif

                        @if($user->user_type === 'Organization' && $user->website)
                        <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-globe text-gray-400 w-5"></i>
                            <a href="{{ $user->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $user->website }}</a>
                        </div>
                        @endif

                        @if($user->user_type === 'Organization' && $user->phone)
                        <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-phone text-gray-400 w-5"></i>
                            <span>{{ $user->phone }}</span>
                        </div>
                        @endif

                        <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                            <i class="fas fa-clock text-gray-400 w-5"></i>
                            <span>Tham gia {{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Stats Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->posts_count }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Bài viết</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->comments_count }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Bình luận</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->total_likes ?? 0 }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Lượt thích</div>
                        </div>
                    </div>
                </div>

                {{-- Photos Card (Placeholder) --}}
{{-- Photos Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ảnh</h3>
                        <a href="#" class="text-blue-600 hover:underline text-sm font-semibold">Xem tất cả</a>
                    </div>
                    
                    {{-- Logic lấy 9 ảnh mới nhất từ bảng PostMedia của user này --}}
                    @php
                        $latestPhotos = \App\Models\PostMedia::whereHas('post', function($q) use ($user) {
                                $q->where('user_id', $user->user_id)
                                  ->where('status', 'published'); // Chỉ lấy ảnh từ bài công khai
                            })
                            ->where('file_type', 'image') // Chỉ lấy file ảnh
                            ->latest()
                            ->take(9)
                            ->get();
                    @endphp

                    @if($latestPhotos->count() > 0)
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($latestPhotos as $photo)
                                <a href="{{ route('posts.show', $photo->post_id) }}" class="aspect-square block overflow-hidden rounded-lg group relative">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                         alt="Photo" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    {{-- Overlay nhẹ khi hover --}}
                                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-images text-2xl mb-2 opacity-50"></i>
                            <p class="text-sm">Chưa có ảnh nào</p>
                        </div>
                    @endif
                </div>

                {{-- Activity Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Hoạt động gần đây</h3>
                    <div class="space-y-4">
                        @forelse($recentActivity ?? [] as $activity)
                            <div class="flex gap-3 items-start">
                                <i class="fas fa-circle text-[8px] text-green-500 mt-2"></i>
                                <div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $activity['description'] }}</p>
                                    <span class="text-xs text-gray-400">{{ $activity['time'] }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic text-center py-4">Chưa có hoạt động nào</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Main Content - Posts --}}
            <div class="lg:col-span-3 space-y-4">
                
                {{-- Filter Buttons --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-blue-100 text-blue-600 rounded-lg font-semibold text-sm">Bài viết</button>
                        <button class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg font-semibold text-sm">Đánh giá</button>
                    </div>
                </div>

                {{-- Posts List --}}
                @forelse($posts as $post)
                    @include('posts.components.post-card', ['post' => $post])
                @empty
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center">
                        <i class="fas fa-pen-fancy text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Chưa có bài viết nào</h3>
                        <p class="text-gray-500 dark:text-gray-400">Người dùng này chưa chia sẻ nội dung nào.</p>
                    </div>
                @endforelse

                {{-- Pagination --}}
                @if($posts->hasPages())
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
@endsection