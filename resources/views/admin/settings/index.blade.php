@extends('layouts.admin')

@section('title', 'Cài đặt Hệ thống')
@section('breadcrumb', 'Settings')

@section('content')
<div x-data="{ activeTab: 'general' }" class="space-y-6">

    <div class="relative bg-gradient-to-r from-gray-800 to-gray-700 rounded-2xl shadow-lg p-8 text-white overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1/2 bg-white/5 skew-x-12 transform translate-x-20"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h2 class="text-3xl font-bold mb-2">Cài đặt Hệ thống</h2>
                <p class="text-gray-300 text-lg opacity-90">Cấu hình thông số và tùy chọn vận hành của nền tảng.</p>
            </div>
            
            <button type="submit" form="settingsForm" 
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fas fa-save"></i> Lưu thay đổi
            </button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <div class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 sticky top-24">
                <nav class="space-y-1">
                    <button @click="activeTab = 'general'" 
                            :class="activeTab === 'general' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all">
                        <i class="fas fa-cogs w-5 text-center"></i> Tổng quan
                    </button>
                    
                    <button @click="activeTab = 'email'" 
                            :class="activeTab === 'email' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all">
                        <i class="fas fa-envelope w-5 text-center"></i> Email & SMTP
                    </button>
                    
                    <button @click="activeTab = 'registration'" 
                            :class="activeTab === 'registration' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all">
                        <i class="fas fa-users-cog w-5 text-center"></i> Đăng ký & Thành viên
                    </button>
                    
                    <button @click="activeTab = 'system'" 
                            :class="activeTab === 'system' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700'"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all">
                        <i class="fas fa-tools w-5 text-center"></i> Bảo trì hệ thống
                    </button>
                </nav>
            </div>
        </div>

        <div class="flex-1">
            <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm" class="space-y-6">
                @csrf
                @method('PUT')

                <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                            Thông tin chung
                        </h3>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tên trang web (Site Name)</label>
                                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'VolunteerConnect') }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email liên hệ</label>
                                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Mô tả trang web</label>
                                <textarea name="site_description" rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'email'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                            Cấu hình Email
                        </h3>
                        
                        <div class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">Gửi thông báo qua Email</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Bật/tắt toàn bộ hệ thống gửi mail tự động</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="email_notifications" value="1" 
                                       {{ ($settings['email_notifications'] ?? '0') == '1' ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tên người gửi (From Name)</label>
                                <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? config('app.name')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email gửi đi (From Address)</label>
                                <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}"
                                       placeholder="noreply@domain.com"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'registration'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                            Đăng ký & Thành viên
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-600 hover:border-indigo-200 transition">
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">Cho phép đăng ký mới</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Người dùng mới có thể tạo tài khoản</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="allow_registration" value="1" 
                                           {{ ($settings['allow_registration'] ?? '1') == '1' ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-100 dark:border-gray-600 hover:border-indigo-200 transition">
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">Yêu cầu xác thực Email</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Người dùng phải xác thực email để sử dụng đầy đủ tính năng</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="require_email_verification" value="1" 
                                           {{ ($settings['require_email_verification'] ?? '0') == '1' ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'system'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                            Bảo trì Hệ thống
                        </h3>
                        
                        <div class="mb-6 flex items-center justify-between p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-yellow-800 dark:text-yellow-200">Chế độ Bảo trì</p>
                                    <p class="text-sm text-yellow-600 dark:text-yellow-400">Trang web sẽ chỉ truy cập được bởi Admin</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="maintenance_mode" value="1" 
                                       {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                            </label>
                        </div>
                        
                        <div x-show="{{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'true' : 'false' }}" x-transition>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Thông báo bảo trì</label>
                            <textarea name="maintenance_message" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">{{ old('maintenance_message', $settings['maintenance_message'] ?? 'Hệ thống đang bảo trì. Vui lòng quay lại sau.') }}</textarea>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection