@extends('layouts.admin')

@section('title', 'Chi tiết Tổ chức')
@section('breadcrumb', 'Organizations / Details')

@section('content')
<div class="space-y-6">

    <div>
        <a href="{{ route('admin.organizations.index') }}" 
           class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="h-40 bg-gradient-to-r from-indigo-500 to-purple-600 relative"></div>

        <div class="px-8 pb-8 relative">
            <div class="absolute -top-16 left-8">
                <div class="w-32 h-32 rounded-xl bg-white dark:bg-gray-800 border-4 border-white dark:border-gray-800 shadow-md flex items-center justify-center overflow-hidden">
                    @php
                        $avatarUrl = $organization->logo_url 
                            ? asset('storage/' . $organization->logo_url) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($organization->organization_name) . '&background=6366f1&color=fff&size=128&font-size=0.5';
                    @endphp
                    <img src="{{ $avatarUrl }}" alt="Logo" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="pt-20 flex flex-col md:flex-row justify-between items-start gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $organization->organization_name }}</h1>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        @if($organization->verification_status === 'Verified')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full flex items-center">
                                <i class="fas fa-check-circle mr-1"></i> Verified
                            </span>
                        @elseif($organization->verification_status === 'Pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full flex items-center">
                                <i class="fas fa-clock mr-1"></i> Pending
                            </span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full flex items-center">
                                <i class="fas fa-times-circle mr-1"></i> Rejected
                            </span>
                        @endif

                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">
                            {{ $organization->organization_type }}
                        </span>
                    </div>
                </div>

                <div class="flex gap-3">
                    @if($organization->verification_status === 'Pending')
                        <button onclick="openApproveModal('{{ $organization->org_id }}')" 
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium shadow-sm transition flex items-center">
                            <i class="fas fa-check mr-2"></i> Duyệt
                        </button>
                        <button onclick="openRejectModal('{{ $organization->org_id }}')" 
                                class="px-6 py-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-lg font-medium shadow-sm transition flex items-center">
                            <i class="fas fa-times mr-2"></i> Từ chối
                        </button>
                    @endif

                    <button onclick="openDeleteModal('{{ $organization->org_id }}')" 
                            class="px-6 py-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-lg font-medium shadow-sm transition flex items-center">
                        <i class="fas fa-trash-alt mr-2"></i> Xóa
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 border-t border-gray-100 dark:border-gray-700 pt-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $organization->volunteer_count ?? 0 }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">Tình nguyện viên</div>
                </div>
                <div class="text-center border-l border-gray-100 dark:border-gray-700">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $organization->total_opportunities ?? 0 }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">Cơ hội</div>
                </div>
                <div class="text-center border-l border-gray-100 dark:border-gray-700">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($organization->rating ?? 0, 1) }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">Đánh giá</div>
                </div>
                <div class="text-center border-l border-gray-100 dark:border-gray-700">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $organization->founded_year ?? 'N/A' }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide mt-1">Năm thành lập</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-info-circle text-indigo-600 mr-2"></i> Giới thiệu
                </h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                    {{ $organization->description ?: 'Chưa có thông tin giới thiệu.' }}
                </p>
                
                @if($organization->mission_statement)
                    <div class="mt-6 p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border-l-4 border-indigo-500">
                        <h4 class="text-sm font-bold text-indigo-800 dark:text-indigo-300 mb-1">Sứ mệnh</h4>
                        <p class="text-indigo-700 dark:text-indigo-200 italic">"{{ $organization->mission_statement }}"</p>
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-file-contract text-indigo-600 mr-2"></i> Tài liệu xác thực
                </h3>

                @if($organization->registration_document)
                    @php
                        $docUrl = asset('storage/' . $organization->registration_document);
                        $ext = pathinfo($organization->registration_document, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']);
                    @endphp
                    
                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 bg-gray-50 dark:bg-gray-900">
                        @if($isImage)
                            <a href="{{ $docUrl }}" target="_blank">
                                <img src="{{ $docUrl }}" class="max-h-80 mx-auto rounded shadow-sm hover:opacity-90 transition">
                            </a>
                        @else
                            <div class="flex items-center justify-center p-6">
                                <a href="{{ $docUrl }}" target="_blank" class="flex flex-col items-center text-gray-600 hover:text-indigo-600">
                                    <i class="fas fa-file-pdf text-5xl text-red-500 mb-2"></i>
                                    <span class="font-medium">Xem tài liệu ({{ strtoupper($ext) }})</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-10 text-center bg-gray-50 dark:bg-gray-900/50">
                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-file-upload text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Chưa có tài liệu xác thực nào được tải lên.</p>
                    </div>
                @endif
            </div>

            @if(isset($organization->certificates) && count($organization->certificates) > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-certificate text-indigo-600 mr-2"></i> Chứng chỉ hoạt động
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($organization->certificates as $cert)
                        <div class="group relative aspect-video rounded-lg overflow-hidden border border-gray-200 cursor-pointer" 
                             onclick="window.open('{{ asset('storage/' . $cert) }}', '_blank')">
                            <img src="{{ asset('storage/' . $cert) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all duration-300"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Thông tin liên hệ</h3>
                
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-1">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Email</p>
                                
                                {{-- Badge xác thực Email --}}
                                @if($organization->user->email_verified_at)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700">
                                        Đã xác thực
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700">
                                        Chưa xác thực
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $organization->user->email }}">
                                {{ $organization->user->email }}
                            </p>

                            {{-- Nút gửi yêu cầu xác thực --}}
                            @if(!$organization->user->email_verified_at)
                                <button onclick="openEmailModal('single', {{ $organization->user_id }})" 
                                        class="mt-1 text-xs text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1 transition">
                                    <i class="fas fa-paper-plane"></i> Gửi yêu cầu xác thực
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Điện thoại</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $organization->user->phone ?? 'Chưa cập nhật' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Website</p>
                            @if($organization->website)
                                <a href="{{ $organization->website }}" target="_blank" class="text-sm font-medium text-indigo-600 hover:underline truncate block">
                                    {{ $organization->website }}
                                </a>
                            @else
                                <p class="text-sm text-gray-500 italic">Chưa cập nhật</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Địa chỉ</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-white leading-snug">
                                {{ $organization->user->address ?? 'Chưa cập nhật' }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $organization->user->district ? $organization->user->district . ', ' : '' }}
                                {{ $organization->user->city }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Thông tin hệ thống</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500">Mã User</span>
                        <span class="text-sm font-mono font-medium text-gray-700 dark:text-gray-300">#{{ $organization->user_id }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500">Mã Tổ chức</span>
                        <span class="text-sm font-mono font-medium text-gray-700 dark:text-gray-300">#{{ $organization->org_id }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500">Ngày tham gia</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $organization->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500">Trạng thái TK</span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold {{ $organization->user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $organization->user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Xác thực Email</span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold {{ $organization->user->is_verified ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $organization->user->is_verified ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.partials.email-modal')
@include('admin.partials.modals.organization-actions', ['organization' => $organization])

@endsection