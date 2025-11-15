@extends('layouts.app')
@section('title', 'Nhập Mã OTP')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-20 px-4 flex items-center justify-center">
    <div class="max-w-md w-full mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl p-10 border border-purple-100">

            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full mb-6">
                    <i class="fas fa-key text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl font-bold text-purple-800 mb-3">Nhập Mã OTP</h1>
                <p class="text-gray-600">Chúng tôi đã gửi mã 6 chữ số đến email của bạn.</p>
            </div>

            {{-- Hiển thị thông báo --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('volunteer.profile.verifyOtp') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="otp" class="block text-lg font-bold text-purple-700 mb-3">Mã OTP</label>
                    <input type="text" name="otp" id="otp" 
                           class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-3xl text-center tracking-[1em]" 
                           maxlength="6" required autofocus
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '');"
                           placeholder="_ _ _ _ _ _">
                    @error('otp')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-10 py-4 rounded-2xl font-bold text-xl shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 transition duration-300">
                    <i class="fas fa-check-circle mr-2"></i> Xác Thực
                </button>
            </form>
            
            <div class="text-center mt-6">
                 <a href="{{ route('volunteer.profile.edit') }}" class="text-sm text-gray-500 hover:text-purple-600 transition">
                    <i class="fas fa-arrow-left mr-1"></i> Quay lại trang hồ sơ
                 </a>
            </div>
        </div>
    </div>
</div>
@endsection