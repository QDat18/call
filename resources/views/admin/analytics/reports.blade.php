@extends('layouts.admin')

@section('title', 'Xuất Báo Cáo Tùy Chỉnh')
@section('breadcrumb', 'Analytics / Reports')

@section('content')
<div class="space-y-8" x-data="reportManager()">

    <div class="relative bg-gradient-to-r from-purple-700 to-indigo-600 rounded-2xl shadow-lg p-8 text-white overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-2">Trung tâm Báo cáo</h2>
            <p class="text-indigo-100 text-lg opacity-90 max-w-2xl">
                Tạo và tải xuống các báo cáo chi tiết về người dùng, hoạt động tình nguyện và hiệu suất hệ thống.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 flex items-center justify-center">
                        <i class="fas fa-layer-group text-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Bộ lọc Báo cáo</h3>
                </div>
                
                <form action="{{ route('admin.analytics.custom-report') }}" method="POST" id="reportForm" @submit="isLoading = true">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Loại dữ liệu <span class="text-red-500">*</span></label>
                            <select name="report_type" x-model="type" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">
                                <option value="" disabled selected>Chọn loại báo cáo...</option>
                                <option value="users">Người dùng (Users)</option>
                                <option value="opportunities">Cơ hội (Opportunities)</option>
                                <option value="applications">Đơn đăng ký (Applications)</option>
                                <option value="activities">Hoạt động (Activities)</option>
                                <option value="organizations">Tổ chức (Organizations)</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Từ ngày <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" x-model="startDate" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Đến ngày <span class="text-red-500">*</span></label>
                            <input type="date" name="end_date" x-model="endDate" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Định dạng xuất <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex items-center justify-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                                       :class="format === 'excel' ? 'border-green-500 bg-green-50 dark:bg-green-900/20 ring-1 ring-green-500' : 'border-gray-300 dark:border-gray-600'">
                                    <input type="radio" name="format" value="excel" class="sr-only" x-model="format">
                                    <div class="text-center">
                                        <i class="fas fa-file-excel text-2xl text-green-600 mb-1"></i>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Excel (.xlsx)</p>
                                    </div>
                                </label>
                                
                                <label class="relative flex items-center justify-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                                       :class="format === 'csv' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 ring-1 ring-blue-500' : 'border-gray-300 dark:border-gray-600'">
                                    <input type="radio" name="format" value="csv" class="sr-only" x-model="format">
                                    <div class="text-center">
                                        <i class="fas fa-file-csv text-2xl text-blue-600 mb-1"></i>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">CSV</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="type" x-transition class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                        <div class="text-sm text-blue-800 dark:text-blue-200">
                            <p class="font-bold mb-1">Dữ liệu bao gồm:</p>
                            <ul class="list-disc list-inside space-y-1 opacity-90" x-html="getReportDescription()"></ul>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" @click="resetForm()" 
                                class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Đặt lại
                        </button>
                        <button type="submit" :disabled="isLoading"
                                class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 transition flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                            <i class="fas fa-spinner fa-spin" x-show="isLoading"></i>
                            <i class="fas fa-download" x-show="!isLoading"></i>
                            <span>Tải Báo Cáo</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="space-y-6">
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Báo cáo nhanh (30 ngày)</h3>
                <div class="space-y-3">
                    <button @click="quickExport('users')" class="w-full flex items-center justify-between p-3 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200 group-hover:text-indigo-700 dark:group-hover:text-indigo-300">Tăng trưởng người dùng</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </button>

                    <button @click="quickExport('activities')" class="w-full flex items-center justify-between p-3 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-green-500 hover:bg-green-50 dark:hover:bg-green-900/20 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                                <i class="fas fa-clock"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200 group-hover:text-green-700 dark:group-hover:text-green-300">Hoạt động tình nguyện</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </button>

                    <button @click="quickExport('applications')" class="w-full flex items-center justify-between p-3 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200 group-hover:text-purple-700 dark:group-hover:text-purple-300">Thống kê đơn đăng ký</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    </button>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                <h4 class="font-bold text-gray-800 dark:text-white mb-2 flex items-center gap-2">
                    <i class="fas fa-question-circle text-gray-400"></i> Lưu ý
                </h4>
                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-2 list-disc list-inside">
                    <li>Định dạng Excel hỗ trợ lọc và sắp xếp tốt hơn.</li>
                    <li>Nếu dữ liệu quá lớn, quá trình tải có thể mất vài phút.</li>
                    <li>Hãy chọn khoảng thời gian cụ thể để tối ưu tốc độ.</li>
                </ul>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    function reportManager() {
        return {
            type: '',
            startDate: '',
            endDate: new Date().toISOString().split('T')[0], // Hôm nay
            format: 'excel',
            isLoading: false,

            init() {
                // Mặc định Start Date là 30 ngày trước
                const d = new Date();
                d.setDate(d.getDate() - 30);
                this.startDate = d.toISOString().split('T')[0];
            },

            resetForm() {
                this.type = '';
                this.format = 'excel';
                this.init(); // Reset dates
            },

            // Nội dung mô tả động dựa theo loại báo cáo
            getReportDescription() {
                const map = {
                    'users': '<li>ID, Họ tên, Email, SĐT</li><li>Vai trò, Trạng thái tài khoản</li><li>Ngày tham gia</li>',
                    'opportunities': '<li>Tiêu đề, Tổ chức, Lĩnh vực</li><li>Địa điểm, Trạng thái</li><li>Số lượng cần tuyển vs Đã tuyển</li>',
                    'applications': '<li>Thông tin Ứng viên</li><li>Cơ hội ứng tuyển</li><li>Trạng thái đơn, Ngày nộp</li>',
                    'activities': '<li>Tên Tình nguyện viên, Cơ hội</li><li>Số giờ làm, Ngày thực hiện</li><li>Người xác nhận</li>',
                    'organizations': '<li>Tên tổ chức, Loại hình</li><li>Email, SĐT liên hệ</li><li>Trạng thái xác thực, Đánh giá</li>'
                };
                return map[this.type] || '<li>Vui lòng chọn loại báo cáo để xem chi tiết.</li>';
            },

            // Xử lý nút Quick Export
            quickExport(reportType) {
                this.type = reportType;
                this.init(); // Reset date về 30 ngày
                this.format = 'excel';
                
                // Cuộn mượt lên form để người dùng bấm nút tải
                document.getElementById('reportForm').scrollIntoView({ behavior: 'smooth' });
                
                // Hiệu ứng highlight form
                setTimeout(() => {
                    document.getElementById('reportForm').classList.add('ring-2', 'ring-indigo-500', 'ring-offset-2');
                    setTimeout(() => {
                        document.getElementById('reportForm').classList.remove('ring-2', 'ring-indigo-500', 'ring-offset-2');
                    }, 1000);
                }, 500);
            }
        }
    }
</script>
@endpush
@endsection