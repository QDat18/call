@extends('layouts.admin')

@section('title', 'Xuất báo cáo Cơ hội')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <nav class="text-sm font-medium text-gray-500">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('admin.opportunities.index') }}" class="hover:text-indigo-600">Quản lý Cơ hội</a></li>
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li class="text-gray-900">Xuất báo cáo</li>
        </ol>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="mb-8 text-center">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fas fa-file-excel"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Xuất dữ liệu Cơ hội</h1>
            <p class="text-gray-500 mt-2">Chọn các tiêu chí bên dưới để lọc dữ liệu xuất ra file Excel.</p>
        </div>

        <form action="{{ route('admin.opportunities.download') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Trạng thái</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Active">Đang hoạt động (Active)</option>
                        <option value="Paused">Tạm dừng (Paused)</option>
                        <option value="Completed">Hoàn thành (Completed)</option>
                        <option value="Cancelled">Đã hủy (Cancelled)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Danh mục</label>
                    <select name="category_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Tất cả danh mục</option>
                        {{-- Bạn cần truyền biến $categories từ controller sang view này --}}
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Được tạo từ ngày</label>
                    <input type="date" name="start_date" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Đến ngày</label>
                    <input type="date" name="end_date" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="include_stats" value="1" checked class="w-5 h-5 text-green-600 rounded focus:ring-green-500 border-gray-300">
                    <span class="text-gray-700 font-medium">Bao gồm thống kê (Số đơn, Lượt xem)</span>
                </label>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="flex-1 py-3 px-4 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition shadow-lg shadow-green-200">
                    <i class="fas fa-download mr-2"></i> Tải xuống Excel
                </button>
                <a href="{{ route('admin.opportunities.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection