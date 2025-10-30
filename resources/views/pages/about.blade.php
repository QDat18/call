@extends('layouts.app')

@section('title', 'Giới Thiệu - VolunteerConnect')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                Về <span class="text-indigo-600 dark:text-indigo-400">VolunteerConnect</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Nền tảng kết nối tình nguyện viên với các tổ chức phi lợi nhuận, 
                cùng tạo ra những thay đổi tích cực cho cộng đồng.
            </p>
        </div>

        <!-- Mission & Vision -->
        <div class="grid md:grid-cols-2 gap-12 mb-16">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-bullseye text-2xl text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Sứ Mệnh</h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Kết nối mọi người với các cơ hội tình nguyện phù hợp, 
                    tạo điều kiện cho các tổ chức tìm được tình nguyện viên tài năng, 
                    và cùng nhau xây dựng một cộng đồng vững mạnh hơn.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-eye text-2xl text-purple-600 dark:text-purple-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tầm Nhìn</h3>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    Trở thành nền tảng kết nối tình nguyện hàng đầu tại Việt Nam, 
                    nơi mọi người đều có thể tìm thấy cơ hội đóng góp cho cộng đồng 
                    và phát triển bản thân thông qua các hoạt động ý nghĩa.
                </p>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-16">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl md:text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-2" id="volunteerCount">0</div>
                    <div class="text-gray-600 dark:text-gray-300">Tình Nguyện Viên</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-bold text-green-600 dark:text-green-400 mb-2" id="opportunityCount">0</div>
                    <div class="text-gray-600 dark:text-gray-300">Cơ Hội</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2" id="organizationCount">0</div>
                    <div class="text-gray-600 dark:text-gray-300">Tổ Chức</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2" id="hourCount">0</div>
                    <div class="text-gray-600 dark:text-gray-300">Giờ Tình Nguyện</div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Giá Trị Cốt Lõi</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Tận Tâm</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Chúng tôi tin vào sức mạnh của sự tận tâm và cam kết trong mọi hoạt động tình nguyện.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Kết Nối</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Tạo ra những kết nối ý nghĩa giữa tình nguyện viên và tổ chức vì mục đích chung.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Minh Bạch</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Đảm bảo tính minh bạch trong mọi hoạt động và giao dịch trên nền tảng.
                    </p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Đội Ngũ Phát Triển</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                        TN
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Trần Nam</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 mb-2">Founder & CEO</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Với 5 năm kinh nghiệm trong lĩnh vực công nghệ và tình nguyện.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-green-400 to-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                        ML
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Minh Long</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 mb-2">CTO</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Chuyên gia phát triển phần mềm và hệ thống quy mô lớn.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                        HA
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Hồng Anh</h3>
                    <p class="text-indigo-600 dark:text-indigo-400 mb-2">Head of Community</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Chuyên gia kết nối cộng đồng và phát triển quan hệ đối tác.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Animated counter
function animateCounter(elementId, target, duration = 2000) {
    const element = document.getElementById(elementId);
    let start = 0;
    const increment = target / (duration / 16);
    
    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            element.textContent = target.toLocaleString();
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(start).toLocaleString();
        }
    }, 16);
}

// Start counters when page loads
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        animateCounter('volunteerCount', 12500);
        animateCounter('opportunityCount', 850);
        animateCounter('organizationCount', 320);
        animateCounter('hourCount', 250000);
    }, 500);
});
</script>
@endsection