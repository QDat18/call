<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - Volunteer Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center text-purple-700 mb-8">
            Đặt lại mật khẩu
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $email ?? '') }}" 
                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-purple-500" 
                       required readonly>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu mới</label>
                <input type="password" name="password" 
                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-purple-500" 
                       required minlength="8">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" 
                       class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:border-purple-500" 
                       required>
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                Cập nhật mật khẩu
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            <a href="{{ route('login') }}" class="text-purple-600 hover:underline">← Quay lại đăng nhập</a>
        </p>
    </div>
</body>
</html>