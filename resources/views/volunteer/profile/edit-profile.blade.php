{{-- resources/views/volunteer/profile/edit-profile.blade.php --}}
@extends('layouts.volunteer')
@section('title', 'Chỉnh Sửa Hồ Sơ')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        textarea::-webkit-scrollbar {
            width: 8px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #c4b5fd;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
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
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nghề nghiệp</label>
                                <input type="text" name="occupation" value="{{ $profile->occupation }}"
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition"
                                    placeholder="VD: Sinh viên">
                            </div>
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nơi ở hiện tại</label>
                                <input type="text" name="preferred_location" value="{{ $profile->preferred_location }}"
                                    class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-purple-200 focus:border-purple-500 outline-none transition"
                                    placeholder="VD: Hà Nội, Quận Cầu Giấy">
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
                                        $skillsArr = json_decode($profile->skills, true);
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
                                        $interestsArr = json_decode($profile->interests, true);
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
        </script>
    @endpush
@endsection