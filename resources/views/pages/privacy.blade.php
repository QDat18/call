@extends('layouts.app')

@section('title', 'Chính Sách Bảo Mật - VolunteerConnect')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Chính Sách Bảo Mật</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Cập nhật lần cuối: {{ date('d/m/Y') }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <!-- Introduction -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">1. Giới Thiệu</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                    Chào mừng bạn đến với VolunteerConnect. Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn 
                    và quyền riêng tư của bạn. Chính sách bảo mật này giải thích cách chúng tôi thu thập, 
                    lưu trữ, sử dụng và bảo vệ thông tin của bạn.
                </p>
            </section>

            <!-- Information Collection -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">2. Thông Tin Chúng Tôi Thu Thập</h2>
                
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">2.1. Thông Tin Cá Nhân</h3>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-2 mb-4">
                    <li>Họ và tên, địa chỉ email, số điện thoại</li>
                    <li>Ngày sinh, giới tính, địa chỉ</li>
                    <li>Ảnh đại diện và thông tin hồ sơ</li>
                    <li>Thông tin thanh toán (nếu có)</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">2.2. Thông Tin Tự Động</h3>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-2">
                    <li>Địa chỉ IP, loại trình duyệt, thiết bị sử dụng</li>
                    <li>Hoạt động trên trang web, trang được xem</li>
                    <li>Thông tin vị trí (nếu được cho phép)</li>
                </ul>
            </section>

            <!-- Use of Information -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">3. Cách Chúng Tôi Sử Dụng Thông Tin</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                        <i class="fas fa-user-check text-blue-600 dark:text-blue-400 text-xl mb-2"></i>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Cá Nhân Hóa</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Cung cấp trải nghiệm cá nhân hóa và đề xuất phù hợp
                        </p>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                        <i class="fas fa-comments text-green-600 dark:text-green-400 text-xl mb-2"></i>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Hỗ Trợ</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Phản hồi yêu cầu hỗ trợ và cải thiện dịch vụ
                        </p>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                        <i class="fas fa-shield-alt text-purple-600 dark:text-purple-400 text-xl mb-2"></i>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Bảo Mật</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Bảo vệ tài khoản và ngăn chặn gian lận
                        </p>
                    </div>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                        <i class="fas fa-chart-line text-yellow-600 dark:text-yellow-400 text-xl mb-2"></i>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Phát Triển</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Phân tích và cải thiện chất lượng dịch vụ
                        </p>
                    </div>
                </div>
            </section>

            <!-- Data Sharing -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">4. Chia Sẻ Thông Tin</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                    Chúng tôi <strong>không bán</strong> thông tin cá nhân của bạn cho bên thứ ba. 
                    Thông tin có thể được chia sẻ trong các trường hợp sau:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-2">
                    <li>Với tổ chức khi bạn ứng tuyển tình nguyện</li>
                    <li>Với nhà cung cấp dịch vụ cần thiết</li>
                    <li>Khi được yêu cầu bởi pháp luật</li>
                    <li>Để bảo vệ quyền và tài sản của chúng tôi</li>
                </ul>
            </section>

            <!-- Data Security -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">5. Bảo Mật Dữ Liệu</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <i class="fas fa-lock text-2xl text-green-600 dark:text-green-400"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Biện Pháp Bảo Mật</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Chúng tôi sử dụng mã hóa SSL, firewall và các biện pháp bảo mật tiên tiến
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-user-shield text-2xl text-blue-600 dark:text-blue-400"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Quyền Truy Cập</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Chỉ nhân viên được ủy quyền mới có quyền truy cập thông tin cá nhân
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Your Rights -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">6. Quyền Của Bạn</h2>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-eye text-green-600 dark:text-green-400 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Quyền Truy Cập</h4>
                            <p class="text-gray-600 dark:text-gray-300">
                                Bạn có quyền xem thông tin cá nhân của mình
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-edit text-blue-600 dark:text-blue-400 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Quyền Chỉnh Sửa</h4>
                            <p class="text-gray-600 dark:text-gray-300">
                                Bạn có thể cập nhật thông tin cá nhân bất kỳ lúc nào
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-trash-alt text-red-600 dark:text-red-400 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Quyền Xóa</h4>
                            <p class="text-gray-600 dark:text-gray-300">
                                Bạn có quyền yêu cầu xóa tài khoản và dữ liệu cá nhân
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact -->
            <section class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Câu Hỏi Về Bảo Mật?</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Nếu bạn có bất kỳ câu hỏi nào về chính sách bảo mật của chúng tôi, 
                    vui lòng liên hệ với chúng tôi.
                </p>
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                    <i class="fas fa-envelope mr-2"></i>
                    Liên Hệ Với Chúng Tôi
                </a>
            </section>
        </div>
    </div>
</div>
@endsection