@extends('layouts.app')

@section('title', 'Đổi Mật Khẩu - VolunteerConnect')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center space-x-2">
                    <i class="fas fa-lock text-indigo-600 dark:text-indigo-400"></i>
                    <span>Đổi Mật Khẩu</span>
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Bảo vệ tài khoản của bạn bằng mật khẩu mạnh và an toàn
                </p>
            </div>

            <!-- Password Change Form -->
            <form method="POST" action="{{ route('user.change-password') }}" class="space-y-6">
                @csrf

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mật khẩu hiện tại <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current_password"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition"
                            placeholder="Nhập mật khẩu hiện tại" required>
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                            onclick="togglePassword('current_password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mật khẩu mới <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="new_password" id="new_password"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition"
                            placeholder="Nhập mật khẩu mới (ít nhất 8 ký tự)" required minlength="8">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                            onclick="togglePassword('new_password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('new_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="new_password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Xác nhận mật khẩu mới <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition"
                            placeholder="Nhập lại mật khẩu mới" required minlength="8">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                            onclick="togglePassword('new_password_confirmation')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('new_password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Requirements -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Yêu cầu mật khẩu:</h4>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li id="req-length" class="flex items-center space-x-2 password-requirement">
                            <i class="fas fa-circle text-gray-400 text-xs"></i>
                            <span>Ít nhất 8 ký tự</span>
                        </li>
                        <li id="req-uppercase" class="flex items-center space-x-2 password-requirement">
                            <i class="fas fa-circle text-gray-400 text-xs"></i>
                            <span>Chữ hoa (A-Z)</span>
                        </li>
                        <li id="req-lowercase" class="flex items-center space-x-2 password-requirement">
                            <i class="fas fa-circle text-gray-400 text-xs"></i>
                            <span>Chữ thường (a-z)</span>
                        </li>
                        <li id="req-number" class="flex items-center space-x-2 password-requirement">
                            <i class="fas fa-circle text-gray-400 text-xs"></i>
                            <span>Số (0-9)</span>
                        </li>
                        <li id="req-special" class="flex items-center space-x-2 password-requirement">
                            <i class="fas fa-circle text-gray-400 text-xs"></i>
                            <span>Ký tự đặc biệt (!@#$%^&*)</span>
                        </li>
                    </ul>
                </div>


                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('profile') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Quay lại
                    </a>

                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        <i class="fas fa-save mr-2"></i>
                        Đổi Mật Khẩu
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Realtime password validation with check icons
        const newPassword = document.getElementById('new_password');

        newPassword.addEventListener('input', function () {
            const val = this.value;

            const requirements = [
                { id: 'req-length', regex: /.{8,}/ },
                { id: 'req-uppercase', regex: /[A-Z]/ },
                { id: 'req-lowercase', regex: /[a-z]/ },
                { id: 'req-number', regex: /[0-9]/ },
                { id: 'req-special', regex: /[!@#$%^&*]/ }
            ];

            requirements.forEach(req => {
                const li = document.getElementById(req.id);
                const icon = li.querySelector('i');

                if (req.regex.test(val)) {
                    li.classList.add('text-green-500');
                    li.classList.remove('text-gray-400');
                    icon.classList.remove('fa-circle');
                    icon.classList.add('fa-check');
                } else {
                    li.classList.remove('text-green-500');
                    li.classList.add('text-gray-400');
                    icon.classList.remove('fa-check');
                    icon.classList.add('fa-circle');
                }
            });
        });
    </script>
    <style>
        .password-requirement {
            transition: color 0.3s ease;
        }

        .password-requirement i {
            transition: color 0.3s ease;
        }
    </style>
@endsection