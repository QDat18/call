@extends('layouts.app')

@section('title', 'Đổi Mật Khẩu')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
        <div class="max-w-2xl mx-auto px-4">
            
            {{-- Back Button --}}
            <div class="mb-4">
                <a href="{{ route('profile') }}" 
                   class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                
                {{-- Header --}}
                <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-lock text-blue-600"></i>
                        Đổi Mật Khẩu
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Bảo vệ tài khoản của bạn bằng mật khẩu mạnh và an toàn
                    </p>
                </div>

                <form method="POST" action="{{ route('user.change-password') }}" id="change-password-form">
                    @csrf

                    {{-- Step 1: Current Password --}}
                    <div class="mb-6">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mật khẩu hiện tại <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password"
                                class="w-full pl-4 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition"
                                placeholder="Nhập mật khẩu hiện tại" required>
                            <button type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400"
                                onclick="togglePasswordVisibility('current_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Step 2: New Password --}}
                    <div class="mb-6">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mật khẩu mới <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password"
                                class="w-full pl-4 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition"
                                placeholder="Nhập mật khẩu mới (ít nhất 8 ký tự)" required minlength="8">
                            <button type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400"
                                onclick="togglePasswordVisibility('new_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        
                        {{-- Password Strength Indicator --}}
                        <div class="mt-2">
                            <div class="flex gap-1 mb-1">
                                <div id="strength-1" class="h-1 flex-1 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                <div id="strength-2" class="h-1 flex-1 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                <div id="strength-3" class="h-1 flex-1 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                <div id="strength-4" class="h-1 flex-1 bg-gray-200 dark:bg-gray-700 rounded"></div>
                            </div>
                            <p id="strength-text" class="text-xs text-gray-500 dark:text-gray-400"></p>
                        </div>

                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Step 3: Confirm New Password --}}
                    <div class="mb-6">
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Xác nhận mật khẩu mới <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="w-full pl-4 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition"
                                placeholder="Nhập lại mật khẩu mới" required minlength="8">
                            <button type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400"
                                onclick="togglePasswordVisibility('new_password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p id="match-indicator" class="text-sm mt-1 hidden"></p>
                        @error('new_password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SỬA: ĐÃ XÓA style="display: none;" ĐỂ HIỂN THỊ LUÔN --}}
                    {{-- Email Verification Code --}}
                    <div class="mb-6" id="verification-section">
                        <label for="verification_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mã xác thực từ Email <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <input type="text" name="verification_code" id="verification_code"
                                class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Nhập mã 6 số" maxlength="6" pattern="[0-9]{6}">
                            <button type="button" id="send-code-btn" onclick="sendVerificationCode()"
                                class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition whitespace-nowrap">
                                Gửi mã
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Mã xác thực sẽ được gửi đến email: <span class="font-semibold">{{ Auth::user()->email }}</span>
                        </p>
                        <p id="code-timer" class="text-sm text-blue-600 dark:text-blue-400 mt-1 hidden"></p>
                        @error('verification_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Google reCAPTCHA --}}
                    <div class="mb-6">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('profile') }}"
                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition">
                            Hủy
                        </a>

                        <button type="submit" id="submit-btn"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-save mr-2"></i>
                            Đổi Mật Khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@push('scripts')
{{-- Google reCAPTCHA --}}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
(function() { // <--- BẮT ĐẦU IIFE: Cô lập phạm vi biến để tránh lỗi "Identifier declared"
    
    // 1. Toggle password visibility
    window.togglePasswordVisibility = function(inputId) { // Gán vào window để HTML gọi được onclick
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // 2. Password strength checker
    const newPasswordInput = document.getElementById('new_password'); // Đổi tên biến tránh trùng
    if (newPasswordInput) {
        const requirements = [
            { id: 'req-length', regex: /.{8,}/ },
            { id: 'req-uppercase', regex: /[A-Z]/ },
            { id: 'req-lowercase', regex: /[a-z]/ },
            { id: 'req-number', regex: /[0-9]/ },
            { id: 'req-special', regex: /[!@#$%^&*(),.?":{}|<>]/ }
        ];

        newPasswordInput.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;

            requirements.forEach(req => {
                const li = document.getElementById(req.id);
                if(!li) return;
                const icon = li.querySelector('i');

                if (req.regex.test(value)) {
                    li.classList.add('text-green-600', 'dark:text-green-400');
                    li.classList.remove('text-gray-600', 'dark:text-gray-400');
                    icon.classList.replace('fa-circle', 'fa-check-circle');
                    strength++;
                } else {
                    li.classList.remove('text-green-600', 'dark:text-green-400');
                    li.classList.add('text-gray-600', 'dark:text-gray-400');
                    icon.classList.replace('fa-check-circle', 'fa-circle');
                }
            });

            updateStrengthIndicator(strength);
            checkPasswordMatch();
        });
    }

    function updateStrengthIndicator(strength) {
        const bars = ['strength-1', 'strength-2', 'strength-3', 'strength-4'];
        const text = document.getElementById('strength-text');
        
        bars.forEach((bar, index) => {
            const element = document.getElementById(bar);
            if(!element) return;
            element.className = 'h-1 flex-1 rounded transition-colors';
            
            if (index < strength) {
                if (strength <= 2) element.classList.add('bg-red-500');
                else if (strength === 3) element.classList.add('bg-yellow-500');
                else element.classList.add('bg-green-500');
            } else {
                element.classList.add('bg-gray-200', 'dark:bg-gray-700');
            }
        });

        if (text) {
            if (strength === 0) text.textContent = '';
            else if (strength <= 2) { text.textContent = 'Độ mạnh: Yếu'; text.className = 'text-xs text-red-600'; }
            else if (strength === 3) { text.textContent = 'Độ mạnh: Trung bình'; text.className = 'text-xs text-yellow-600'; }
            else { text.textContent = 'Độ mạnh: Mạnh'; text.className = 'text-xs text-green-600'; }
        }
    }

    // 3. Check password match
    const confirmPasswordInput = document.getElementById('new_password_confirmation');
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    }

    function checkPasswordMatch() {
        const indicator = document.getElementById('match-indicator');
        if (!newPasswordInput || !confirmPasswordInput || !indicator) return;

        const newPass = newPasswordInput.value;
        const confirmPass = confirmPasswordInput.value;

        if (confirmPass.length === 0) {
            indicator.classList.add('hidden');
            return;
        }

        indicator.classList.remove('hidden');
        if (newPass === confirmPass) {
            indicator.textContent = '✓ Mật khẩu khớp';
            indicator.className = 'text-sm mt-1 text-green-600';
        } else {
            indicator.textContent = '✗ Mật khẩu không khớp';
            indicator.className = 'text-sm mt-1 text-red-600';
        }
    }

    // 4. Send verification code
    let codeSentTime = null;
    const sendBtn = document.getElementById('send-code-btn');
    
    // Gán vào window để HTML gọi onclick
    window.sendVerificationCode = async function() {
        if (!sendBtn) return;
        
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';

        try {
            const response = await fetch('{{ route("user.send-verification-code") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // Kiểm tra Content-Type trước khi parse JSON để tránh lỗi "Unexpected token <"
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Server trả về lỗi (HTML) thay vì JSON. Hãy kiểm tra Log.");
            }

            const data = await response.json();
            
            if (response.ok && data.success) {
                codeSentTime = Date.now();
                startCodeTimer();
                alert('Mã xác thực đã được gửi đến email của bạn!');
                sendBtn.textContent = 'Đã gửi mã';
            } else {
                throw new Error(data.message || 'Có lỗi xảy ra');
            }
        } catch (error) {
            console.error('Error Details:', error);
            alert('Lỗi: ' + error.message);
            sendBtn.disabled = false;
            sendBtn.textContent = 'Gửi lại mã';
        }
    }

    function startCodeTimer() {
        const timer = document.getElementById('code-timer');
        if (!sendBtn || !timer) return;

        timer.classList.remove('hidden');
        
        const interval = setInterval(() => {
            const elapsed = Math.floor((Date.now() - codeSentTime) / 1000);
            const remaining = 300 - elapsed; // 5 minutes

            if (remaining <= 0) {
                clearInterval(interval);
                timer.classList.add('hidden');
                sendBtn.disabled = false;
                sendBtn.textContent = 'Gửi lại mã';
            } else {
                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;
                timer.textContent = `Mã có hiệu lực trong ${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
        }, 1000);
    }

})(); // <--- KẾT THÚC IIFE
</script>
@endpush
@endsection