@extends('layouts.admin')

@section('title', 'Báo Cáo Vi Phạm')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Báo Cáo Vi Phạm (Bài Viết)</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Người báo cáo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lý do</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bài viết bị báo cáo</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($reports as $report)
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $report->user->name ?? 'Người dùng' }}</div>
                        <div class="text-xs text-gray-500">{{ $report->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full font-bold">{{ $report->reason }}</span>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($report->description, 50) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($report->target)
                            <a href="{{ route('posts.show', $report->target->post_id) }}" target="_blank" class="text-indigo-600 hover:underline">
                                {{ Str::limit($report->target->content, 60) }}
                            </a>
                        @else
                            <span class="text-gray-400 italic">Bài viết đã bị xóa</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.reports.handle', $report->report_id) }}" method="POST" class="inline-block">
                            @csrf
                            <input type="hidden" name="action" value="dismiss">
                            <button type="submit" class="text-gray-500 hover:text-gray-700 mr-3 text-sm">Bỏ qua</button>
                        </form>
                        
                        @if($report->target)
                        <form action="{{ route('admin.reports.handle', $report->report_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Xóa bài viết này?')">
                            @csrf
                            <input type="hidden" name="action" value="delete_post">
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-bold">Xóa bài</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Không có báo cáo nào cần xử lý.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $reports->links() }}
    </div>
</div>
@endsection