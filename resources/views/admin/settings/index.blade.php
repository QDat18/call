@extends('layouts.admin')

@section('title', 'System Settings')
@section('breadcrumb', 'Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">System Settings</h2>
            <p class="text-gray-600 mt-1">Configure platform settings and preferences</p>
        </div>
    </div>

    {{-- Thông báo thành công/lỗi (Nếu chưa dùng toast toàn cục) --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0"><i class="fas fa-check-circle text-green-500"></i></div>
                <div class="ml-3"><p class="text-sm text-green-700">{{ session('success') }}</p></div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-cogs mr-2 text-indigo-500"></i> General Settings
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'VolunteerConnect') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                    <textarea name="site_description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-envelope mr-2 text-blue-500"></i> Email Settings
                </h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <div>
                        <p class="font-medium text-gray-900">Email Notifications</p>
                        <p class="text-sm text-gray-500">Enable sending system emails to users</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="email_notifications" value="1" 
                               {{ ($settings['email_notifications'] ?? '0') == '1' ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Name</label>
                        <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? config('app.name')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Email</label>
                        <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}"
                               placeholder="noreply@domain.com"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-users-cog mr-2 text-purple-500"></i> Registration
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <div>
                        <p class="font-medium text-gray-900">Allow New Registrations</p>
                        <p class="text-sm text-gray-500">Turn off to stop accepting new users</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="allow_registration" value="1" 
                               {{ ($settings['allow_registration'] ?? '1') == '1' ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <div>
                        <p class="font-medium text-gray-900">Email Verification</p>
                        <p class="text-sm text-gray-500">Require users to verify email before login</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="require_email_verification" value="1" 
                               {{ ($settings['require_email_verification'] ?? '0') == '1' ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-tools mr-2 text-orange-500"></i> System Status
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div>
                        <p class="font-medium text-yellow-800">Maintenance Mode</p>
                        <p class="text-sm text-yellow-600">Site will be inaccessible to non-admin users</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="maintenance_mode" value="1" 
                               {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                    </label>
                </div>
                
                <div x-show="{{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'true' : 'false' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Maintenance Message</label>
                    <textarea name="maintenance_message" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">{{ old('maintenance_message', $settings['maintenance_message'] ?? 'We are currently performing maintenance. Please check back later.') }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end pt-4">
            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-0.5">
                <i class="fas fa-save mr-2"></i>Save Changes
            </button>
        </div>
        
    </form>
    
</div>
@endsection