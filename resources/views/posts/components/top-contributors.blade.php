<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
        <i class="fas fa-crown text-yellow-500 mr-2"></i> Top Contributors
    </h3>
    
    <div class="space-y-4">
        @php
            // Nếu Controller chưa truyền biến $topContributors thì query trực tiếp (fallback)
            $contributors = $topContributors ?? \App\Models\User::withCount('posts')
                ->with(['organization']) // Eager load để lấy tên tổ chức nếu cần
                ->where('user_type', '!=', 'Admin')
                ->having('posts_count', '>', 0)
                ->orderBy('posts_count', 'desc')
                ->take(5)
                ->get();
        @endphp

        @foreach($contributors as $user)
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    
                    {{-- LOGIC XỬ LÝ AVATAR & TÊN --}}
                    @php
                        $displayName = $user->first_name . ' ' . $user->last_name;
                        
                        // Nếu là tổ chức, ưu tiên hiển thị tên tổ chức
                        if ($user->user_type === 'Organization' && $user->organization) {
                            $displayName = $user->organization->organization_name;
                        }

                        // Link ảnh
                        $avatarSrc = $user->avatar_url 
                            ? asset('storage/' . $user->avatar_url) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=random&color=fff';
                    @endphp

                    <a href="{{ route('user.public-profile', $user->user_id) }}" class="flex-shrink-0">
                        <img src="{{ $avatarSrc }}" 
                             alt="{{ $displayName }}"
                             class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                    </a>

                    <div>
                        <a href="{{ route('user.public-profile', $user->user_id) }}" 
                           class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 line-clamp-1">
                            {{ $displayName }}
                        </a>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 space-x-1">
                            <span>{{ $user->posts_count }} posts</span>
                            <span class="text-gray-300 dark:text-gray-600">•</span>
                            <span class="{{ $user->user_type == 'Organization' ? 'text-purple-600' : 'text-blue-600' }}">
                                {{ $user->user_type }}
                            </span>
                        </div>
                    </div>
                </div>
                
                {{-- Huy chương cho Top 3 --}}
                @if($loop->iteration <= 3)
                <div class="flex-shrink-0">
                    @if($loop->iteration == 1)
                        <i class="fas fa-medal text-yellow-400 text-lg" title="Top 1"></i>
                    @elseif($loop->iteration == 2)
                        <i class="fas fa-medal text-gray-400 text-lg" title="Top 2"></i>
                    @elseif($loop->iteration == 3)
                        <i class="fas fa-medal text-orange-400 text-lg" title="Top 3"></i>
                    @endif
                </div>
                @endif
            </div>
        @endforeach
    </div>
</div>