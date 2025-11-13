@extends('layouts.app')

@section('title', 'Cơ Hội Yêu Thích')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-purple-800">Cơ Hội Yêu Thích</h1>
            <a href="{{ route('volunteer.favorites.export') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transition">Export</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($favorites as $fav)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-purple-100 hover:shadow-2xl transition transform hover:-translate-y-1">
                    <img src="{{ $fav->opportunity->cover_image ? asset('storage/'.$fav->opportunity->cover_image) : 'https://placehold.co/400x200?text=Cơ+Hội' }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-purple-800 mb-2">{{ $fav->opportunity->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $fav->opportunity->organization->organization_name }}</p>
                        <p class="text-sm text-gray-700 mb-4 line-clamp-3">{{ $fav->opportunity->description }}</p>
                        <textarea class="w-full p-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 mb-4" placeholder="Ghi chú cá nhân" rows="2">{{ $fav->notes }}</textarea>
                        <div class="flex gap-3">
                            <a href="{{ route('opportunities.show', $fav->opportunity->opportunity_id) }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-xl font-semibold hover:shadow-xl transition flex-1 text-center">Xem chi tiết</a>
                            <form method="POST" action="{{ route('volunteer.favorites.destroy', $fav->favorite_id) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-red-700 transition">Xóa</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-12 text-center text-gray-500">
                    <i class="fas fa-heart-broken text-6xl mb-4 text-purple-300"></i>
                    <p class="text-xl">Chưa có cơ hội yêu thích nào</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $favorites->links() }}
        </div>
    </div>
</div>
@endsection