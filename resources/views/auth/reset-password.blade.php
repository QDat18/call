<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - Volunteer Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-purple-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <h1 class="text-4xl font-bold text-indigo-600 mb-2">
                    <i class="fas fa-hands-helping"></i> Volunteer Connect
                </h1>
            </a>
            <p class="text-gray-600">Thiết lập mật khẩu mới</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full mb-4">
                        <i class="fas fa-lock text-3xl text-indigo-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white">
                        Đặt lại mật khẩu
                    </h2>
                    <p class="text-indigo-100 mt-2">Tạo mật khẩu mạnh để bảo vệ tài khoản</p>
                </div>
            </div>

            <div class="p-8">

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle mr-3 mt-0.5 text-lg"></i>
                        <div>
                            <p class="font-semibold">Đã xảy ra lỗi</p>
                            <ul class="list-disc list-inside text-sm mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-indigo-600"></i>
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email', $email ?? '') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed focus:outline-none" 
                               required readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-key mr-2 text-indigo-600"></i>
                            Mật khẩu mới
                        </label>
                        <div class="relative">
                            <input type="password" name="password" required autofocus
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-400"
                                   placeholder="Nhập mật khẩu mới (tối thiểu 8 ký tự)">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-check-circle mr-2 text-indigo-600"></i>
                            Nhập lại mật khẩu
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-400"
                                   placeholder="Xác nhận lại mật khẩu">
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-semibold text-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg mt-4">
                        <i class="fas fa-save mr-2"></i> Cập nhật mật khẩu
                    </button>
                </form>

                <div class="text-center pt-6 border-t mt-6">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Quay lại đăng nhập
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 mt-6">
            <div class="flex items-start">
                <i class="fas fa-shield-alt text-indigo-600 text-xl mr-3 mt-1"></i>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1">Mẹo bảo mật</h3>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Sử dụng mật khẩu có ít nhất 8 ký tự</li>
                        <li>• Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</body>
</html>