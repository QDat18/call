<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4">Top Contributors</h3>
    <div class="space-y-3">
        @php
            $topUsers = App\Models\User::withCount('posts')
                ->having('posts_count', '>', 0)
                ->orderBy('posts_count', 'desc')
                ->take(5)
                ->get();
        @endphp
        @foreach($topUsers as $user)
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <img src="{{ $user->avatar_url ?? '/images/default-avatar.png' }}" 
                     class="w-8 h-8 rounded-full">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $user->posts_count }} posts
                    </p>
                </div>
            </div>
            <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">
                {{ $user->user_type }}
            </span>
        </div>
        @endforeach
    </div>
</div>