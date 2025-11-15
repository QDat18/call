@extends('layouts.admin')
@section('title', 'Tạo Chiến dịch mới')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Tạo Chiến dịch Quyên góp mới</h1>

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

    <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Tiêu đề <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Nội dung <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                {{-- (Nên thay bằng Rich Text Editor) --}}
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="target_amount" class="block text-sm font-medium text-gray-700">Mục tiêu (VNĐ) <span class="text-red-500">*</span></label>
                    <input type="number" name="target_amount" id="target_amount" value="{{ old('target_amount') }}" min="1000000" step="100000" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Ngày kết thúc <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <div>
                <label for="banner_image" class="block text-sm font-medium text-gray-700">Ảnh bìa (Banner) <span class="text-red-500">*</span></label>
                <input type="file" name="banner_image" id="banner_image" accept="image/*" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_pinned" id="is_pinned" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label for="is_pinned" class="ml-2 block text-sm font-medium text-gray-900">Ghim lên Slider đầu trang?</label>
            </div>
            <p class="text-xs text-gray-500">Lưu ý: Nếu bạn ghim chiến dịch này, các chiến dịch đang ghim khác sẽ tự động bị hủy ghim.</p>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.campaigns.index') }}" class="btn bg-gray-200 text-gray-700 px-4 py-2 rounded mr-2">Hủy</a>
            <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded">Tạo Chiến dịch</button>
        </div>
    </form>
@endsection