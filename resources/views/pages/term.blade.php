@extends('layouts.app')

@section('title', 'Điều Khoản Dịch Vụ - VolunteerConnect')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Điều Khoản Dịch Vụ</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                Cập nhật lần cuối: {{ date('d/m/Y') }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <!-- Acceptance -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">1. Chấp Nhận Điều Khoản</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Bằng việc truy cập và sử dụng VolunteerConnect, bạn đồng ý tuân thủ và bị ràng buộc 
                    bởi các điều khoản và điều kiện được nêu trong tài liệu này. 
                    Nếu bạn không đồng ý với bất kỳ điều khoản nào, vui lòng không sử dụng dịch vụ của chúng tôi.
                </p>
            </section>

            <!-- Account Terms -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">2. Điều Khoản Tài Khoản</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start space-x-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <i class="fas fa-user-plus text-blue-600 dark:text-blue-400 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Đăng Ký Tài Khoản</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Bạn phải cung cấp thông tin chính xác, đầy đủ và cập nhật khi đăng ký tài khoản.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <i class="fas fa-shield-alt text-green-600 dark:text-green-400 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Bảo Mật Tài Khoản</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Bạn chịu trách nhiệm bảo mật mật khẩu và mọi hoạt động xảy ra dưới tài khoản của bạn.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        <i class="fas fa-ban text-red-600 dark:text-red-400 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Hành Vi Bị Cấm</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Không được sử dụng dịch vụ cho mục đích bất hợp pháp, lừa đảo hoặc vi phạm pháp luật.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- User Responsibilities -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">3. Trách Nhiệm Người Dùng</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                            <i class="fas fa-users text-purple-600 dark:text-purple-400 mr-2"></i>
                            Tình Nguyện Viên
                        </h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1 list-disc list-inside">
                            <li>Tham gia đầy đủ theo cam kết</li>
                            <li>Tôn trọng tổ chức và cộng đồng</li>
                            <li>Báo cáo hoạt động trung thực</li>
                            <li>Tuân thủ quy định an toàn</li>
                        </ul>
                    </div>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                            <i class="fas fa-building text-orange-600 dark:text-orange-400 mr-2"></i>
                            Tổ Chức
                        </h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1 list-disc list-inside">
                            <li>Cung cấp thông tin chính xác</li>
                            <li>Đảm bảo an toàn cho tình nguyện viên</li>
                            <li>Xác nhận giờ tình nguyện kịp thời</li>
                            <li>Tôn trọng tình nguyện viên</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Content Policy -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">4. Chính Sách Nội Dung</h2>
                
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 text-xl mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Nội Dung Không Được Phép</h4>
                            <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1 list-disc list-inside">
                                <li>Nội dung khiêu dâm, bạo lực hoặc kích động thù hận</li>
                                <li>Thông tin giả mạo, lừa đảo</li>
                                <li>Xâm phạm quyền sở hữu trí tuệ</li>
                                <li>Quảng cáo, tiếp thị không được cho phép</li>
                                <li>Spam hoặc nội dung tự động</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Intellectual Property -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">5. Sở Hữu Trí Tuệ</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                    Tất cả nội dung trên VolunteerConnect, bao gồm logo, thiết kế, văn bản, hình ảnh 
                    và mã nguồn đều là tài sản của chúng tôi và được bảo vệ bởi luật sở hữu trí tuệ.
                </p>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <strong>Lưu ý:</strong> Bạn giữ quyền sở hữu đối với nội dung bạn đăng tải, 
                        nhưng bạn cấp cho chúng tôi quyền sử dụng để cung cấp và cải thiện dịch vụ.
                    </p>
                </div>
            </section>

            <!-- Limitation of Liability -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">6. Giới Hạn Trách Nhiệm</h2>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 mt-1"></i>
                        <div>
                            <p class="text-gray-600 dark:text-gray-300">
                                VolunteerConnect hoạt động như một nền tảng kết nối và không chịu trách nhiệm 
                                cho các thỏa thuận hoặc tranh chấp giữa tình nguyện viên và tổ chức.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-exclamation-circle text-orange-600 dark:text-orange-400 mt-1"></i>
                        <div>
                            <p class="text-gray-600 dark:text-gray-300">
                                Chúng tôi không đảm bảo dịch vụ sẽ không bị gián đoạn hoặc không có lỗi, 
                                nhưng cam kết nỗ lực khắc phục sự cố kịp thời.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Termination -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">7. Chấm Dứt Dịch Vụ</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Chúng tôi có quyền tạm ngưng hoặc chấm dứt tài khoản của bạn nếu vi phạm các điều khoản này 
                    hoặc có hành vi gây hại cho cộng đồng. Bạn cũng có thể yêu cầu xóa tài khoản bất kỳ lúc nào.
                </p>
            </section>

            <!-- Changes to Terms -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">8. Thay Đổi Điều Khoản</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Chúng tôi có thể cập nhật các điều khoản này theo thời gian. 
                    Chúng tôi sẽ thông báo cho bạn về các thay đổi quan trọng qua email hoặc thông báo trên trang web. 
                    Việc tiếp tục sử dụng dịch vụ sau khi thay đổi có hiệu lực được coi là chấp nhận các điều khoản mới.
                </p>
            </section>

            <!-- Contact -->
            <section class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-6 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Cần Hỗ Trợ?</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Nếu bạn có bất kỳ câu hỏi nào về điều khoản dịch vụ, 
                    đừng ngần ngại liên hệ với chúng tôi.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                        <i class="fas fa-envelope mr-2"></i>
                        Liên Hệ Hỗ Trợ
                    </a>
                    <a href="{{ route('privacy') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Chính Sách Bảo Mật
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection