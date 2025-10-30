<div class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white rounded-lg shadow-lg p-6">
    <h3 class="font-bold mb-4">Community Stats</h3>
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-indigo-100">Total Posts</span>
            <span class="text-2xl font-bold">{{ App\Models\Post::published()->count() }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-indigo-100">Active Users</span>
            <span class="text-2xl font-bold">{{ App\Models\User::count() }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-indigo-100">This Week</span>
            <span class="text-2xl font-bold">
                {{ App\Models\Post::where('created_at', '>=', now()->subWeek())->count() }}
            </span>
        </div>
    </div>
</div>