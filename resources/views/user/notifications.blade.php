@extends('layouts.app')

@section('title', 'Thông Báo - VolunteerConnect')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-bell text-2xl text-indigo-600 dark:text-indigo-400"></i>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Thông Báo</h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ $notifications->total() }} thông báo
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full ml-2">
                                    {{ auth()->user()->unreadNotifications->count() }} chưa đọc
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
                
                @if($notifications->count() > 0)
                <div class="flex items-center space-x-2">
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition">
                            <i class="fas fa-check-double mr-2"></i>
                            Đánh dấu tất cả đã đọc
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($notifications as $notification)
                <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ !$notification->is_read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}"
                     id="notification-{{ $notification->notification_id }}">
                    <div class="flex items-start space-x-4">
                        <!-- Notification Icon -->
                        <div class="flex-shrink-0">
                            @php
                                $iconConfig = [
                                    'application' => ['icon' => 'fa-file-alt', 'color' => 'text-blue-500'],
                                    'opportunity' => ['icon' => 'fa-briefcase', 'color' => 'text-green-500'],
                                    'message' => ['icon' => 'fa-comment', 'color' => 'text-purple-500'],
                                    'system' => ['icon' => 'fa-cog', 'color' => 'text-gray-500'],
                                    'review' => ['icon' => 'fa-star', 'color' => 'text-yellow-500'],
                                    'default' => ['icon' => 'fa-bell', 'color' => 'text-indigo-500']
                                ];
                                
                                $type = strtolower($notification->notification_type ?? 'default');
                                $config = $iconConfig[$type] ?? $iconConfig['default'];
                            @endphp
                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-600 flex items-center justify-center">
                                <i class="{{ $config['icon'] }} {{ $config['color'] }}"></i>
                            </div>
                        </div>

                        <!-- Notification Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $notification->title }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        {{ $notification->content }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                
                                <!-- Notification Actions -->
                                <div class="flex items-center space-x-2 ml-4">
                                    @if(!$notification->is_read)
                                        <button onclick="markAsRead('{{ $notification->notification_id }}')"
                                                class="inline-flex items-center p-2 text-sm text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400 transition"
                                                title="Đánh dấu đã đọc">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    
                                    <button onclick="deleteNotification('{{ $notification->notification_id }}')"
                                            class="inline-flex items-center p-2 text-sm text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition"
                                            title="Xóa thông báo">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Action Buttons if any -->
                            @if(isset($notification->data['action_url']))
                                <div class="mt-3">
                                    <a href="{{ $notification->data['action_url'] }}" 
                                       class="inline-flex items-center px-3 py-1 text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition">
                                        Xem chi tiết
                                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="px-6 py-12 text-center">
                    <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-bell-slash text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        Không có thông báo
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Bạn chưa có thông báo nào. Chúng tôi sẽ thông báo cho bạn khi có hoạt động mới.
                    </p>
                    <a href="{{ route('opportunities.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        <i class="fas fa-search mr-2"></i>
                        Khám phá cơ hội tình nguyện
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function markAsRead(notificationId) {
    // Sửa URL: bỏ /user ở đầu
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notificationElement = document.getElementById(`notification-${notificationId}`);
            notificationElement.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
            
            // Update unread count in navbar
            updateUnreadCount();
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteNotification(notificationId) {
    if (!confirm('Bạn có chắc chắn muốn xóa thông báo này?')) {
        return;
    }

    fetch(`/notifications/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`notification-${notificationId}`).remove();
            updateUnreadCount();
            
            showFlashMessage('Thông báo đã được xóa', 'success');
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateUnreadCount() {
    // Tự động refresh trang sau 1s để cập nhật số đếm trên header
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function showFlashMessage(message, type = 'success') {
    const flashDiv = document.createElement('div');
    flashDiv.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    flashDiv.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(flashDiv);
    
    setTimeout(() => {
        flashDiv.remove();
    }, 3000);
}

// Auto-mark as read when notification is clicked
document.addEventListener('DOMContentLoaded', function() {
    const notifications = document.querySelectorAll('[id^="notification-"]');
    notifications.forEach(notification => {
        notification.addEventListener('click', function(e) {
            // Nếu click vào nút action (đã đọc/xóa) thì không làm gì thêm
            if (!e.target.closest('button') && !e.target.closest('a')) {
                const notificationId = this.id.replace('notification-', '');
                if (this.classList.contains('bg-blue-50')) {
                    markAsRead(notificationId);
                }
            }
        });
    });
});
</script>

<style>
[id^="notification-"] {
    cursor: pointer;
}
</style>
@endsection