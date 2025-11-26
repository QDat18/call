{{-- resources/views/volunteer/profile/edit-profile.blade.php --}}
@extends('layouts.app')
@section('title', 'Chỉnh Sửa Hồ Sơ')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
    .gradient-purple { background: linear-gradient(135deg, #8b5cf6, #6b46c1); }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl p-10 border border-purple-100">

            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-purple-800 mb-4">Chỉnh Sửa Hồ Sơ</h1>
                <p class="text-xl text-gray-600">Hoàn thiện hồ sơ để nổi bật với tổ chức!</p>
            </div>

            <form id="profileForm" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Avatar -->
                <div class="text-center mb-10">
                    <div class="relative inline-block group">
                        <img id="avatarPreview" src="{{ $profile->user->avatar_url 
                            ? asset('storage/'.$profile->user->avatar_url) 
                            : 'https://ui-avatars.com/api/?name='.urlencode($profile->user->first_name.' '.$profile->user->last_name) }}"
                             class="w-40 h-40 rounded-full object-cover border-8 border-white shadow-2xl ring-4 ring-purple-200">
                        <label for="avatar" class="absolute bottom-4 right-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-4 rounded-full cursor-pointer shadow-2xl hover:shadow-purple-500/50 transform hover:scale-110 transition">
                            <i class="fas fa-camera text-xl"></i>
                            <input type="file" id="avatar" name="avatar" accept="image/*" hidden onchange="previewAvatar(event)">
                        </label>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-lg font-bold text-purple-700 mb-3">Nghề nghiệp</label>
                        <input type="text" name="occupation" value="{{ old('occupation', $profile->occupation) }}" 
                               class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-lg">
                    </div>
                    <div>
                        <label class="block text-lg font-bold text-purple-700 mb-3">Trình độ học vấn</label>
                        <select name="education_level" class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-lg">
                            <option value="">Chọn trình độ</option>
                            <option value="High School" {{ $profile->education_level == 'High School' ? 'selected' : '' }}>Trung học</option>
                            <option value="Diploma" {{ $profile->education_level == 'Diploma' ? 'selected' : '' }}>Cao đẳng</option>
                            <option value="Bachelor" {{ $profile->education_level == 'Bachelor' ? 'selected' : '' }}>Đại học</option>
                            <option value="Master" {{ $profile->education_level == 'Master' ? 'selected' : '' }}>Thạc sĩ</option>
                            <option value="PhD" {{ $profile->education_level == 'PhD' ? 'selected' : '' }}>Tiến sĩ</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-lg font-bold text-purple-700 mb-3">Tiểu sử</label>
                    <textarea name="bio" rows="6" class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none resize-none text-lg">{{ old('bio', $profile->bio) }}</textarea>
                </div>

                <!-- Skills & Interests -->
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-lg font-bold text-purple-700 mb-3">Kỹ năng</label>
                        <input type="text" id="skillsInput" placeholder="Nhập kỹ năng, cách nhau bằng dấu phẩy" 
                               class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-lg">
                        <div id="skillsTags" class="flex flex-wrap gap-3 mt-4"></div>
                    </div>
                    <div>
                        <label class="block text-lg font-bold text-purple-700 mb-3">Sở thích</label>
                        <input type="text" id="interestsInput" placeholder="Nhập sở thích, cách nhau bằng dấu phẩy" 
                               class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-lg">
                        <div id="interestsTags" class="flex flex-wrap gap-3 mt-4"></div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-center pt-8 gap-6">
                    <a href="{{ route('volunteer.profile.profile') }}" 
                       class="bg-white border-2 border-purple-600 text-purple-600 px-10 py-5 rounded-2xl font-bold text-xl hover:bg-purple-50 transition">
                        Xem Hồ Sơ
                    </a>
                    <button type="submit" id="saveBtn" 
                            class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-16 py-5 rounded-2xl font-bold text-xl shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 transition duration-300">
                        Lưu Thay Đổi
                    </button>
                </div>
            </form>
        </div>
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
            tag.className = 'px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 rounded-full font-semibold shadow-md';
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
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('skills', document.getElementById('skillsInput').value);
        formData.append('interests', document.getElementById('interestsInput').value);

        fetch('{{ route('volunteer.profile.update') }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: data.message,
                    timer: 3000,
                    toast: true,
                    position: 'top-end',
                    background: '#8b5cf6',
                    color: 'white'
                });
                setTimeout(() => location.href = '{{ route('volunteer.profile.profile') }}', 1500);
            }
        });
    });
</script>
@endpush
@endsection