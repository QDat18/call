@extends('layouts.admin')

@section('title', 'Quản lý Danh mục - Admin Dashboard')
@section('breadcrumb', 'Categories')

@section('content')
<div class="space-y-6" x-data="categoryManager()">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Quản lý Danh mục</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Phân loại và tổ chức các cơ hội tình nguyện.</p>
        </div>
        
        <div class="flex gap-3">
            <div class="relative">
                <input type="text" x-model="search" placeholder="Tìm kiếm danh mục..." 
                       class="pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white w-full md:w-64 transition shadow-sm">
                <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
            </div>
            <button @click="openModal('create')" 
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg transition transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fas fa-plus"></i> <span class="hidden sm:inline">Thêm mới</span>
            </button>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all duration-300 relative overflow-hidden"
             x-show="matchesSearch('{{ strtolower($category->category_name) }}')">
            
            <div class="absolute top-0 left-0 w-1 h-full transition-colors duration-300"
                 :class="{{ $category->is_active }} ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"></div>

            <div class="flex items-start justify-between mb-4 pl-3">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-inner transition-colors duration-300"
                     style="background-color: {{ $category->color ?? '#6366f1' }}15; color: {{ $category->color ?? '#6366f1' }}">
                    <i class="{{ $category->icon ?? 'fas fa-tag' }} text-2xl"></i>
                </div>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-xl shadow-xl border border-gray-100 dark:border-gray-600 z-10 py-1" style="display: none;">
                        <button @click="openModal('edit', {{ json_encode($category) }}); open = false" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 flex items-center gap-2">
                            <i class="fas fa-edit text-indigo-500"></i> Chỉnh sửa
                        </button>
                        <button @click="toggleStatus({{ $category->category_id }}); open = false" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 flex items-center gap-2">
                            <i class="fas fa-power-off {{ $category->is_active ? 'text-orange-500' : 'text-green-500' }}"></i> 
                            {{ $category->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }}
                        </button>
                        <div class="border-t border-gray-100 dark:border-gray-600 my-1"></div>
                        <button @click="deleteItem({{ $category->category_id }}); open = false" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2">
                            <i class="fas fa-trash-alt"></i> Xóa
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="pl-3">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1 group-hover:text-indigo-600 transition-colors">
                    {{ $category->category_name }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 min-h-[40px]">
                    {{ $category->description ?? 'Chưa có mô tả.' }}
                </p>
            </div>
            
            <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between pl-3 text-xs font-medium">
                {{-- [MỚI] Nút bấm xem danh sách cơ hội --}}
                <button @click="viewOpportunities({{ $category->category_id }}, '{{ $category->category_name }}')"
                        class="flex items-center gap-1.5 bg-gray-50 hover:bg-indigo-50 text-gray-500 hover:text-indigo-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300 transition px-2.5 py-1 rounded-lg cursor-pointer">
                    <i class="fas fa-briefcase"></i>
                    {{ $category->opportunities_count ?? 0 }} Cơ hội
                </button>

                <span class="{{ $category->is_active ? 'text-green-600 bg-green-50 dark:bg-green-900/20' : 'text-gray-500 bg-gray-100 dark:bg-gray-700' }} px-2.5 py-1 rounded-lg">
                    {{ $category->is_active ? 'Hoạt động' : 'Ẩn' }}
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-lg transform rounded-2xl bg-white dark:bg-gray-800 p-8 shadow-2xl transition-all">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white" x-text="mode === 'create' ? 'Thêm Danh mục mới' : 'Chỉnh sửa Danh mục'"></h3>
                    <button @click="closeModal()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
                </div>
                <form @submit.prevent="submitForm">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tên danh mục <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.category_name" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Mô tả</label>
                            <textarea x-model="form.description" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Icon Class</label>
                                <input type="text" x-model="form.icon" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="fas fa-tag">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Màu sắc</label>
                                <div class="flex items-center gap-3">
                                    <input type="color" x-model="form.color" class="h-11 w-14 p-1 border border-gray-300 rounded-lg cursor-pointer">
                                    <div class="flex-1 px-3 py-2.5 bg-gray-50 rounded-xl text-sm font-mono" x-text="form.color"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="form.is_active" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Kích hoạt</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="closeModal()" class="px-5 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50">Hủy</button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="isOppModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="isOppModalOpen = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-2xl transform rounded-2xl bg-white dark:bg-gray-800 p-0 shadow-2xl transition-all overflow-hidden flex flex-col max-h-[85vh]">
                
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            Danh sách Cơ hội
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Danh mục: <span class="font-semibold text-indigo-600" x-text="currentCategoryName"></span></p>
                    </div>
                    <button @click="isOppModalOpen = false" class="w-8 h-8 rounded-full bg-white dark:bg-gray-600 flex items-center justify-center text-gray-400 hover:text-gray-600 shadow-sm transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                    
                    <div x-show="isLoadingOpps" class="flex flex-col items-center justify-center py-10">
                        <div class="w-10 h-10 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
                        <p class="mt-3 text-sm text-gray-500">Đang tải dữ liệu...</p>
                    </div>

                    <div x-show="!isLoadingOpps && opportunities.length === 0" class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-folder-open text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Chưa có cơ hội nào thuộc danh mục này.</p>
                    </div>

                    <div x-show="!isLoadingOpps && opportunities.length > 0" class="space-y-3">
                        <template x-for="opp in opportunities" :key="opp.opportunity_id">
                            <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600 rounded-xl hover:shadow-md transition group">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 flex-shrink-0">
                                        <i class="fas fa-hand-holding-heart"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1" x-text="opp.title"></h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                <i class="fas fa-building text-[10px]"></i> <span x-text="opp.organization?.organization_name || 'Tổ chức ẩn'"></span>
                                            </p>
                                            <span class="text-[10px] px-2 py-0.5 rounded-full font-medium"
                                                  :class="opp.status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'"
                                                  x-text="opp.status"></span>
                                        </div>
                                    </div>
                                </div>
                                <a :href="`/admin/opportunities/${opp.opportunity_id}`" 
                                   class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition" target="_blank">
                                    Chi tiết
                                </a>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    <button @click="isOppModalOpen = false" class="px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 text-gray-700 dark:text-white text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function categoryManager() {
        return {
            search: '',
            isModalOpen: false, // Create/Edit Modal
            isOppModalOpen: false, // [MỚI] List Opps Modal
            mode: 'create',
            loading: false,
            isLoadingOpps: false, // [MỚI] Loading state for opps
            currentCategoryName: '', // [MỚI]
            opportunities: [], // [MỚI] Data container
            
            form: {
                category_id: null,
                category_name: '',
                description: '',
                icon: 'fas fa-tag',
                color: '#6366f1',
                display_order: 0,
                is_active: true
            },

            matchesSearch(name) {
                if (this.search === '') return true;
                return name.includes(this.search.toLowerCase());
            },

            resetForm() {
                this.form = { category_id: null, category_name: '', description: '', icon: 'fas fa-tag', color: '#6366f1', display_order: 0, is_active: true };
            },

            openModal(mode, category = null) {
                this.mode = mode;
                if (mode === 'edit' && category) {
                    this.form = { ...category, is_active: Boolean(category.is_active) };
                } else {
                    this.resetForm();
                }
                this.isModalOpen = true;
            },

            closeModal() {
                this.isModalOpen = false;
                setTimeout(() => this.resetForm(), 300);
            },

            // [MỚI] Hàm xem danh sách cơ hội
            async viewOpportunities(id, name) {
                this.currentCategoryName = name;
                this.isOppModalOpen = true;
                this.isLoadingOpps = true;
                this.opportunities = [];

                try {
                    const response = await fetch(`/admin/categories/${id}/opportunities`);
                    const result = await response.json();
                    
                    if (result.success) {
                        this.opportunities = result.data;
                    }
                } catch (error) {
                    console.error(error);
                    showToast('Không thể tải danh sách cơ hội', 'error');
                } finally {
                    this.isLoadingOpps = false;
                }
            },

            // Các hàm cũ (submitForm, deleteItem, toggleStatus) giữ nguyên
            async submitForm() {
                this.loading = true;
                const url = this.mode === 'create' ? '{{ route("admin.categories.store") }}' : `/admin/categories/${this.form.category_id}`;
                const method = this.mode === 'create' ? 'POST' : 'PUT';

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                        body: JSON.stringify(this.form)
                    });
                    const data = await response.json();
                    if (data.success) { showToast(data.message, 'success'); setTimeout(() => location.reload(), 1000); } 
                    else { showToast(data.message || 'Lỗi', 'error'); }
                } catch (e) { showToast('Lỗi kết nối', 'error'); } 
                finally { this.loading = false; }
            },

            async deleteItem(id) {
                if (!confirm('Xóa danh mục này?')) return;
                try {
                    await fetch(`/admin/categories/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } });
                    location.reload();
                } catch (e) { showToast('Lỗi xóa', 'error'); }
            },

            async toggleStatus(id) {
                try {
                    await fetch(`/admin/categories/${id}/toggle`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } });
                    location.reload();
                } catch (e) { showToast('Lỗi cập nhật', 'error'); }
            }
        }
    }
</script>
@endpush
@endsection