<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống đang bảo trì</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl overflow-hidden text-center p-8">
        <div class="mb-6">
            <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
            </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Đang Bảo Trì</h1>
        <p class="text-gray-600 mb-6 leading-relaxed">
            {{ $exception->getMessage() ?: 'Hệ thống đang được nâng cấp để phục vụ bạn tốt hơn. Vui lòng quay lại sau ít phút.' }}
        </p>
        <div class="text-sm text-gray-400">
            &copy; {{ date('Y') }} VolunteerConnect Team
        </div>
    </div>
</body>
</html>