{{-- resources/views/volunteer/profile/edit-profile.blade.php --}}
@extends('layouts.app')
@section('title', 'Chỉnh Sửa Hồ Sơ')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .gradient-purple {
            background: linear-gradient(135deg, #8b5cf6, #6b46c1);
        }

        .gradient-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #4facfe);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .field-input {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .field-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.3), 
                        0 0 0 4px rgba(139, 92, 246, 0.1);
        }

        .field-input:hover:not(:focus) {
            border-color: #a78bfa;
            box-shadow: 0 4px 12px -2px rgba(139, 92, 246, 0.15);
        }

        .avatar-container {
            position: relative;
            animation: float 3s ease-in-out infinite;
        }

        .avatar-ring {
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: linear-gradient(45deg, #8b5cf6, #ec4899, #8b5cf6);
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
            z-index: -1;
            opacity: 0.7;
        }

        .camera-button {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
            transition: all 0.3s ease;
        }

        .camera-button:hover {
            transform: scale(1.15) rotate(5deg);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.6);
        }

        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 4px;
            background: linear-gradient(90deg, transparent, #8b5cf6, transparent);
            border-radius: 2px;
        }

        .status-card {
            position: relative;
            overflow: hidden;
        }

        .status-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 3s infinite;
        }

        .tag-badge {
            background: linear-gradient(135deg, #f3e7ff, #e9d5ff);
            border: 2px solid #d8b4fe;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.15);
            transition: all 0.3s ease;
        }

        .tag-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            box-shadow: 0 10px 30px -5px rgba(139, 92, 246, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px -5px rgba(139, 92, 246, 0.6);
        }

        .btn-secondary {
            background: white;
            border: 2px solid #8b5cf6;
            color: #8b5cf6;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.15);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.25);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border-left: 4px solid #10b981;
            animation: slideInRight 0.5s ease;
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-left: 4px solid #ef4444;
            animation: slideInRight 0.5s ease;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .verified-badge {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border: 3px solid #34d399;
        }

        .unverified-badge {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 3px solid #fbbf24;
        }

        .icon-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .7;
            }
        }

        input[type="file"] {
            display: none;
        }

        select option {
            padding: 12px;
        }

        textarea {
            min-height: 120px;
        }

        .divider {
            background: linear-gradient(90deg, transparent, #d8b4fe, transparent);
            height: 2px;
            margin: 40px 0;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .avatar-container {
                animation: float 4s ease-in-out infinite;
            }
            
            .field-input:focus {
                transform: translateY(-1px);
            }
        }

        /* Loading state */
        .loading {
            pointer-events: none;
            opacity: 0.6;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen gradient-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto glass-card rounded-3xl shadow-2xl p-8 md:p-12 overflow-hidden">

            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-4">
                    Chỉnh Sửa Hồ Sơ
                </h1>
                <p class="text-lg md:text-xl text-gray-600">
                    Cập nhật thông tin để kết nối tốt hơn với các cơ hội tình nguyện!
                </p>
            </div>

            <!-- Verification Section -->
            <div class="mb-12">
                <h3 class="section-title text-2xl font-bold text-purple-800 mb-8 text-center">
                    Xác Thực Tài Khoản
                </h3>

                @if (session('success'))
                    <div class="alert-success text-green-700 p-4 rounded-xl mb-6 shadow-lg" role="alert">
                        <p class="font-bold flex items-center">
                            <i class="fas fa-check-circle mr-2"></i> Thành công
                        </p>
                        <p class="ml-6">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert-error text-red-700 p-4 rounded-xl mb-6 shadow-lg" role="alert">
                        <p class="font-bold flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> Lỗi
                        </p>
                        <p class="ml-6">{{ session('error') }}</p>
                    </div>
                @endif

                @if (Auth::user()->is_verified)
                    <div class="verified-badge status-card rounded-3xl p-8 text-center shadow-xl">
                        <i class="fas fa-check-circle text-6xl text-green-500 mb-4 icon-pulse"></i>
                        <h4 class="text-2xl font-bold text-green-800">Tài khoản Đã Xác Thực</h4>
                        <p class="text-gray-700 mt-2">Bạn đã sẵn sàng tham gia các hoạt động tình nguyện!</p>
                    </div>
                @else
                    <div class="unverified-badge status-card rounded-3xl p-8 text-center shadow-xl">
                        <i class="fas fa-exclamation-triangle text-6xl text-yellow-500 mb-4 icon-pulse"></i>
                        <h4 class="text-2xl font-bold text-yellow-800">Tài khoản Chưa Xác Thực</h4>
                        <p class="text-gray-700 mt-2 mb-6">Xác thực email để tăng độ tin cậy và mở khóa tính năng đầy đủ.</p>

                        <form action="{{ route('volunteer.profile.sendOtp') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-8 md:px-10 py-3 md:py-4 rounded-xl font-bold text-base md:text-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-300 flex items-center justify-center mx-auto">
                                <i class="fas fa-paper-plane mr-2"></i> Gửi Mã OTP Xác Thực
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="divider"></div>

            <!-- Edit Form -->
            <form id="profileForm" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Avatar -->
                <div class="text-center mb-10">
                    <div class="avatar-container inline-block group">
                        <div class="avatar-ring"></div>
                        <img id="avatarPreview"
                            src="{{ $profile->user->avatar_url ? asset('storage/' . $profile->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($profile->user->first_name . ' ' . $profile->user->last_name) }}"
                            class="relative z-10 w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-white shadow-2xl transition-transform duration-300 group-hover:scale-105">
                        <label for="avatar"
                            class="camera-button absolute bottom-2 right-2 md:bottom-4 md:right-4 text-white p-3 md:p-4 rounded-full cursor-pointer z-20">
                            <i class="fas fa-camera text-lg md:text-xl"></i>
                            <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)">
                        </label>
                    </div>
                </div>

                <!-- Fields Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <div>
                        <label class="block text-base md:text-lg font-bold text-purple-700 mb-3 flex items-center">
                            <i class="fas fa-briefcase mr-2 text-purple-500"></i> Nghề Nghiệp
                        </label>
                        <input type="text" name="occupation" value="{{ old('occupation', $profile->occupation) }}"
                            class="w-full p-3 md:p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-base md:text-lg field-input"
                            placeholder="Ví dụ: Sinh viên, Kỹ sư...">
                    </div>
                    <div>
                        <label class="block text-base md:text-lg font-bold text-purple-700 mb-3 flex items-center">
                            <i class="fas fa-graduation-cap mr-2 text-purple-500"></i> Trình Độ Học Vấn
                        </label>
                        <select name="education_level"
                            class="w-full p-3 md:p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-base md:text-lg field-input">
                            <option value="">Chọn trình độ</option>
                            <option value="High School" {{ $profile->education_level == 'High School' ? 'selected' : '' }}>
                                Trung học</option>
                            <option value="Diploma" {{ $profile->education_level == 'Diploma' ? 'selected' : '' }}>Cao đẳng
                            </option>
                            <option value="Bachelor" {{ $profile->education_level == 'Bachelor' ? 'selected' : '' }}>Đại học
                            </option>
                            <option value="Master" {{ $profile->education_level == 'Master' ? 'selected' : '' }}>Thạc sĩ
                            </option>
                            <option value="PhD" {{ $profile->education_level == 'PhD' ? 'selected' : '' }}>Tiến sĩ</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-base md:text-lg font-bold text-purple-700 mb-3 flex items-center">
                        <i class="fas fa-user-edit mr-2 text-purple-500"></i> Tiểu Sử
                    </label>
                    <textarea name="bio" rows="5"
                        class="w-full p-3 md:p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none resize-y text-base md:text-lg field-input"
                        placeholder="Giới thiệu ngắn về bản thân và đam mê tình nguyện...">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <div>
                        <label class="block text-base md:text-lg font-bold text-purple-700 mb-3 flex items-center">
                            <i class="fas fa-star mr-2 text-purple-500"></i> Kỹ Năng
                        </label>
                        <input type="text" id="skillsInput"
                            placeholder="Nhập kỹ năng, cách nhau bằng dấu phẩy"
                            class="w-full p-3 md:p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-base md:text-lg field-input">
                        <div id="skillsTags" class="flex flex-wrap gap-3 mt-4"></div>
                    </div>
                    <div>
                        <label class="block text-base md:text-lg font-bold text-purple-700 mb-3 flex items-center">
                            <i class="fas fa-heart mr-2 text-purple-500"></i> Sở Thích
                        </label>
                        <input type="text" id="interestsInput"
                            placeholder="Nhập sở thích, cách nhau bằng dấu phẩy"
                            class="w-full p-3 md:p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-base md:text-lg field-input">
                        <div id="interestsTags" class="flex flex-wrap gap-3 mt-4"></div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col md:flex-row justify-center pt-8 gap-4 md:gap-6">
                    <a href="{{ route('volunteer.profile.profile') }}"
                        class="btn-secondary px-8 md:px-10 py-3 md:py-5 rounded-2xl font-bold text-base md:text-xl transition duration-300 text-center">
                        <i class="fas fa-eye mr-2"></i> Xem Hồ Sơ
                    </a>
                    <button type="submit" id="saveBtn"
                        class="btn-primary text-white px-12 md:px-16 py-3 md:py-5 rounded-2xl font-bold text-base md:text-xl transition duration-300 relative z-10">
                        <i class="fas fa-save mr-2"></i> Lưu Thay Đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Load current skills & interests
            const currentSkills = "{{ $profile->skills }}".split(',').filter(s => s.trim());
            const currentInterests = "{{ $profile->interests }}".split(',').filter(s => s.trim());

            function renderTags(containerId, items) {
                const container = document.getElementById(containerId);
                container.innerHTML = '';
                items.forEach(item => {
                    const tag = document.createElement('span');
                    tag.className = 'tag-badge px-4 py-2 text-purple-800 rounded-full font-semibold';
                    tag.textContent = item.trim();
                    container.appendChild(tag);
                });
            }

            renderTags('skillsTags', currentSkills);
            renderTags('interestsTags', currentInterests);

            // Preview avatar
            function previewAvatar(e) {
                const reader = new FileReader();
                reader.onload = () => document.getElementById('avatarPreview').src = reader.result;
                reader.readAsDataURL(e.target.files[0]);
            }

            // Submit form
            document.getElementById('profileForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const saveBtn = document.getElementById('saveBtn');
                saveBtn.classList.add('loading');
                
                const formData = new FormData(this);
                formData.append('skills', document.getElementById('skillsInput').value);
                formData.append('interests', document.getElementById('interestsInput').value);

                fetch('{{ route('volunteer.profile.update') }}', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                    .then(async r => {
                        if (!r.ok) {
                            const text = await r.text();
                            throw new Error(`HTTP error! status: ${r.status}, response: ${text.substring(0, 200)}`);
                        }
                        return r.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: data.message,
                                timer: 3000,
                                toast: true,
                                position: 'top-end',
                                background: 'linear-gradient(135deg, #8b5cf6, #6366f1)',
                                color: 'white'
                            });
                            setTimeout(() => location.href = '{{ route('volunteer.profile.profile') }}', 1500);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        saveBtn.classList.remove('loading');
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi khi lưu thay đổi: ' + error.message,
                            toast: true,
                            position: 'top-end'
                        });
                    });
            });
        </script>
    @endpush
@endsection