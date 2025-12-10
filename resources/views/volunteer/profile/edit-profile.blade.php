{{-- resources/views/volunteer/profile/edit-profile.blade.php --}}
@extends('layouts.volunteer')
@section('title', 'Chỉnh Sửa Hồ Sơ')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <style>
        textarea::-webkit-scrollbar {
            width: 8px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #c4b5fd;
            border-radius: 4px;
        }

        .ts-control {
            padding: 0.75rem 1rem !important;
            border-radius: 0.5rem !important;
            border: 1px solid #d1d5db !important;
            background-color: white !important;
            min-height: 48px !important;
        }

        .ts-control:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
            outline: none !important;
        }

        .ts-wrapper.multi .ts-control>div {
            display: inline-flex !important;
        }

        /* Dropdown container */
        .ts-dropdown {
            position: absolute !important;
            z-index: 9999 !important;
            margin-top: 4px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            background: white !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            max-height: 300px !important;
            overflow-y: auto !important;
        }

        .ts-dropdown .option {
            padding: 0.75rem 1rem !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            border-bottom: 1px solid #f3f4f6 !important;
        }

        .ts-dropdown .option:last-child {
            border-bottom: none !important;
        }

        .ts-dropdown .option:hover,
        .ts-dropdown .option.active {
            background-color: #eef2ff !important;
            color: #4f46e5 !important;
        }

        .ts-dropdown .option.selected {
            background-color: #e0e7ff !important;
            color: #4338ca !important;
            font-weight: 500 !important;
        }

        .ts-dropdown .option .highlight {
            background-color: #fef3c7 !important;
            font-weight: 600 !important;
            color: #92400e !important;
        }

        .ts-dropdown::-webkit-scrollbar {
            width: 8px;
        }

        .ts-dropdown::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 0 0.5rem 0.5rem 0;
        }

        .ts-dropdown::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .ts-dropdown::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .ts-control.disabled,
        .ts-control[disabled] {
            background-color: #f9fafb !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
        }

        .ts-wrapper.loading .ts-control::after {
            content: "";
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid #e5e7eb;
            border-top-color: #6366f1;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: translateY(-50%) rotate(360deg);
            }
        }

        .ts-control input::placeholder {
            color: #9ca3af !important;
            font-size: 0.875rem !important;
        }

        @media (max-width: 640px) {
            .ts-dropdown {
                max-height: 200px !important;
            }

            .ts-dropdown .option {
                padding: 0.625rem 0.875rem !important;
                font-size: 0.875rem !important;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $currentCity = '';
        $currentWard = '';

        // Ưu tiên 1: Lấy từ bảng users (nếu bạn đã lưu lúc đăng ký)
        if ($profile->user->city) {
            $currentCity = $profile->user->city;
            $currentWard = $profile->user->ward;
        }
        // Ưu tiên 2: Tách từ preferred_location (Ví dụ: "Xã A, Tỉnh B")
        elseif ($profile->preferred_location) {
            $parts = explode(',', $profile->preferred_location);
            if (count($parts) >= 2) {
                // Phần cuối cùng thường là Tỉnh
                $currentCity = trim(end($parts));
                // Phần đầu là Xã (hoặc ghép các phần trước nếu có quận)
                array_pop($parts);
                $currentWard = trim(implode(',', $parts));
            } else {
                $currentCity = $profile->preferred_location;
            }
        }
    @endphp
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50 py-12 px-4">
        <div class="max-w-5xl mx-auto">

            <div class="text-center mb-10">
                <h1
                    class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-2">
                    Chỉnh Sửa Hồ Sơ
                </h1>
                <p class="text-gray-500 text-lg">Cập nhật đầy đủ thông tin để tăng cơ hội được duyệt</p>
            </div>

            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-purple-100">
                <div class="h-2 bg-gradient-to-r from-purple-500 to-indigo-500"></div>

                <div class="p-8 md:p-12">
                    <form id="profileForm" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col items-center justify-center mb-8">
                            <div class="relative group cursor-pointer">
                                <img id="avatarPreview"
                                    src="{{ $profile->user->avatar_url ? asset('storage/' . $profile->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($profile->user->first_name . ' ' . $profile->user->last_name) }}"
                                    class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-xl group-hover:scale-105 transition duration-300">

                                <label for="avatar"
                                    class="absolute bottom-2 right-2 bg-purple-600 text-white p-3 rounded-full shadow-lg hover:bg-purple-700 transition cursor-pointer">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" id="avatar" name="avatar" accept="image/*" hidden
                                        onchange="previewAvatar(event)">
                                </label>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Họ (Last Name) <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="last_name" value="{{ $profile->user->last_name }}" required
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition"
                                    placeholder="Nguyễn">
                            </div>
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Tên (First Name) <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="first_name" value="{{ $profile->user->first_name }}" required
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition"
                                    placeholder="Văn A">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nghề nghiệp</label>
                                <input type="text" name="occupation" value="{{ $profile->occupation }}"
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition"
                                    placeholder="VD: Sinh viên">
                            </div>

                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nơi ở hiện tại (Tỉnh ->
                                    Xã)</label>

                                <div class="grid grid-cols-1 gap-3">
                                    <div>
                                        <select id="city-select" class="tom-select" placeholder="Chọn Tỉnh/Thành phố...">
                                            <option value="">Chọn Tỉnh/Thành phố</option>
                                        </select>

                                        <input type="hidden" name="city_name" id="city-name-input">
                                    </div>

                                    <div>
                                        <select id="ward-select" class="tom-select" placeholder="Chọn Phường/Xã..."
                                            disabled>
                                            <option value="">Chọn Tỉnh trước</option>
                                        </select>

                                        <input type="hidden" name="ward_name" id="ward-name-input">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-500 mt-2">
                                    Địa chỉ hiện tại: <span
                                        class="font-medium text-purple-600">{{ $profile->preferred_location ?? 'Chưa cập nhật' }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Trình độ học vấn</label>
                                <select name="education_level"
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition">
                                    <option value="">-- Chọn trình độ --</option>
                                    <option value="High School" {{ $profile->education_level == 'High School' ? 'selected' : '' }}>Trung học phổ thông</option>
                                    <option value="Diploma" {{ $profile->education_level == 'Diploma' ? 'selected' : '' }}>Cao
                                        đẳng / Nghề</option>
                                    <option value="Bachelor" {{ $profile->education_level == 'Bachelor' ? 'selected' : '' }}>
                                        Đại học</option>
                                    <option value="Master" {{ $profile->education_level == 'Master' ? 'selected' : '' }}>Thạc
                                        sĩ</option>
                                    <option value="PhD" {{ $profile->education_level == 'PhD' ? 'selected' : '' }}>Tiến sĩ
                                    </option>
                                </select>
                            </div>
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Trường học (Đại học/Cấp 3)</label>
                                <input type="text" name="university" value="{{ $profile->university }}"
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition"
                                    placeholder="VD: Đại học Bách Khoa">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Thời gian rảnh</label>
                                <select name="availability"
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition">
                                    <option value="">-- Chọn thời gian --</option>
                                    <option value="Weekdays" {{ $profile->availability == 'Weekdays' ? 'selected' : '' }}>Ngày
                                        trong tuần</option>
                                    <option value="Weekends" {{ $profile->availability == 'Weekends' ? 'selected' : '' }}>Cuối
                                        tuần</option>
                                    <option value="Flexible" {{ $profile->availability == 'Flexible' ? 'selected' : '' }}>Linh
                                        hoạt</option>
                                    <option value="Full-time" {{ $profile->availability == 'Full-time' ? 'selected' : '' }}>
                                        Toàn thời gian</option>
                                </select>
                            </div>
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Phương tiện di chuyển</label>
                                <select name="transportation"
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition">
                                    <option value="">-- Chọn phương tiện --</option>
                                    <option value="Motorbike" {{ $profile->transportation == 'Motorbike' ? 'selected' : '' }}>
                                        Xe máy</option>
                                    <option value="Car" {{ $profile->transportation == 'Car' ? 'selected' : '' }}>Ô tô
                                    </option>
                                    <option value="Public Transport" {{ $profile->transportation == 'Public Transport' ? 'selected' : '' }}>Phương tiện công cộng</option>
                                    <option value="Walking" {{ $profile->transportation == 'Walking' ? 'selected' : '' }}>Đi
                                        bộ</option>
                                </select>
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tiểu sử / Giới thiệu</label>
                            <textarea name="bio" rows="3"
                                class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition resize-none">{{ $profile->bio }}</textarea>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kinh nghiệm tình nguyện trước
                                đây</label>
                            <textarea name="volunteer_experience" rows="3"
                                class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition resize-none">{{ $profile->volunteer_experience }}</textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="bg-orange-50 rounded-2xl p-6 border border-orange-100">
                                <label class="block text-lg font-bold text-orange-800 mb-2"><i
                                        class="fas fa-tools mr-2"></i> Kỹ năng</label>
                                <p class="text-xs text-orange-600 mb-3">Nhập và cách nhau bằng dấu phẩy (,)</p>

                                <textarea id="skillsInput" name="skills" rows="3"
                                    class="w-full px-4 py-3 bg-white border border-orange-200 rounded-xl focus:ring-2 focus:ring-orange-300 outline-none text-sm">@php
                                        // Giải mã JSON từ DB thành mảng, nếu lỗi thì trả về mảng rỗng
                                        $skillsArr = $profile->skills ?? [];
                                        if (!is_array($skillsArr))
                                            $skillsArr = [];
                                    @endphp
                                                    {{ implode(', ', $skillsArr) }}</textarea>

                                @if(isset($autoSkills) && count($autoSkills) > 0)
                                    <div class="mt-3">
                                        <p class="text-xs font-semibold text-gray-500 mb-2">Gợi ý:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($autoSkills as $skill)
                                                <button type="button" onclick="addTag('skillsInput', '{{ $skill }}')"
                                                    class="px-2 py-1 bg-white border border-orange-200 text-orange-700 text-xs rounded hover:bg-orange-100 transition"><i
                                                        class="fas fa-plus mr-1"></i> {{ $skill }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="bg-pink-50 rounded-2xl p-6 border border-pink-100">
                                <label class="block text-lg font-bold text-pink-800 mb-2"><i class="fas fa-heart mr-2"></i>
                                    Sở thích</label>
                                <p class="text-xs text-pink-600 mb-3">Nhập và cách nhau bằng dấu phẩy (,)</p>

                                <textarea id="interestsInput" name="interests" rows="3"
                                    class="w-full px-4 py-3 bg-white border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-300 outline-none text-sm">@php
                                        $interestsArr = $profile->interests ?? [];
                                        if (!is_array($interestsArr))
                                            $interestsArr = [];
                                    @endphp
                                                {{ implode(', ', $interestsArr) }}</textarea>

                                @if(isset($autoInterests) && count($autoInterests) > 0)
                                    <div class="mt-3">
                                        <p class="text-xs font-semibold text-gray-500 mb-2">Gợi ý:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($autoInterests as $cat)
                                                <button type="button"
                                                    onclick="addTag('interestsInput', '{{ $cat->category_name }}')"
                                                    class="px-2 py-1 bg-white border border-pink-200 text-pink-700 text-xs rounded hover:bg-pink-100 transition"><i
                                                        class="fas fa-plus mr-1"></i> {{ $cat->category_name }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            class="flex flex-col-reverse md:flex-row items-center justify-center gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('volunteer.profile.profile') }}"
                                class="w-full md:w-auto px-8 py-3.5 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition text-center">Hủy
                                bỏ</a>
                            <button type="submit" id="saveBtn"
                                class="w-full md:w-auto px-12 py-3.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl font-bold shadow-lg hover:shadow-purple-400 hover:-translate-y-1 transition duration-300 flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Lưu Thay Đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Hàm thêm tag gợi ý
            function addTag(inputId, value) {
                const input = document.getElementById(inputId);
                let currentVal = input.value.trim();
                if (currentVal.toLowerCase().includes(value.toLowerCase())) return;
                if (currentVal.length > 0 && !currentVal.endsWith(',')) currentVal += ', ';
                input.value = currentVal + value;
            }

            // Xem trước ảnh
            function previewAvatar(e) {
                if (e.target.files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = () => document.getElementById('avatarPreview').src = reader.result;
                    reader.readAsDataURL(e.target.files[0]);
                }
            }

            // Gửi form
            document.getElementById('profileForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const saveBtn = document.getElementById('saveBtn');
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';

                const formData = new FormData(this);

                fetch('{{ route('volunteer.profile.update') }}', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                })
                    .then(r => r.json())
                    .then(data => {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = '<i class="fas fa-save"></i> Lưu Thay Đổi';
                        if (data.success) {
                            Swal.fire({
                                icon: 'success', title: 'Thành công!', text: 'Đã cập nhật hồ sơ.',
                                confirmButtonColor: '#8b5cf6'
                            }).then(() => window.location.href = '{{ route('volunteer.profile.profile') }}');
                        } else {
                            Swal.fire({ icon: 'error', title: 'Lỗi', text: data.message });
                        }
                    })
                    .catch(() => {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = '<i class="fas fa-save"></i> Lưu Thay Đổi';
                        Swal.fire({ icon: 'error', title: 'Lỗi', text: 'Không thể kết nối server.' });
                    });
            });

            // ==========================================
            // CẤU HÌNH DỮ LIỆU MẶC ĐỊNH TỪ SERVER
            // ==========================================
            const CURRENT_CITY_NAME = "{{ $currentCity }}";
            const CURRENT_WARD_NAME = "{{ $currentWard }}";

            const API_PROVINCES = '{{ route('api.locations.provinces') }}';
            const API_WARDS_TEMPLATE = '{{ route('api.locations.wards', ['provinceCode' => ':code']) }}';

            let cityTom, wardTom;

            document.addEventListener('DOMContentLoaded', function () {
                // 1. Khởi tạo Tom Select Tỉnh
                cityTom = new TomSelect('#city-select', {
                    create: false,
                    sortField: { field: 'text', direction: 'asc' },
                    onChange: function (value) {
                        const input = document.getElementById('city-name-input');
                        if (value) {
                            const option = this.options[value];
                            if (input) input.value = option.text;
                            loadWards(value);
                        } else {
                            if (input) input.value = '';
                            resetWardSelect();
                        }
                    }
                });

                // 2. Khởi tạo Tom Select Xã
                wardTom = new TomSelect('#ward-select', {
                    create: false,
                    sortField: { field: 'text', direction: 'asc' },
                    onChange: function (value) {
                        const input = document.getElementById('ward-name-input');
                        if (value) {
                            const option = this.options[value];
                            if (input) input.value = option.text;
                        } else {
                            if (input) input.value = '';
                        }
                    }
                });

                // 3. Bắt đầu tải dữ liệu
                loadProvinces();
            });

            // Hàm tải Tỉnh
            async function loadProvinces() {
                try {
                    const res = await fetch(API_PROVINCES);
                    const json = await res.json();

                    if (json.data) {
                        cityTom.clearOptions();
                        let foundCityCode = null;

                        json.data.forEach(p => {
                            cityTom.addOption({ value: p.code, text: p.name });

                            // Kiểm tra nếu tên tỉnh khớp với dữ liệu đã lưu
                            if (CURRENT_CITY_NAME && p.name.toLowerCase() === CURRENT_CITY_NAME.toLowerCase()) {
                                foundCityCode = p.code;
                            }
                        });

                        // Nếu tìm thấy tỉnh đã lưu, set giá trị (Việc này sẽ trigger onChange -> loadWards)
                        if (foundCityCode) {
                            cityTom.setValue(foundCityCode);
                        }
                    }
                } catch (e) {
                    console.error('Lỗi load tỉnh:', e);
                }
            }

            // Hàm tải Xã
            async function loadWards(provinceCode) {
                resetWardSelect();
                wardTom.settings.placeholder = "Đang tải...";
                wardTom.sync();

                try {
                    const url = API_WARDS_TEMPLATE.replace(':code', provinceCode);
                    const res = await fetch(url);
                    const json = await res.json();

                    if (json.data && json.data.length > 0) {
                        let foundWardCode = null;

                        json.data.forEach(w => {
                            wardTom.addOption({ value: w.code, text: w.name });

                            // Kiểm tra nếu tên xã khớp với dữ liệu đã lưu
                            // (Chỉ chọn nếu tên tỉnh hiện tại cũng khớp với tên tỉnh đã lưu - tránh trùng tên xã ở tỉnh khác)
                            const currentSelectedCityName = document.getElementById('city-name-input').value;

                            if (CURRENT_WARD_NAME &&
                                w.name.toLowerCase() === CURRENT_WARD_NAME.toLowerCase() &&
                                currentSelectedCityName.toLowerCase() === CURRENT_CITY_NAME.toLowerCase()) {
                                foundWardCode = w.code;
                            }
                        });

                        wardTom.enable();
                        wardTom.settings.placeholder = "Chọn Phường/Xã";
                        wardTom.sync();

                        // Nếu tìm thấy xã cũ, set giá trị
                        if (foundWardCode) {
                            wardTom.setValue(foundWardCode);
                        }

                    } else {
                        wardTom.settings.placeholder = "Không tìm thấy xã/phường";
                        wardTom.sync();
                    }
                } catch (e) {
                    console.error('Lỗi load xã:', e);
                    wardTom.settings.placeholder = "Lỗi tải dữ liệu";
                    wardTom.sync();
                }
            }

            function resetWardSelect() {
                wardTom.clear();
                wardTom.clearOptions();
                wardTom.disable();
                wardTom.settings.placeholder = "Chọn Tỉnh trước";
                wardTom.sync();
                const input = document.getElementById('ward-name-input');
                if (input) input.value = '';
            }
        </script>
    @endpush
@endsection