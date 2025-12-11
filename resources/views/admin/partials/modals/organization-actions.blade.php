<!-- File: resources/views/admin/partials/modals/organization-actions.blade.php -->

<!-- Approve Modal -->
<div id="approveModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Phê duyệt tổ chức</h3>
                    <p class="text-green-100 text-sm">Xác nhận xác thực tổ chức này</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
                <div class="flex">
                    <i class="fas fa-info-circle text-green-500 mt-0.5"></i>
                    <div class="ml-3">
                        <p class="text-sm text-green-800">
                            Sau khi phê duyệt, tổ chức sẽ có thể:
                        </p>
                        <ul class="text-sm text-green-700 mt-2 space-y-1 list-disc list-inside">
                            <li>Đăng các cơ hội tình nguyện</li>
                            <li>Quản lý tình nguyện viên</li>
                            <li>Nhận đánh giá từ cộng đồng</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <p class="text-gray-600 mb-4">Bạn có chắc chắn muốn phê duyệt tổ chức này không?</p>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 rounded-b-xl border-t">
            <button onclick="closeApproveModal()" 
                    class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium">
                <i class="fas fa-times mr-2"></i>Hủy
            </button>
            <button onclick="confirmApprove()" 
                    id="approveBtn"
                    class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-sm">
                <i class="fas fa-check mr-2"></i>Phê duyệt
            </button>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
        <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Từ chối tổ chức</h3>
                    <p class="text-red-100 text-sm">Không chấp nhận xác thực</p>
                </div>
            </div>
        </div>
        
        <form id="rejectForm" class="p-6">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
                    <p class="ml-3 text-sm text-red-800">
                        Tổ chức sẽ nhận được thông báo về việc từ chối này
                    </p>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Lý do từ chối <span class="text-red-500">*</span>
                </label>
                <textarea id="rejectReason" 
                          rows="4" 
                          required
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition resize-none"
                          placeholder="Nhập lý do từ chối xác thực..."></textarea>
            </div>
        </form>

        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 rounded-b-xl border-t">
            <button onclick="closeRejectModal()" 
                    class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium">
                <i class="fas fa-times mr-2"></i>Hủy
            </button>
            <button onclick="confirmReject()" 
                    id="rejectBtn"
                    class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium shadow-sm">
                <i class="fas fa-ban mr-2"></i>Từ chối
            </button>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all">
        <div class="bg-gradient-to-r from-red-600 to-rose-600 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-trash-alt text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Xóa tổ chức</h3>
                    <p class="text-red-100 text-sm">Hành động này không thể hoàn tác</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                <div class="flex">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-red-800 mb-1">Cảnh báo!</p>
                        <p class="text-sm text-red-700">
                            Xóa tổ chức sẽ đồng thời xóa:
                        </p>
                        <ul class="text-sm text-red-700 mt-2 space-y-1 list-disc list-inside">
                            <li>Tất cả cơ hội tình nguyện</li>
                            <li>Dữ liệu đơn đăng ký</li>
                            <li>Lịch sử hoạt động</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <p class="text-gray-600 font-medium">Bạn có chắc chắn muốn xóa tổ chức này không?</p>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 rounded-b-xl border-t">
            <button onclick="closeDeleteModal()" 
                    class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium">
                <i class="fas fa-times mr-2"></i>Hủy
            </button>
            <button onclick="confirmDelete()" 
                    id="deleteBtn"
                    class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium shadow-sm">
                <i class="fas fa-trash mr-2"></i>Xóa vĩnh viễn
            </button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="hidden fixed top-4 right-4 z-[60] transform transition-all duration-300">
    <div class="bg-white rounded-lg shadow-2xl border-l-4 p-4 min-w-[320px]" id="toastContent">
        <div class="flex items-center">
            <div class="flex-shrink-0" id="toastIcon"></div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-semibold" id="toastTitle"></p>
                <p class="text-sm mt-1" id="toastMessage"></p>
            </div>
            <button onclick="hideToast()" class="ml-4 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>

<script>
let currentOrgId = null;

// =========================
// APPROVE FUNCTIONS
// =========================
function openApproveModal(orgId) {
    currentOrgId = orgId;
    const modal = document.getElementById('approveModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeApproveModal() {
    const modal = document.getElementById('approveModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
    currentOrgId = null;
}

function confirmApprove() {
    const btn = document.getElementById('approveBtn');
    const originalHTML = btn.innerHTML;
    
    // Loading state
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang xử lý...';
    
    fetch(`/admin/organizations/${currentOrgId}/approve`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', 'Thành công!', data.message);
            closeApproveModal();
            
            // Reload page after 1.5s
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast('error', 'Lỗi!', data.message);
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Lỗi!', 'Có lỗi xảy ra khi phê duyệt');
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    });
}

// =========================
// REJECT FUNCTIONS
// =========================
function openRejectModal(orgId) {
    currentOrgId = orgId;
    const modal = document.getElementById('rejectModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
    document.getElementById('rejectReason').value = '';
    currentOrgId = null;
}

function confirmReject() {
    const reason = document.getElementById('rejectReason').value.trim();
    
    if (!reason) {
        showToast('warning', 'Cảnh báo!', 'Vui lòng nhập lý do từ chối');
        return;
    }
    
    const btn = document.getElementById('rejectBtn');
    const originalHTML = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang xử lý...';
    
    fetch(`/admin/organizations/${currentOrgId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', 'Thành công!', data.message);
            closeRejectModal();
            
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast('error', 'Lỗi!', data.message);
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Lỗi!', 'Có lỗi xảy ra khi từ chối');
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    });
}

// =========================
// DELETE FUNCTIONS
// =========================
function openDeleteModal(orgId) {
    currentOrgId = orgId;
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
    currentOrgId = null;
}

function confirmDelete() {
    const btn = document.getElementById('deleteBtn');
    const originalHTML = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang xóa...';
    
    fetch(`/admin/organizations/${currentOrgId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', 'Đã xóa!', data.message);
            closeDeleteModal();
            
            setTimeout(() => {
                window.location.href = '/admin/organizations';
            }, 1500);
        } else {
            showToast('error', 'Lỗi!', data.message);
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Lỗi!', 'Có lỗi xảy ra khi xóa');
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    });
}

// =========================
// TOAST NOTIFICATION
// =========================
function showToast(type, title, message) {
    const toast = document.getElementById('toast');
    const toastContent = document.getElementById('toastContent');
    const toastIcon = document.getElementById('toastIcon');
    const toastTitle = document.getElementById('toastTitle');
    const toastMessage = document.getElementById('toastMessage');
    
    // Reset classes
    toastContent.className = 'bg-white rounded-lg shadow-2xl border-l-4 p-4 min-w-[320px]';
    
    // Set type-specific styles
    const styles = {
        success: {
            borderColor: 'border-green-500',
            icon: '<div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center"><i class="fas fa-check-circle text-green-600 text-xl"></i></div>',
            titleColor: 'text-green-800'
        },
        error: {
            borderColor: 'border-red-500',
            icon: '<div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center"><i class="fas fa-times-circle text-red-600 text-xl"></i></div>',
            titleColor: 'text-red-800'
        },
        warning: {
            borderColor: 'border-yellow-500',
            icon: '<div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center"><i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i></div>',
            titleColor: 'text-yellow-800'
        },
        info: {
            borderColor: 'border-blue-500',
            icon: '<div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-info-circle text-blue-600 text-xl"></i></div>',
            titleColor: 'text-blue-800'
        }
    };
    
    const style = styles[type] || styles.info;
    
    toastContent.classList.add(style.borderColor);
    toastIcon.innerHTML = style.icon;
    toastTitle.textContent = title;
    toastTitle.className = `text-sm font-semibold ${style.titleColor}`;
    toastMessage.textContent = message;
    toastMessage.className = 'text-sm mt-1 text-gray-600';
    
    // Show toast
    toast.classList.remove('hidden');
    setTimeout(() => {
        toast.classList.add('translate-x-0');
    }, 10);
    
    // Auto hide after 5s
    setTimeout(() => {
        hideToast();
    }, 5000);
}

function hideToast() {
    const toast = document.getElementById('toast');
    toast.classList.add('translate-x-full');
    setTimeout(() => {
        toast.classList.add('hidden');
        toast.classList.remove('translate-x-full', 'translate-x-0');
    }, 300);
}

// Close modals on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeApproveModal();
        closeRejectModal();
        closeDeleteModal();
    }
});
</script>

<style>
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

#toast.flex {
    animation: slideInRight 0.3s ease-out;
}

.modal-backdrop {
    backdrop-filter: blur(4px);
}
</style>