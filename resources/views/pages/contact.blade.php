@extends('layouts.app')

@section('title', 'Liên Hệ - VolunteerConnect')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Liên Hệ Với Chúng Tôi</h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy liên hệ nếu bạn có bất kỳ câu hỏi nào.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <div class="space-y-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Thông Tin Liên Hệ</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Địa Chỉ</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    123 Đường ABC, Quận 1<br>
                                    Thành phố Hồ Chí Minh, Việt Nam
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-green-600 dark:text-green-400"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Điện Thoại</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    +84 28 1234 5678<br>
                                    Thứ 2 - Thứ 6: 8:00 - 17:00
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Email</h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    support@volunteerconnect.vn<br>
                                    info@volunteerconnect.vn
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Theo Dõi Chúng Tôi</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-lg flex items-center justify-center text-white transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-pink-600 hover:bg-pink-700 rounded-lg flex items-center justify-center text-white transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-blue-400 hover:bg-blue-500 rounded-lg flex items-center justify-center text-white transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-red-600 hover:bg-red-700 rounded-lg flex items-center justify-center text-white transition">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Câu Hỏi Thường Gặp</h2>
                    <div class="space-y-4" x-data="{ openFaq: null }">
                        @foreach([
                            ['q' => 'Làm thế nào để đăng ký tình nguyện?', 'a' => 'Bạn có thể đăng ký tài khoản, hoàn thiện hồ sơ và tìm kiếm cơ hội phù hợp.'],
                            ['q' => 'Tổ chức có phải trả phí để đăng tin?', 'a' => 'Hoàn toàn miễn phí cho các tổ chức phi lợi nhuận.'],
                            ['q' => 'Làm sao để xác minh giờ tình nguyện?', 'a' => 'Giờ tình nguyện được xác minh bởi tổ chức và hệ thống tự động.'],
                            ['q' => 'Có ứng dụng di động không?', 'a' => 'Hiện tại chúng tôi đang phát triển ứng dụng di động.']
                        ] as $index => $faq)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                            <button 
                                @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                                class="w-full px-4 py-3 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $faq['q'] }}</span>
                                <i class="fas fa-chevron-down text-gray-500 transition-transform" 
                                   :class="{ 'rotate-180': openFaq === {{ $index }}}"></i>
                            </button>
                            <div x-show="openFaq === {{ $index }}" x-collapse class="px-4 pb-3 text-gray-600 dark:text-gray-300">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Gửi Tin Nhắn</h2>
                {{-- Route contact.submit đã được thêm vào web.php --}}
                <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Họ và Tên <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition">
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Chủ Đề <span class="text-red-500">*</span>
                        </label>
                        <select id="subject" name="subject" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition">
                            <option value="">Chọn chủ đề</option>
                            <option value="support">Hỗ trợ kỹ thuật</option>
                            <option value="partnership">Hợp tác đối tác</option>
                            <option value="feedback">Góp ý</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tin Nhắn <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="6" required
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition"
                                  placeholder="Hãy mô tả chi tiết vấn đề của bạn..."></textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Gửi Tin Nhắn
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection