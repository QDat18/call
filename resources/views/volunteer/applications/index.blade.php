@extends('layouts.volunteer')

@section('title', 'Quản Lý Hồ Sơ Ứng Tuyển')

@section('content')
<div class="min-h-screen bg-slate-50 relative pb-12">
    {{-- Decorative Background --}}
    <div class="absolute top-0 inset-x-0 h-64 bg-gradient-to-b from-indigo-100/40 to-slate-50 pointer-events-none"></div>

    <div class="relative max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm animate-bounce-short">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-800">Hồ Sơ Của Tôi</h1>
            <p class="text-slate-500 mt-1">Theo dõi tiến độ, tìm kiếm và quản lý các đơn ứng tuyển.</p>
        </div>
        
        {{-- TOOLBAR: TÌM KIẾM - LỌC - SẮP XẾP --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-6 sticky top-4 z-20 backdrop-blur-md bg-white/95">
            <form method="GET" action="{{ route('volunteer.applications.my') }}">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    
                    {{-- 1. Search Box (Chiếm 6 phần) --}}
                    <div class="md:col-span-6 relative group">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition outline-none"
                            placeholder="Nhập tên công việc hoặc tổ chức...">
                    </div>

                    {{-- 2. Status Filter (Chiếm 3 phần) --}}
                    <div class="md:col-span-3 relative">
                        <select name="status" onchange="this.form.submit()" 
                            class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-indigo-500 cursor-pointer appearance-none">
                            <option value="">Tất cả trạng thái</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>⏳ Đang chờ</option>
                            <option value="Under Review" {{ request('status') == 'Under Review' ? 'selected' : '' }}>👀 Đang xem xét</option>
                            <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>✅ Đã chấp nhận</option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>❌ Từ chối</option>
                        </select>
                        <i class="fas fa-filter absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>

                    {{-- 3. Sort Filter (Chiếm 3 phần) --}}
                    <div class="md:col-span-3 relative">
                        <select name="sort" onchange="this.form.submit()" 
                            class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-2 focus:ring-indigo-500 cursor-pointer appearance-none">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất trước</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất trước</option>
                        </select>
                        <i class="fas fa-sort absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>
                
                {{-- Nút Reset bộ lọc (Chỉ hiện khi đang lọc) --}}
                @if(request('search') || request('status'))
                    <div class="mt-3 text-right">
                        <a href="{{ route('volunteer.applications.my') }}" class="text-xs text-rose-500 font-bold hover:underline">
                            <i class="fas fa-times"></i> Xóa bộ lọc
                        </a>
                    </div>
                @endif
            </form>
        </div>

        {{-- DANH SÁCH ĐƠN ỨNG TUYỂN --}}
        <div class="space-y-5">
            @forelse($applications as $app)
                @php
                    $color = match($app->status) {
                        'Accepted' => 'emerald',
                        'Rejected' => 'rose',
                        'Under Review' => 'blue',
                        'Pending' => 'amber',
                        default => 'slate'
                    };
                    $progressWidth = match($app->status) {
                        'Under Review' => '50%',
                        'Accepted', 'Rejected' => '100%',
                        default => '10%'
                    };
                @endphp

                <div class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden">
                    <div class="flex flex-col md:flex-row gap-6">
                        {{-- Cột 1: Logo & Ngày --}}
                        <div class="flex md:flex-col items-center md:items-start gap-4 md:w-24 shrink-0 border-b md:border-b-0 md:border-r border-slate-100 pb-4 md:pb-0">
                            <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-xl text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="text-center md:text-left">
                                <div class="text-xs text-slate-400 font-medium">Gửi ngày</div>
                                <div class="text-sm font-bold text-slate-700">{{ $app->applied_date->format('d/m') }}</div>
                                <div class="text-xs text-slate-400">{{ $app->applied_date->format('Y') }}</div>
                            </div>
                        </div>

                        {{-- Cột 2: Nội dung chính --}}
                        <div class="flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 leading-tight">
                                        <a href="{{ route('volunteer.applications.show', $app->application_id) }}" class="hover:text-indigo-600 transition">
                                            {{ $app->opportunity->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-slate-500 font-medium mt-1">
                                        <i class="fas fa-building mr-1"></i> {{ $app->opportunity->organization->organization_name }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold border bg-{{ $color }}-50 text-{{ $color }}-700 border-{{ $color }}-100 whitespace-nowrap">
                                    {{ $app->status }}
                                </span>
                            </div>

                            {{-- Thanh tiến trình (Timeline Bar) --}}
                            <div class="mt-4 mb-2">
                                <div class="flex justify-between text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                    <span class="text-indigo-600">Đã gửi</span>
                                    <span class="{{ in_array($app->status, ['Under Review', 'Accepted', 'Rejected']) ? 'text-indigo-600' : '' }}">Xét duyệt</span>
                                    <span class="{{ $app->status == 'Accepted' ? 'text-emerald-600' : ($app->status == 'Rejected' ? 'text-rose-600' : '') }}">Kết quả</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-{{ $color == 'rose' ? 'rose' : 'indigo' }}-500 transition-all duration-1000" style="width: {{ $progressWidth }}"></div>
                                </div>
                            </div>
                            
                            {{-- Ghi chú từ chối --}}
                            @if($app->status == 'Rejected' && !empty($app->organization_notes))
                                <div class="mt-3 bg-rose-50 border border-rose-100 rounded-lg p-3 text-sm text-rose-800 animate-fade-in-down">
                                    <span class="font-bold"><i class="fas fa-info-circle"></i> Lý do:</span> {{ $app->organization_notes }}
                                </div>
                            @endif
                        </div>

                        {{-- Cột 3: Hành động --}}
                        <div class="flex md:flex-col justify-end gap-2 md:w-36 shrink-0 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-slate-100 md:pl-4">
                            <a href="{{ route('volunteer.applications.show', $app->application_id) }}" 
                               class="flex-1 md:flex-none flex items-center justify-center gap-2 w-full py-2 rounded-lg bg-slate-50 text-slate-600 text-sm font-bold hover:bg-slate-100 hover:text-slate-800 transition">
                                <i class="fas fa-eye"></i> Chi tiết
                            </a>
                            
                            {{-- NÚT LIÊN HỆ (Chỉ hiện khi Accepted) --}}
                            @if($app->status == 'Accepted')
                                <button type="button" 
                                    onclick="openContactModal('{{ $app->opportunity->organization->organization_name }}', '{{ $app->opportunity->title }}', '{{ $app->opportunity->org_id }}')"
                                    class="flex-1 md:flex-none flex items-center justify-center gap-2 w-full py-2 rounded-lg bg-emerald-600 text-white text-sm font-bold hover:bg-emerald-700 shadow-md shadow-emerald-200 transition transform active:scale-95">
                                    <i class="fas fa-comments"></i> Liên hệ
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 text-indigo-300">
                        <i class="fas fa-search text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Không tìm thấy kết quả</h3>
                    <p class="text-slate-500 mb-6 max-w-sm mx-auto">Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc trạng thái để xem kết quả khác.</p>
                    <a href="{{ route('volunteer.applications.my') }}" class="text-indigo-600 font-bold hover:underline">Xóa bộ lọc</a>
                </div>
            @endforelse
        </div>
        
        {{-- PHÂN TRANG (Tự động giữ filters nhờ Controller) --}}
        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    </div>

    {{-- === MODAL LIÊN HỆ (Giữ nguyên logic cũ) === --}}
    <div id="contactModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeContactModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-lg">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white"><i class="fas fa-paper-plane mr-2"></i> Gửi Tin Nhắn</h3>
                        <button onclick="closeContactModal()" class="text-white/80 hover:text-white"><i class="fas fa-times"></i></button>
                    </div>
                    <form action="{{ route('volunteer.contact.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <input type="hidden" name="org_id" id="modalOrgId">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tới tổ chức</label>
                            <input type="text" id="modalOrgName" class="w-full bg-slate-50 border-slate-200 rounded-lg text-slate-700 font-bold" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Về công việc</label>
                            <input type="text" name="job_title" id="modalJobTitle" class="w-full bg-slate-50 border-slate-200 rounded-lg text-slate-600" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nội dung tin nhắn <span class="text-red-500">*</span></label>
                            <textarea name="message" rows="4" class="w-full border-slate-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nhập nội dung bạn muốn trao đổi..." required></textarea>
                        </div>
                        <div class="pt-2 flex justify-end gap-3">
                            <button type="button" onclick="closeContactModal()" class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 font-bold hover:bg-slate-200">Hủy</button>
                            <button type="submit" class="px-6 py-2 rounded-lg bg-emerald-600 text-white font-bold hover:bg-emerald-700 shadow-lg">Gửi ngay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openContactModal(orgName, jobTitle, orgId) {
        document.getElementById('modalOrgName').value = orgName;
        document.getElementById('modalJobTitle').value = jobTitle;
        document.getElementById('modalOrgId').value = orgId;
        document.getElementById('contactModal').classList.remove('hidden');
    }
    function closeContactModal() {
        document.getElementById('contactModal').classList.add('hidden');
    }
</script>
@endsection