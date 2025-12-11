@extends('layouts.admin')

@section('title', 'Quản lý Cơ hội')
@section('breadcrumb', 'Opportunities')

@section('content')
    <div class="space-y-8">

        {{-- 1. HEADER & THỐNG KÊ --}}
        <div class="relative bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl shadow-lg p-8 text-white overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Quản lý Cơ hội</h2>
                    <p class="text-indigo-100 text-lg opacity-90">Theo dõi và quản lý các chiến dịch tình nguyện.</p>
                </div>
                <button onclick="exportOpportunities()"
                    class="bg-white text-indigo-600 px-5 py-2.5 rounded-xl font-bold shadow-lg hover:bg-indigo-50 transition flex items-center gap-2">
                    <i class="fas fa-file-export"></i> Xuất Excel
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-8">
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80">Tổng số</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['total'] ?? 0) }}</div>
                </div>
                <div class="bg-green-500/20 backdrop-blur-sm border border-green-400/30 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80 text-green-100">Đang chạy</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['active'] ?? 0) }}</div>
                </div>
                <div class="bg-blue-500/20 backdrop-blur-sm border border-blue-400/30 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80 text-blue-100">Hoàn thành</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['completed'] ?? 0) }}</div>
                </div>
                <div class="bg-yellow-500/20 backdrop-blur-sm border border-yellow-400/30 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80 text-yellow-100">Tạm dừng</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['paused'] ?? 0) }}</div>
                </div>
                <div class="bg-red-500/20 backdrop-blur-sm border border-red-400/30 rounded-xl p-4 text-white">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-80 text-red-100">Đã hủy</div>
                    <div class="text-2xl font-bold mt-1">{{ number_format($stats['cancelled'] ?? 0) }}</div>
                </div>
            </div>
        </div>

        {{-- 2. FORM TÌM KIẾM & LỌC (AJAX) --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            {{-- ID: filterForm dùng để bắt sự kiện JS --}}
            <form id="filterForm" class="grid grid-cols-1 md:grid-cols-12 gap-4">

                <div class="md:col-span-4 relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tìm theo tên cơ hội, địa điểm..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                </div>

                <div class="md:col-span-2">
                    <select name="category"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tất cả Danh mục</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <select name="status"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tất cả Trạng thái</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Paused" {{ request('status') == 'Paused' ? 'selected' : '' }}>Paused</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <input type="text" name="organization" value="{{ request('organization') }}"
                        placeholder="Tên tổ chức..."
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="md:col-span-2 flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition shadow-md">
                        Lọc
                    </button>
                    <button type="button" onclick="resetFilter()"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                        title="Reset">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- 3. BẢNG DỮ LIỆU (AJAX CONTAINER) --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden relative">
            
            {{-- Loading Overlay --}}
            <div id="tableLoading" class="absolute inset-0 bg-white/70 dark:bg-gray-800/70 z-10 hidden flex items-center justify-center">
                <div class="flex flex-col items-center">
                    <i class="fas fa-circle-notch fa-spin text-4xl text-indigo-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-500">Đang xử lý...</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-xs uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Thông tin Cơ hội</th>
                            <th class="px-6 py-4">Tổ chức & Danh mục</th>
                            <th class="px-6 py-4 text-center">Trạng thái</th>
                            <th class="px-6 py-4 text-center">Thống kê</th>
                            <th class="px-6 py-4 text-center">Thời gian</th>
                            <th class="px-6 py-4 text-right">Hành động</th>
                        </tr>
                    </thead>
                    
                    {{-- ID: opportunitiesTableBody để replace nội dung AJAX --}}
                    <tbody id="opportunitiesTableBody" class="divide-y divide-gray-100 dark:divide-gray-700">
                        @include('admin.opportunities.partials.table', ['opportunities' => $opportunities])
                    </tbody>
                </table>
            </div>

            {{-- ID: paginationLinks để replace phân trang --}}
            <div id="paginationLinks" class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                @if($opportunities->hasPages())
                    {{ $opportunities->links() }}
                @endif
            </div>
        </div>

    </div>

    {{-- 4. MODALS --}}

    {{-- View Modal --}}
    <div id="viewModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all scale-100">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between sticky top-0 bg-white dark:bg-gray-800 z-10">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Chi tiết Cơ hội</h3>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="opportunityDetails" class="p-6 text-gray-700 dark:text-gray-300">
                {{-- Content inserted via JS --}}
            </div>
        </div>
    </div>

    {{-- Status Modal --}}
    <div id="statusModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-sm w-full">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Cập nhật Trạng thái</h3>
            </div>
            <form id="statusForm" class="p-6">
                <input type="hidden" id="statusOppId">

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Trạng thái mới</label>
                    <select id="newStatus" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="Active">Đang hoạt động (Active)</option>
                        <option value="Paused">Tạm dừng (Paused)</option>
                        <option value="Completed">Hoàn thành (Completed)</option>
                        <option value="Cancelled">Đã hủy (Cancelled)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        Hủy
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 shadow-md">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @push('scripts')
        <script>
            // --- GLOBAL CONFIG ---
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const requestHeaders = {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            };

            // ==========================================
            // A. AJAX SEARCH, FILTER & PAGINATION
            // ==========================================

            // 1. Submit Form Lọc
            document.getElementById('filterForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                // Convert to query string (e.g. ?search=abc&status=Active)
                const params = new URLSearchParams(formData).toString();
                const url = `{{ route('admin.opportunities.index') }}?${params}`;
                
                fetchData(url);
            });

            // 2. Click Phân Trang
            document.getElementById('paginationLinks').addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link) {
                    e.preventDefault();
                    fetchData(link.href);
                }
            });

            // 3. Reset Filter
            function resetFilter() {
                document.getElementById('filterForm').reset();
                fetchData('{{ route('admin.opportunities.index') }}');
            }

            // 4. Core AJAX Fetch Function
            function fetchData(url) {
                const loading = document.getElementById('tableLoading');
                const tbody = document.getElementById('opportunitiesTableBody');
                const pagination = document.getElementById('paginationLinks');

                // Show loading
                loading.classList.remove('hidden');

                fetch(url, { headers: requestHeaders })
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    // Update Table & Pagination HTML
                    tbody.innerHTML = data.html;
                    pagination.innerHTML = data.pagination;
                    
                    // Update Browser URL without reload
                    window.history.pushState(null, '', url);
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Lỗi', 'Không thể tải dữ liệu.', 'error');
                })
                .finally(() => {
                    loading.classList.add('hidden');
                });
            }


            // ==========================================
            // B. ACTIONS (VIEW, STATUS, DELETE)
            // ==========================================

            // --- 1. View Detail ---
            function viewOpportunity(oppId) {
                const detailsDiv = document.getElementById('opportunityDetails');
                const modal = document.getElementById('viewModal');
                
                // Show modal with loading state
                detailsDiv.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12">
                        <i class="fas fa-circle-notch fa-spin text-4xl text-indigo-600 mb-3"></i>
                        <p class="text-gray-500 font-medium">Đang tải thông tin...</p>
                    </div>`;
                modal.classList.remove('hidden');

                fetch(`/admin/opportunities/${oppId}`, { headers: requestHeaders })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) throw new Error(data.message);
                        const opp = data.opportunity;
                        
                        // Render UI
                        const categoryBadge = opp.category_info ? 
                            `<span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold border" style="background-color: ${opp.category_info.color}15; color: ${opp.category_info.color}; border-color: ${opp.category_info.color}40"><i class="${opp.category_info.icon} mr-1"></i> ${opp.category_info.name}</span>` 
                            : '<span class="text-gray-400 italic">Không có danh mục</span>';

                        const html = `
                            <div class="space-y-6 animate-fade-in-up">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">${opp.title}</h2>
                                        <div class="mt-2 flex items-center gap-3">
                                            ${categoryBadge}
                                            <span class="text-sm text-gray-500"><i class="far fa-clock mr-1"></i> Tạo ngày: ${new Date(opp.created_at).toLocaleDateString('vi-VN')}</span>
                                        </div>
                                    </div>
                                    <span class="px-4 py-2 text-sm font-bold rounded-xl bg-gray-100 dark:bg-gray-700 whitespace-nowrap border border-gray-200 shadow-sm">${opp.status}</span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold">
                                            ${opp.org_avatar ? `<img src="/storage/${opp.org_avatar}" class="w-full h-full rounded-full object-cover">` : '<i class="fas fa-building"></i>'}
                                        </div>
                                        <div>
                                            <p class="text-xs text-indigo-600 font-bold uppercase">Tổ chức</p>
                                            <p class="font-bold text-gray-900 dark:text-white">${opp.org_name}</p>
                                        </div>
                                    </div>
                                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-700"><i class="fas fa-users"></i></div>
                                        <div>
                                            <p class="text-xs text-emerald-600 font-bold uppercase">Tuyển dụng</p>
                                            <p class="font-bold text-gray-900 dark:text-white">${opp.volunteers_registered} / ${opp.volunteers_needed} TNV</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-100 pt-4">
                                    <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-2"><i class="fas fa-align-left text-indigo-500 mr-2"></i> Mô tả chi tiết</h4>
                                    <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 bg-white dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700 max-h-60 overflow-y-auto whitespace-pre-line">${opp.description || 'Chưa có mô tả.'}</div>
                                </div>

                                <div class="flex justify-end gap-3 pt-2">
                                    <a href="/opportunities/${opp.opportunity_id}" target="_blank" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg font-bold hover:bg-indigo-100 transition"><i class="fas fa-external-link-alt mr-1"></i> Xem trang Public</a>
                                    <button onclick="closeViewModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">Đóng</button>
                                </div>
                            </div>`;
                        detailsDiv.innerHTML = html;
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Lỗi', 'Không thể tải chi tiết.', 'error');
                        closeViewModal();
                    });
            }
            function closeViewModal() { document.getElementById('viewModal').classList.add('hidden'); }

            // --- 2. Update Status ---
            let currentStatusId = null;
            function changeStatus(oppId) {
                currentStatusId = oppId;
                document.getElementById('statusModal').classList.remove('hidden');
            }
            function closeStatusModal() { document.getElementById('statusModal').classList.add('hidden'); }

            document.getElementById('statusForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const newStatus = document.getElementById('newStatus').value;
                const btn = this.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;
                
                btn.disabled = true; btn.innerHTML = 'Đang lưu...';

                fetch(`/admin/opportunities/${currentStatusId}/status`, {
                    method: 'POST',
                    headers: requestHeaders,
                    body: JSON.stringify({ status: newStatus })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        closeStatusModal();
                        Swal.fire({
                            icon: 'success', title: 'Đã cập nhật!', text: 'Trạng thái đã được thay đổi.', 
                            timer: 1500, showConfirmButton: false
                        });
                        // Cập nhật dòng hiển thị mà không reload toàn bộ bảng
                        updateRowStatus(currentStatusId, newStatus);
                    } else {
                        Swal.fire('Lỗi', data.message || 'Lỗi hệ thống', 'error');
                    }
                })
                .catch(err => Swal.fire('Lỗi', 'Lỗi kết nối server', 'error'))
                .finally(() => { btn.disabled = false; btn.innerHTML = originalText; });
            });

            function updateRowStatus(id, status) {
                const row = document.getElementById(`row-${id}`);
                if (!row) return; // Nếu đang ở trang khác thì thôi
                
                const statusCell = row.cells[2];
                const statusClasses = {
                    'Active': 'bg-green-100 text-green-700 border-green-200',
                    'Paused': 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    'Completed': 'bg-blue-100 text-blue-700 border-blue-200',
                    'Cancelled': 'bg-red-100 text-red-700 border-red-200'
                };
                const newClass = statusClasses[status] || 'bg-gray-100 text-gray-700 border-gray-200';
                
                statusCell.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-bold border ${newClass} animate-pulse">${status}</span>`;
                setTimeout(() => {
                    const badge = statusCell.querySelector('span');
                    if(badge) badge.classList.remove('animate-pulse');
                }, 1000);
            }

            // --- 3. Delete ---
            function deleteOpportunity(oppId) {
                Swal.fire({
                    title: 'Xóa vĩnh viễn?', text: "Hành động này không thể hoàn tác!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Xóa', cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/opportunities/${oppId}`, { method: 'DELETE', headers: requestHeaders })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire('Đã xóa!', 'Dữ liệu đã bị xóa.', 'success');
                                const row = document.getElementById(`row-${oppId}`);
                                if(row) {
                                    row.style.transition = 'all 0.5s'; row.style.opacity = '0';
                                    setTimeout(() => row.remove(), 500);
                                } else { fetchData(window.location.href); } // Fallback reload
                            } else {
                                Swal.fire('Lỗi', data.message, 'error');
                            }
                        })
                        .catch(err => Swal.fire('Lỗi', 'Lỗi kết nối server', 'error'));
                    }
                });
            }

            // --- 4. Export ---
            function exportOpportunities() {
                window.location.href = '{{ route("admin.opportunities.export") }}';
            }

            // --- Close Modals on outside click ---
            window.onclick = function(event) {
                if (event.target == document.getElementById('viewModal')) closeViewModal();
                if (event.target == document.getElementById('statusModal')) closeStatusModal();
            }
        </script>

        <style>
            @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
            .animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }
        </style>
    @endpush
@endsection