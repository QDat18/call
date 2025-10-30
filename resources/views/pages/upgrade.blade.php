@extends('layouts.app')

@section('title', 'Nâng Cấp Tài Khoản - VolunteerConnect')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Nâng Cấp <span class="text-indigo-600 dark:text-indigo-400">Tài Khoản</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Mở khóa toàn bộ tiềm năng với các gói dịch vụ cao cấp của VolunteerConnect. 
                Tối ưu hóa trải nghiệm tình nguyện của bạn.
            </p>
        </div>

        <!-- Pricing Plans -->
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <!-- Free Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Miễn Phí</h3>
                    <div class="mb-4">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">0₫</span>
                        <span class="text-gray-600 dark:text-gray-400">/tháng</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">Phù hợp cho tình nguyện viên mới bắt đầu</p>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Truy cập cơ bản</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Ứng tuyển 5 cơ hội/tháng</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Theo dõi giờ tình nguyện cơ bản</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-times text-gray-400"></i>
                        <span class="text-gray-400">Hồ sơ nổi bật</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-times text-gray-400"></i>
                        <span class="text-gray-400">Phân tích chuyên sâu</span>
                    </li>
                </ul>

                @if(Auth::user()->user_type === 'Volunteer')
                    <button class="w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium py-3 px-6 rounded-lg transition cursor-default">
                        Đang Sử Dụng
                    </button>
                @else
                    <button class="w-full bg-gray-500 text-white font-medium py-3 px-6 rounded-lg transition cursor-not-allowed" disabled>
                        Chỉ Cho Tình Nguyện Viên
                    </button>
                @endif
            </div>

            <!-- Premium Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border-2 border-indigo-500 relative p-8 transform scale-105">
                <div class="absolute top-0 right-0 bg-indigo-500 text-white px-4 py-1 rounded-bl-lg rounded-tr-lg text-sm font-medium">
                    Phổ Biến
                </div>
                
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Premium</h3>
                    <div class="mb-4">
                        <span class="text-4xl font-bold text-indigo-600 dark:text-indigo-400">99.000₫</span>
                        <span class="text-gray-600 dark:text-gray-400">/tháng</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">Hoàn hảo cho tình nguyện viên chuyên nghiệp</p>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Tất cả tính năng Miễn Phí</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Ứng tuyển không giới hạn</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Hồ sơ nổi bật</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Phân tích hoạt động chuyên sâu</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Hỗ trợ ưu tiên</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Chứng nhận tình nguyện nâng cao</span>
                    </li>
                </ul>

                @if(Auth::user()->user_type === 'Volunteer')
                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition transform hover:scale-105">
                        Nâng Cấp Ngay
                    </button>
                @else
                    <button class="w-full bg-gray-500 text-white font-medium py-3 px-6 rounded-lg transition cursor-not-allowed" disabled>
                        Chỉ Cho Tình Nguyện Viên
                    </button>
                @endif
            </div>

            <!-- Organization Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Tổ Chức</h3>
                    <div class="mb-4">
                        <span class="text-4xl font-bold text-gray-900 dark:text-white">199.000₫</span>
                        <span class="text-gray-600 dark:text-gray-400">/tháng</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">Dành cho tổ chức và doanh nghiệp</p>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Đăng tin không giới hạn</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Quản lý tình nguyện viên</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Phân tích hiệu suất</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Hỗ trợ chuyên dụng</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span class="text-gray-600 dark:text-gray-300">Tích hợp API</span>
                    </li>
                </ul>

                @if(Auth::user()->user_type === 'Organization')
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition">
                        Nâng Cấp Ngay
                    </button>
                @else
                    <button class="w-full bg-gray-500 text-white font-medium py-3 px-6 rounded-lg transition cursor-not-allowed" disabled>
                        Chỉ Cho Tổ Chức
                    </button>
                @endif
            </div>
        </div>

        <!-- Feature Comparison -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">So Sánh Tính Năng</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-4 font-semibold text-gray-900 dark:text-white">Tính Năng</th>
                            <th class="text-center py-4 font-semibold text-gray-500 dark:text-gray-400">Miễn Phí</th>
                            <th class="text-center py-4 font-semibold text-indigo-600 dark:text-indigo-400">Premium</th>
                            <th class="text-center py-4 font-semibold text-green-600 dark:text-green-400">Tổ Chức</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                            ['Ứng tuyển cơ hội', '5/tháng', 'Không giới hạn', 'Không giới hạn'],
                            ['Đăng tin tuyển', 'Không', 'Không', 'Không giới hạn'],
                            ['Hồ sơ nổi bật', 'Không', 'Có', 'Có'],
                            ['Phân tích hoạt động', 'Cơ bản', 'Nâng cao', 'Chuyên sâu'],
                            ['Hỗ trợ', 'Tiêu chuẩn', 'Ưu tiên', 'Chuyên dụng'],
                            ['Chứng nhận', 'Cơ bản', 'Nâng cao', 'Tổ chức'],
                            ['Tích hợp API', 'Không', 'Không', 'Có']
                        ] as $feature)
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="py-4 font-medium text-gray-900 dark:text-white">{{ $feature[0] }}</td>
                            <td class="text-center py-4 text-gray-600 dark:text-gray-400">{{ $feature[1] }}</td>
                            <td class="text-center py-4 text-indigo-600 dark:text-indigo-400">{{ $feature[2] }}</td>
                            <td class="text-center py-4 text-green-600 dark:text-green-400">{{ $feature[3] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Câu Hỏi Thường Gặp</h2>
            
            <div class="grid md:grid-cols-2 gap-8" x-data="{ openFaq: null }">
                @foreach([
                    [
                        'q' => 'Làm thế nào để hủy gói premium?', 
                        'a' => 'Bạn có thể hủy bất kỳ lúc nào trong phần cài đặt tài khoản. Sau khi hủy, bạn vẫn có thể sử dụng tính năng premium đến hết chu kỳ thanh toán.'
                    ],
                    [
                        'q' => 'Có hoàn tiền không?', 
                        'a' => 'Chúng tôi cung cấp hoàn tiền trong vòng 14 ngày nếu bạn không hài lòng với dịch vụ.'
                    ],
                    [
                        'q' => 'Thanh toán qua哪些方式?', 
                        'a' => 'Chúng tôi chấp nhận thanh toán qua thẻ ngân hàng, ví điện tử (Momo, ZaloPay) và chuyển khoản ngân hàng.'
                    ],
                    [
                        'q' => 'Có giảm giá cho sinh viên không?', 
                        'a' => 'Có! Sinh viên được giảm 50% cho gói Premium. Vui lòng liên hệ hỗ trợ để xác minh.'
                    ]
                ] as $index => $faq)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                    <button 
                        @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <span class="font-medium text-gray-900 dark:text-white">{{ $faq['q'] }}</span>
                        <i class="fas fa-chevron-down text-gray-500 transition-transform" 
                           :class="{ 'rotate-180': openFaq === {{ $index }}}"></i>
                    </button>
                    <div x-show="openFaq === {{ $index }}" x-collapse class="px-6 pb-4 text-gray-600 dark:text-gray-300">
                        {{ $faq['a'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center mt-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Sẵn Sàng Nâng Cấp?</h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                Tham gia cùng hàng ngàn tình nguyện viên và tổ chức đang tạo ra sự khác biệt
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-lg text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-300 dark:hover:bg-indigo-900/50 transition">
                    <i class="fas fa-question-circle mr-2"></i>
                    Cần Tư Vấn
                </a>
                <button class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition transform hover:scale-105">
                    <i class="fas fa-rocket mr-2"></i>
                    Bắt Đầu Nâng Cấp
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Simple animation for pricing cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.bg-white');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
});
</script>
@endsection