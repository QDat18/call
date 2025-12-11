@extends('layouts.app')

@section('title', 'Thông Báo')

@push('styles')
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .dark .glass-card {
            background: rgba(31, 41, 55, 0.9);
            border: 1px solid rgba(55, 65, 81, 0.5);
        }

        .hover-scale {
            transition: transform 0.2s;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 pb-12">

        <div
            class="bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-800 pb-24 pt-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-white">
                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl flex items-center gap-3">
                        <i class="fas fa-bell animate-pulse"></i> Thông Báo
                    </h1>
                    <p class="mt-2 text-lg text-indigo-100">Cập nhật tin tức mới nhất từ cộng đồng</p>
                </div>

                <div class="flex gap-3">
                    <button onclick="markAllAsRead()"
                        class="px-5 py-2.5 bg-white/20 hover:bg-white/30 text-white backdrop-blur-sm border border-white/30 rounded-xl font-medium transition flex items-center gap-2 shadow-lg">
                        <i class="fas fa-check-double"></i> <span class="hidden sm:inline">Đánh dấu tất cả đã đọc</span>
                    </button>
                    <button onclick="deleteAllRead()"
                        class="px-5 py-2.5 bg-red-500/80 hover:bg-red-600/90 text-white backdrop-blur-sm rounded-xl font-medium transition flex items-center gap-2 shadow-lg">
                        <i class="fas fa-trash-alt"></i> <span class="hidden sm:inline">Xóa đã đọc</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-5 flex items-center justify-between border-l-4 border-indigo-500 hover-scale">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Tổng số</p>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $stats['total'] }}</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xl">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-5 flex items-center justify-between border-l-4 border-orange-500 hover-scale">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Chưa đọc</p>
                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['unread'] }}</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-orange-100 dark:bg-orange-900/50 rounded-xl flex items-center justify-center text-orange-600 dark:text-orange-400 text-xl">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-5 flex items-center justify-between border-l-4 border-red-500 hover-scale">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Quan trọng
                        </p>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $stats['high_priority'] }}</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-red-100 dark:bg-red-900/50 rounded-xl flex items-center justify-center text-red-600 dark:text-red-400 text-xl">
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-5 flex items-center justify-between border-l-4 border-green-500 hover-scale">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Hôm nay</p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['today'] }}</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900/50 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 text-xl">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    <form method="GET" action="{{ route('notifications.index') }}"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                <i class="fas fa-filter"></i>
                            </span>
                            <select name="type"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 transition shadow-sm appearance-none cursor-pointer"
                                onchange="this.form.submit()">
                                <option value="">Tất cả loại</option>
                                <option value="Application" {{ request('type') == 'Application' ? 'selected' : '' }}>Đơn đăng
                                    ký</option>
                                <option value="Message" {{ request('type') == 'Message' ? 'selected' : '' }}>Tin nhắn</option>
                                <option value="System" {{ request('type') == 'System' ? 'selected' : '' }}>Hệ thống</option>
                                <option value="Review" {{ request('type') == 'Review' ? 'selected' : '' }}>Đánh giá</option>
                            </select>
                        </div>

                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                <i class="fas fa-eye"></i>
                            </span>
                            <select name="status"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 transition shadow-sm appearance-none cursor-pointer"
                                onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái</option>
                                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Chưa đọc</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Đã đọc</option>
                            </select>
                        </div>

                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                <i class="fas fa-flag"></i>
                            </span>
                            <select name="priority"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 transition shadow-sm appearance-none cursor-pointer"
                                onchange="this.form.submit()">
                                <option value="">Mọi mức độ ưu tiên</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Cao</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Trung bình
                                </option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Thấp</option>
                            </select>
                        </div>

                        <a href="{{ route('notifications.index') }}"
                            class="flex items-center justify-center w-full px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium shadow-sm">
                            <i class="fas fa-undo-alt mr-2"></i> Đặt lại
                        </a>
                    </form>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($notifications as $notification)
                                <div
                                    class="group p-5 hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-200 relative {{ !$notification->is_read ? 'bg-blue-50/60 dark:bg-blue-900/10' : '' }}">

                                    {{-- Chỉ báo chưa đọc (dải màu bên trái) --}}
                                    @if(!$notification->is_read)
                                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500 rounded-r"></div>
                                    @endif

                                    <div class="flex items-start gap-5">
                                        <div class="flex-shrink-0 relative">
                                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-sm text-2xl
                                                {{ $notification->notification_type == 'Application' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400' :
                        ($notification->notification_type == 'Message' ? 'bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-400' :
                            ($notification->notification_type == 'Video Call' ? 'bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400' :
                                ($notification->priority == 'high' ? 'bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400' :
                                    'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'))) }}">
                                                <i class="fas {{ 
                                                    $notification->notification_type == 'Application' ? 'fa-file-signature' :
                        ($notification->notification_type == 'Message' ? 'fa-comment-dots' :
                            ($notification->notification_type == 'Video Call' ? 'fa-video' :
                                ($notification->notification_type == 'System' ? 'fa-bell' :
                                    'fa-info-circle')))
                                                }}"></i>
                                            </div>
                                            @if(!$notification->is_read)
                                                <span
                                                    class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 border-2 border-white dark:border-gray-800 rounded-full animate-pulse"></span>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0 pt-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 transition cursor-pointer"
                                                        onclick="markAsRead({{ $notification->notification_id }})">
                                                        {{ $notification->title }}
                                                    </h3>
                                                    <p
                                                        class="text-gray-600 dark:text-gray-400 mt-1 line-clamp-2 text-sm leading-relaxed">
                                                        {{ $notification->content }}
                                                    </p>
                                                </div>
                                                <div class="text-right flex-shrink-0 ml-4">
                                                    <span
                                                        class="text-xs font-medium text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div
                                                class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                                                <div class="flex items-center gap-3">
                                                    @if($notification->priority == 'high')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                            <i class="fas fa-fire mr-1"></i> Quan trọng
                                                        </span>
                                                    @endif
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                        {{ $notification->notification_type }}
                                                    </span>
                                                </div>

                                                <div
                                                    class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    @if($notification->action_url)
                                                        <a href="{{ $notification->action_url }}"
                                                            onclick="markAsRead({{ $notification->notification_id }})"
                                                            class="p-2 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 rounded-lg transition"
                                                            title="Xem chi tiết">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    @endif

                                                    @if(!$notification->is_read)
                                                        <button onclick="markAsRead({{ $notification->notification_id }})"
                                                            class="p-2 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/50 rounded-lg transition"
                                                            title="Đánh dấu đã đọc">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif

                                                    <button onclick="deleteNotification({{ $notification->notification_id }})"
                                                        class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/50 rounded-lg transition"
                                                        title="Xóa thông báo">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @empty
                        <div class="py-16 text-center">
                            <div
                                class="w-24 h-24 bg-gray-100 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-bell-slash text-4xl text-gray-300 dark:text-gray-500"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Không có thông báo mới</h3>
                            <p class="text-gray-500 dark:text-gray-400">Bạn đã xem hết tất cả thông báo rồi!</p>
                        </div>
                    @endforelse
                </div>

                @if($notifications->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            async function markAsRead(notificationId) {
                try {
                    const response = await fetch(`/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    });
                    // Nếu có action_url, controller sẽ redirect, fetch có thể follow redirect
                    // Nếu muốn xử lý chuyển trang mượt mà bằng JS:
                    const data = await response.json().catch(() => ({}));
                    // Nếu controller trả về redirect thì response.redirected = true
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else if (data.success) {
                        location.reload();
                    } else {
                        location.reload(); // Fallback
                    }
                } catch (error) {
                    console.error(error);
                    // location.reload();
                }
            }
            async function markAllAsRead() {
                if (!confirm('Mark all notifications as read?')) return;

                try {
                    const response = await fetch('/notifications/read-all', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        showToast('All notifications marked as read', 'success');
                        setTimeout(() => location.reload(), 500);
                    }
                } catch (error) {
                    showToast('Failed to mark all as read', 'error');
                }
            }

            async function deleteNotification(notificationId) {
                if (!confirm('Delete this notification?')) return;

                try {
                    const response = await fetch(`/notifications/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        showToast('Notification deleted', 'success');
                        setTimeout(() => location.reload(), 500);
                    }
                } catch (error) {
                    showToast('Failed to delete notification', 'error');
                }
            }

            async function deleteAllRead() {
                if (!confirm('Delete all read notifications? This action cannot be undone.')) return;

                try {
                    const response = await fetch('/notifications/delete-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        showToast(`Deleted ${data.count} notifications`, 'success');
                        setTimeout(() => location.reload(), 500);
                    }
                } catch (error) {
                    showToast('Failed to delete notifications', 'error');
                }
            }
        </script>
    @endpush
@endsection