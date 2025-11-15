@extends('layouts.admin') {{-- Giả sử bạn có layout admin --}}
@section('title', 'Chỉnh sửa Chiến dịch')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Chỉnh sửa: {{ $campaign->title }}</h1>
        <a href="{{ route('admin.campaigns.index') }}" class="btn bg-gray-200 text-gray-700 px-4 py-2 rounded">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    {{-- Hiển thị lỗi validation nếu có --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Có lỗi xảy ra!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT') {{-- Bắt buộc cho việc update --}}
        
        <div class="space-y-4">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $campaign->title) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Nội dung <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $campaign->description) }}</textarea>
                {{-- (Nên thay bằng Rich Text Editor) --}}
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="target_amount" class="block text-sm font-medium text-gray-700">Mục tiêu (VNĐ) <span class="text-red-500">*</span></label>
                    <input type="number" name="target_amount" id="target_amount" value="{{ old('target_amount', $campaign->target_amount) }}" min="1000000" step="100000" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Ngày kết thúc <span class="text-red-500">*</span></label>
                    {{-- Định dạng Y-m-d\TH:i cho datetime-local input --}}
                    <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', $campaign->end_date->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <div>
                <label for="banner_image" class="block text-sm font-medium text-gray-700">Ảnh bìa (Banner)</label>
                <input type="file" name="banner_image" id="banner_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Bỏ trống nếu không muốn thay ảnh mới.</p>
                
                @if($campaign->banner_image_url)
                    <div class="mt-2">
                        <span class="block text-sm font-medium text-gray-700 mb-1">Ảnh hiện tại:</span>
                        <img src="{{ asset('storage/' . $campaign->banner_image_url) }}" alt="Banner" class="w-64 h-auto rounded-md shadow">
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="Active" {{ old('status', $campaign->status) == 'Active' ? 'selected' : '' }}>Đang hoạt động (Active)</option>
                        <option value="Paused" {{ old('status', $campaign->status) == 'Paused' ? 'selected' : '' }}>Tạm dừng (Paused)</option>
                        <option value="Ended" {{ old('status', $campaign->status) == 'Ended' ? 'selected' : '' }}>Đã kết thúc (Ended)</option>
                    </select>
                </div>

                <div class="flex items-center pt-6">
                    <input type="checkbox" name="is_pinned" id="is_pinned" value="1" {{ old('is_pinned', $campaign->is_pinned) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="is_pinned" class="ml-2 block text-sm font-medium text-gray-900">Ghim lên Slider đầu trang?</label>
                </div>
            </div>
            <p class="text-xs text-gray-500 -mt-2">Lưu ý: Nếu bạn ghim chiến dịch này, các chiến dịch đang ghim khác sẽ tự động bị hủy ghim.</p>
        </div>

        <div class="mt-6 flex justify-between">
            {{-- Form Xóa --}}
            <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chiến dịch này vĩnh viễn không?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    <i class="fas fa-trash mr-2"></i>Xóa Chiến dịch
                </button>
            </form>

            <div class="flex justify-end">
                <a href="{{ route('admin.campaigns.index') }}" class="btn bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Hủy</a>
                <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    <i class="fas fa-save mr-2"></i>Cập nhật
                </button>
            </div>
        </div>
    </form>
@endsection