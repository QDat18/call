@extends('layouts.admin') {{-- Hoặc layouts.app tùy cấu trúc admin của bạn --}}

@section('title', 'Quản Lý Bài Đăng')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Quản Lý Bài Đăng</h1>
                <p class="text-gray-600 mt-1">Kiểm duyệt và quản lý nội dung cộng đồng</p>
            </div>

            <div class="flex gap-2">
                {{-- [MỚI] Nút Báo cáo vi phạm --}}
                @php
                    // Đếm số lượng báo cáo chưa xử lý ngay tại View
                    $pendingReports = \App\Models\Report::where('target_type', 'post')->where('status', 'Pending')->count();
                @endphp

                <a href="{{ route('admin.posts.reports.index') }}"
                    class="px-4 py-2 bg-red-50 border border-red-200 text-red-700 rounded-lg hover:bg-red-100 transition font-medium flex items-center gap-2">
                    <i class="fas fa-flag"></i> Báo cáo

                    @if($pendingReports > 0)
                        <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">
                            {{ $pendingReports }}
                        </span>
                    @endif
                </a>

                {{-- Nút Chờ duyệt (Cũ) --}}
                <a href="{{ route('admin.posts.pending') }}"
                    class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 transition font-medium flex items-center gap-2">
                    <i class="fas fa-hourglass-half"></i> Chờ duyệt
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-200">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2 relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tìm theo nội dung, tên tác giả..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <div>
                    <select name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        onchange="this.form.submit()">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Published" {{ request('status') == 'Published' ? 'selected' : '' }}>Đã đăng (Published)
                        </option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Chờ duyệt (Pending)
                        </option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Đã từ chối (Rejected)
                        </option>
                    </select>
                </div>

                <div>
                    <a href="{{ route('admin.posts.index') }}"
                        class="flex items-center justify-center w-full px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                        <i class="fas fa-undo mr-2"></i> Đặt lại
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4 text-left">Bài viết</th>
                            <th class="px-6 py-4 text-left">Tác giả</th>
                            <th class="px-6 py-4 text-center">Thống kê</th>
                            <th class="px-6 py-4 text-center">Trạng thái</th>
                            <th class="px-6 py-4 text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($posts as $post)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col max-w-md">
                                        <div class="flex items-center gap-2 mb-1">
                                            @if($post->is_pinned)
                                                <span
                                                    class="bg-indigo-100 text-indigo-700 text-[10px] px-2 py-0.5 rounded-full font-bold">
                                                    <i class="fas fa-thumbtack mr-1"></i> GHIM
                                                </span>
                                            @endif
                                            <span class="text-sm font-bold text-gray-800 truncate" title="{{ $post->title }}">
                                                {{ $post->title ?? 'Không tiêu đề' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 truncate mb-2">
                                            {{ Str::limit($post->content, 60) }}
                                        </p>

                                        {{-- Hiển thị ảnh nhỏ nếu có --}}
                                        @if($post->media && $post->media->count() > 0)
                                            <div class="flex gap-1">
                                                @foreach($post->media->take(3) as $media)
                                                    <img src="{{ asset('storage/' . $media->file_path) }}"
                                                        class="w-8 h-8 rounded object-cover border">
                                                @endforeach
                                                @if($post->media->count() > 3)
                                                    <span class="text-xs text-gray-400 self-end">+{{ $post->media->count() - 3 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                        <span
                                            class="text-[10px] text-gray-400 mt-1">{{ $post->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $post->user->avatar_url ? asset('storage/' . $post->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->first_name) }}"
                                            class="w-8 h-8 rounded-full object-cover">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $post->user->first_name }}
                                                {{ $post->user->last_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $post->user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-3 text-sm">
                                        <div class="flex flex-col items-center" title="Lượt thích">
                                            <i class="fas fa-heart text-red-400 mb-1"></i>
                                            <span class="font-medium">{{ $post->likes_count }}</span>
                                        </div>
                                        <div class="flex flex-col items-center" title="Bình luận">
                                            <i class="fas fa-comment text-blue-400 mb-1"></i>
                                            <span class="font-medium">{{ $post->comments_count }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($post->status == 'Published')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                            Đã đăng
                                        </span>
                                    @elseif($post->status == 'Pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                                            Chờ duyệt
                                        </span>
                                    @elseif($post->status == 'Rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                            Từ chối
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Nút Duyệt/Từ chối cho bài Pending --}}
                                        @if($post->status == 'Pending')
                                            <form action="{{ route('admin.posts.approve', $post->post_id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition"
                                                    title="Duyệt">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.posts.reject', $post->post_id) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Bạn chắc chắn muốn từ chối bài này?')">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition"
                                                    title="Từ chối">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Nút Xem chi tiết --}}
                                        <a href="{{ route('posts.show', $post->post_id) }}" target="_blank"
                                            class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition"
                                            title="Xem chi tiết">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        {{-- Dropdown cho hành động khác --}}
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open"
                                                class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div x-show="open" @click.away="open = false"
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50 py-1"
                                                style="display: none;">

                                                {{-- Nút Ghim --}}
                                                <form action="{{ route('admin.posts.pin', $post->post_id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition flex items-center">
                                                        <i class="fas fa-thumbtack w-5"></i>
                                                        {{ $post->is_pinned ? 'Bỏ ghim' : 'Ghim bài' }}
                                                    </button>
                                                </form>

                                                {{-- Nút Xóa --}}
                                                <div class="border-t border-gray-100 my-1"></div>
                                                <form action="{{ route('admin.posts.force-delete', $post->post_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('CẢNH BÁO: Hành động này không thể hoàn tác. Bạn chắc chắn muốn xóa?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition flex items-center">
                                                        <i class="fas fa-trash-alt w-5"></i> Xóa vĩnh viễn
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                    <p>Không tìm thấy bài đăng nào phù hợp.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection