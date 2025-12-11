@extends('layouts.admin')

@section('title', 'Quản lý Đơn ứng tuyển')
@section('breadcrumb', 'Applications')

@section('content')
    <div class="space-y-8" x-data="applicationManager()">

        <div
            class="relative bg-gradient-to-r from-purple-700 to-indigo-600 rounded-2xl shadow-lg p-8 text-white overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Quản lý Đơn ứng tuyển</h2>
                    <p class="text-indigo-100 text-lg opacity-90">Theo dõi và xét duyệt hồ sơ tình nguyện viên.</p>
                </div>
                <button onclick="openExportModal()"
                    class="bg-white text-indigo-600 px-5 py-2.5 rounded-xl font-bold shadow-lg hover:bg-indigo-50 transition flex items-center gap-2">
                    <i class="fas fa-file-export"></i> Xuất Excel
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-8">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80">Tổng đơn</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['total'] ?? 0) }}</div>
                </div>
                <div class="bg-yellow-500/20 backdrop-blur-sm border border-yellow-400/30 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80 text-yellow-100">Chờ duyệt</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['pending'] ?? 0) }}</div>
                </div>
                <div class="bg-blue-500/20 backdrop-blur-sm border border-blue-400/30 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80 text-blue-100">Đang xem xét</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['under_review'] ?? 0) }}</div>
                </div>
                <div class="bg-green-500/20 backdrop-blur-sm border border-green-400/30 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80 text-green-100">Đã nhận</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['accepted'] ?? 0) }}</div>
                </div>
                <div class="bg-red-500/20 backdrop-blur-sm border border-red-400/30 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80 text-red-100">Từ chối</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['rejected'] ?? 0) }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <form method="GET" action="{{ route('admin.applications.index') }}"
                class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-4 relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tìm theo tên ứng viên, email..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white transition">
                    <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                </div>

                <div class="md:col-span-2">
                    <select name="status"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white transition">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="Under Review" {{ request('status') == 'Under Review' ? 'selected' : '' }}>Đang xem xét
                        </option>
                        <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Đã nhận</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Từ chối</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select name="date_range"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white transition">
                        <option value="">Tất cả thời gian</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Hôm nay</option>
                        <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>Tuần này</option>
                        <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>Tháng này</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <input type="text" name="organization" value="{{ request('organization') }}"
                        placeholder="Tên tổ chức..."
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white transition">
                </div>

                <div class="md:col-span-2 flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition shadow-md">
                        Lọc
                    </button>
                    <a href="{{ route('admin.applications.index') }}"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        title="Reset">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Mã đơn</th>
                            <th class="px-6 py-4">Ứng viên</th>
                            <th class="px-6 py-4">Cơ hội & Tổ chức</th>
                            <th class="px-6 py-4 text-center">Trạng thái</th>
                            <th class="px-6 py-4 text-center">Ngày nộp</th>
                            <th class="px-6 py-4 text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($applications as $app)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                <td class="px-6 py-4 font-mono text-sm text-gray-500">
                                    #{{ $app->application_id }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $app->volunteer->avatar_url ? asset('storage/' . $app->volunteer->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($app->volunteer->first_name) }}"
                                            class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                                {{ $app->volunteer->first_name }} {{ $app->volunteer->last_name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $app->volunteer->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 max-w-xs">
                                    <div class="space-y-1">
                                        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 truncate"
                                            title="{{ $app->opportunity->title }}">
                                            {{ $app->opportunity->title }}
                                        </p>
                                        <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-building"></i>
                                            <span
                                                class="truncate">{{ $app->opportunity->organization->organization_name }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClass = match ($app->status) {
                                            'Pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            'Accepted' => 'bg-green-100 text-green-700 border-green-200',
                                            'Rejected' => 'bg-red-100 text-red-700 border-red-200',
                                            'Under Review' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'Withdrawn' => 'bg-gray-100 text-gray-700 border-gray-200',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
                                        $statusLabel = match ($app->status) {
                                            'Pending' => 'Chờ duyệt',
                                            'Accepted' => 'Đã nhận',
                                            'Rejected' => 'Từ chối',
                                            'Under Review' => 'Đang xem xét',
                                            'Withdrawn' => 'Đã rút',
                                            default => $app->status
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center text-sm text-gray-500">
                                    <div>{{ $app->applied_date->format('d/m/Y') }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $app->applied_date->diffForHumans() }}</div>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <button onclick="viewApplication({{ $app->application_id }})"
                                        class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                        title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                                            <i class="fas fa-inbox text-2xl text-gray-400"></i>
                                        </div>
                                        <p class="text-lg font-medium">Không tìm thấy đơn ứng tuyển nào</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($applications->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>

    <div id="exportModal"
        class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full transform transition-all scale-100">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Xuất dữ liệu Đơn</h3>
                <button onclick="closeExportModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Trạng thái</label>
                    <select id="exportStatus"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tất cả</option>
                        <option value="Pending">Chờ duyệt</option>
                        <option value="Accepted">Đã nhận</option>
                        <option value="Rejected">Từ chối</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Thời gian</label>
                    <select id="exportDateRange"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tất cả</option>
                        <option value="today">Hôm nay</option>
                        <option value="week">Tuần này</option>
                        <option value="month">Tháng này</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end gap-3">
                <button onclick="closeExportModal()"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Hủy</button>
                <button onclick="processExportAjax()" id="btnExportConfirm"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 shadow-md flex items-center">
                    <i class="fas fa-download mr-2"></i> Tải xuống
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // --- Application Details Logic ---
            function viewApplication(appId) {
                // Chuyển hướng sang trang chi tiết (hoặc có thể làm Modal chi tiết ở đây nếu muốn)
                window.location.href = `/admin/applications/${appId}`;
            }

            // --- Export Logic (AJAX) ---
            function openExportModal() {
                document.getElementById('exportModal').classList.remove('hidden');
            }

            function closeExportModal() {
                document.getElementById('exportModal').classList.add('hidden');
            }

            function processExportAjax() {
                const btn = document.getElementById('btnExportConfirm');
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Đang xử lý...';

                const status = document.getElementById('exportStatus').value;
                const dateRange = document.getElementById('exportDateRange').value;

                const params = new URLSearchParams();
                if (status) params.append('status', status);
                if (dateRange) params.append('date_range', dateRange);

                // Lấy thêm params từ URL hiện tại nếu đang search
                const currentParams = new URLSearchParams(window.location.search);
                if (currentParams.has('search')) params.append('search', currentParams.get('search'));
                if (currentParams.has('organization')) params.append('organization', currentParams.get('organization'));

                fetch(`{{ route('admin.applications.export') }}?${params.toString()}`, {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Lỗi xuất file');
                        return response.blob();
                    })
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `applications_export_${new Date().toISOString().slice(0, 10)}.xlsx`;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);

                        showToast('Xuất dữ liệu thành công!', 'success');
                        closeExportModal();
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Có lỗi xảy ra khi xuất file.', 'error');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    });
            }
        </script>
    @endpush
@endsection