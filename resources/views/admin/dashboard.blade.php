@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="space-y-8">

        <div
            class="relative bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl shadow-xl p-8 text-white overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Xin chào Admin! 👋</h2>
                    {{-- [MỚI] Hiển thị thứ, ngày tháng năm --}}
                    <p class="text-indigo-100 text-lg opacity-90 flex items-center gap-2">
                        <i class="far fa-clock"></i>
                        <span id="live-clock" class="capitalize">
                            {{-- Fallback nếu JS chưa chạy: Hiển thị giờ server hiện tại --}}
                            {{ \Carbon\Carbon::now()->locale('vi')->translatedFormat('l, d/m/Y - H:i:s') }}
                        </span>
                    </p>
                </div>
                <div class="flex gap-3">
                    <button onclick="openEmailModal('all')"
                        class="bg-white text-indigo-700 px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:bg-indigo-50 transition flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i> Gửi Thông Báo
                    </button>
                    <a href="{{ route('admin.analytics.index') }}"
                        class="bg-indigo-800/50 backdrop-blur-md text-white px-5 py-2.5 rounded-xl font-semibold border border-indigo-400/30 hover:bg-indigo-800/70 transition flex items-center gap-2">
                        <i class="fas fa-chart-pie"></i> Xem Báo Cáo
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Thành viên</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_users'] ?? 0) }}
                        </h3>
                        <div class="mt-2 text-sm text-green-600 bg-green-50 px-2 py-1 rounded-lg w-fit">
                            <i class="fas fa-arrow-up mr-1"></i> +{{ $stats['new_users_this_month'] ?? 0 }} tháng này
                        </div>
                    </div>
                    <div
                        class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tổ chức</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_orgs'] ?? 0) }}
                        </h3>
                        @if(($stats['pending_verifications'] ?? 0) > 0)
                            <a href="{{ route('admin.organizations.index', ['status' => 'Pending']) }}"
                                class="mt-2 flex items-center text-sm text-amber-600 bg-amber-50 px-2 py-1 rounded-lg w-fit hover:bg-amber-100 transition">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $stats['pending_verifications'] }} chờ duyệt
                            </a>
                        @else
                            <div class="mt-2 text-sm text-gray-500 bg-gray-50 px-2 py-1 rounded-lg w-fit">
                                <i class="fas fa-check-circle mr-1"></i> Đã duyệt hết
                            </div>
                        @endif
                    </div>
                    <div
                        class="p-3 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition">
                        <i class="fas fa-building text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Cơ hội</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">
                            {{ number_format($stats['active_opportunities'] ?? 0) }}
                        </h3>
                        <div class="mt-2 text-sm text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg w-fit">
                            {{ $stats['upcoming'] ?? 0 }} sắp diễn ra
                        </div>
                    </div>
                    <div
                        class="p-3 bg-green-50 text-green-600 rounded-xl group-hover:bg-green-600 group-hover:text-white transition">
                        <i class="fas fa-hand-holding-heart text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Đơn đăng ký</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">
                            {{ number_format($stats['total_applications'] ?? 0) }}
                        </h3>
                        <div class="mt-2 text-sm text-gray-600 bg-gray-50 px-2 py-1 rounded-lg w-fit">
                            {{ $stats['pending_applications'] ?? 0 }} đang xử lý
                        </div>
                    </div>
                    <div
                        class="p-3 bg-orange-50 text-orange-600 rounded-xl group-hover:bg-orange-600 group-hover:text-white transition">
                        <i class="fas fa-file-signature text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Bài đăng cộng đồng</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_posts'] ?? 0) }}
                        </h3>
                        @if(($stats['pending_posts'] ?? 0) > 0)
                            <a href="{{ route('admin.posts.index', ['status' => 'Pending']) }}"
                                class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-2 py-1 rounded-lg w-fit hover:bg-red-100 transition">
                                <i class="fas fa-shield-alt mr-1"></i> {{ $stats['pending_posts'] }} cần duyệt
                            </a>
                        @else
                            <a href="{{ route('admin.posts.index') }}"
                                class="mt-2 flex items-center text-sm text-gray-500 bg-gray-50 px-2 py-1 rounded-lg w-fit hover:bg-gray-100">
                                <i class="fas fa-list mr-1"></i> Quản lý
                            </a>
                        @endif
                    </div>
                    <div
                        class="p-3 bg-pink-50 text-pink-600 rounded-xl group-hover:bg-pink-600 group-hover:text-white transition">
                        <i class="fas fa-newspaper text-xl"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                {{-- Biểu đồ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Tăng trưởng thành viên (7 ngày qua)</h3>
                    <div class="h-80"><canvas id="userGrowthChart"></canvas></div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Thành viên mới tham gia</h3>
                        <a href="{{ route('admin.users.index') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Xem tất cả</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Thành viên</th>
                                    <th class="px-6 py-3 font-semibold">Vai trò</th>
                                    <th class="px-6 py-3 font-semibold">Ngày tham gia</th>
                                    <th class="px-6 py-3 font-semibold text-right">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentUsers ?? [] as $user)
                                                        <tr class="hover:bg-gray-50 transition">
                                                            <td class="px-6 py-4">
                                                                <div class="flex items-center gap-3">
                                                                    @php
                                                                        $avatar = $user->avatar_url
                                                                            ? asset('storage/' . $user->avatar_url)
                                                                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) . '&background=random';
                                                                    @endphp
                                                                    <img src="{{ $avatar }}"
                                                                        class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                                                    <div>
                                                                        <p class="font-semibold text-gray-900">{{ $user->first_name }}
                                                                            {{ $user->last_name }}
                                                                        </p>
                                                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <span
                                                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                                                                                    {{ $user->user_type == 'Volunteer' ? 'bg-blue-100 text-blue-700' :
                                    ($user->user_type == 'Organization' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700') }}">
                                                                    {{ $user->user_type }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                                {{-- [MỚI] Format ngày tháng đẹp --}}
                                                                <div class="font-medium">{{ $user->created_at->format('d/m/Y') }}</div>
                                                                <div class="text-xs text-gray-400">{{ $user->created_at->format('H:i') }}</div>
                                                            </td>
                                                            <td class="px-6 py-4 text-right">
                                                                <button onclick="openEmailModal('single', {{ $user->user_id }})"
                                                                    class="text-gray-400 hover:text-indigo-600 transition" title="Gửi Email">
                                                                    <i class="fas fa-envelope"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Chưa có thành viên mới.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-8">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-amber-50">
                        <h3 class="font-bold text-amber-800 flex items-center gap-2">
                            <i class="fas fa-clipboard-check"></i> Duyệt Tổ Chức
                        </h3>
                        <span class="bg-white text-amber-600 px-2 py-0.5 rounded-md text-xs font-bold shadow-sm">
                            {{ $pendingOrgs->count() }}
                        </span>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($pendingOrgs as $org)
                            <div class="p-5 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold text-gray-900">{{ $org->organization_name }}</h4>
                                    {{-- [MỚI] Format ngày tháng --}}
                                    <span class="text-xs text-gray-400">{{ $org->created_at->format('d/m/Y') }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mb-3 line-clamp-1">{{ $org->organization_type }}</p>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.organizations.show', $org->org_id) }}"
                                        class="flex-1 text-center px-3 py-1.5 bg-white border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition">
                                        Xem
                                    </a>
                                    <button onclick="approveOrg('{{ $org->org_id }}')"
                                        class="flex-1 text-center px-3 py-1.5 bg-green-100 text-green-700 text-xs font-medium rounded-lg hover:bg-green-200 transition">
                                        Duyệt
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">
                                <i class="fas fa-check-circle text-4xl text-green-200 mb-3"></i>
                                <p class="text-sm">Không có yêu cầu nào.</p>
                            </div>
                        @endforelse
                    </div>
                    @if($pendingOrgs->count() > 0)
                        <div class="p-3 bg-gray-50 border-t border-gray-100 text-center">
                            <a href="{{ route('admin.organizations.index', ['status' => 'Pending']) }}"
                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                Xem tất cả yêu cầu &rarr;
                            </a>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-6">Trạng thái Đơn ứng tuyển</h3>
                    <div class="relative h-64">
                        <canvas id="applicationStatusChart"></canvas>
                    </div>
                </div>

                <div class="bg-indigo-900 rounded-2xl shadow-lg p-6 text-white">
                    <h3 class="font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-bolt text-yellow-400"></i> Tác vụ nhanh
                    </h3>
                    <div class="space-y-3">
                        <button onclick="openEmailModal('volunteers')"
                            class="w-full text-left px-4 py-3 bg-white/10 hover:bg-white/20 rounded-xl transition flex justify-between items-center group">
                            <span class="text-sm font-medium">Email cho Tình nguyện viên</span>
                            <i
                                class="fas fa-chevron-right text-xs opacity-50 group-hover:transform group-hover:translate-x-1 transition"></i>
                        </button>
                        <button onclick="openEmailModal('organizations')"
                            class="w-full text-left px-4 py-3 bg-white/10 hover:bg-white/20 rounded-xl transition flex justify-between items-center group">
                            <span class="text-sm font-medium">Email cho Tổ chức</span>
                            <i
                                class="fas fa-chevron-right text-xs opacity-50 group-hover:transform group-hover:translate-x-1 transition"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('admin.partials.email-modal')

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // --- 1. User Growth Chart ---
            const userCtx = document.getElementById('userGrowthChart').getContext('2d');
            let gradient = userCtx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)');
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

            new Chart(userCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['userGrowth']['labels']) !!},
                    datasets: [{
                        label: 'Người dùng mới',
                        data: {!! json_encode($chartData['userGrowth']['data']) !!},
                        borderColor: '#4F46E5',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4F46E5',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [2, 4], color: '#E5E7EB' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // --- 2. Application Status Chart ---
            new Chart(document.getElementById('applicationStatusChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Chờ duyệt', 'Đã nhận', 'Từ chối', 'Đang xem xét'],
                    datasets: [{
                        data: {!! json_encode($chartData['applicationStatus']) !!},
                        backgroundColor: ['#FBBF24', '#10B981', '#EF4444', '#3B82F6'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                    }
                }
            });

            // --- 3. Approve/Reject Org Logic ---
            function approveOrg(orgId) {
                if (!confirm('Bạn có chắc chắn muốn duyệt tổ chức này?')) return;

                fetch(`/admin/organizations/${orgId}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // 1. Hiện thông báo thành công
                            showToast('Đã duyệt tổ chức thành công!', 'success');

                            // 2. Đợi 1.5 giây để người dùng kịp nhìn thấy thông báo rồi mới reload
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showToast(data.message || 'Có lỗi xảy ra', 'error');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        showToast('Lỗi kết nối đến máy chủ', 'error');
                    });
            }

            function rejectOrg(orgId) {
                let reason = prompt("Vui lòng nhập lý do từ chối:");
                if (reason === null) return; // Người dùng ấn Cancel
                if (reason.trim() === "") {
                    showToast('Lý do không được để trống', 'warning');
                    return;
                }

                fetch(`/admin/organizations/${orgId}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ rejection_reason: reason })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Đã từ chối tổ chức!', 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showToast(data.message || 'Lỗi xử lý', 'error');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        showToast('Lỗi hệ thống', 'error');
                    });
            }

            function updateClock() {
                const now = new Date();

                // Cấu hình định dạng tiếng Việt
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false // Dùng định dạng 24h
                };

                // Sử dụng Intl để format chuẩn tiếng Việt (ví dụ: Thứ Năm, 11/12/2025 13:25:00)
                let timeString = new Intl.DateTimeFormat('vi-VN', options).format(now);

                // Tùy chỉnh lại chuỗi nếu muốn thêm dấu gạch ngang (-) giữa ngày và giờ cho đẹp
                // Mặc định Intl trả về: "Thứ Năm, 11/12/2025 13:25:00"
                // Ta có thể thay thế khoảng trắng trước giờ bằng dấu " - "
                // timeString = timeString.replace(' ', ' - '); 

                document.getElementById('live-clock').textContent = timeString;
            }

            // Chạy hàm ngay lập tức
            updateClock();

            // Cập nhật mỗi giây (1000ms)
            setInterval(updateClock, 1000);
        </script>
    @endpush
@endsection