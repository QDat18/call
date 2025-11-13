@extends('layouts.app')

@section('title', 'Ứng Tuyển Cơ Hội')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12 px-4">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-xl p-8 border border-purple-100">
        <h1 class="text-3xl font-bold mb-8 text-center text-purple-800">Ứng Tuyển: {{ $opportunity->title }}</h1>
        
        <form method="POST" action="{{ route('volunteer.applications.store') }}">
            @csrf
            <input type="hidden" name="opportunity_id" value="{{ $opportunity->opportunity_id }}">

            <!-- Motivation Letter -->
            <div class="mb-6">
                <label for="motivation_letter" class="block text-sm font-medium text-purple-700 mb-2">Lý do ứng tuyển</label>
                <textarea name="motivation_letter" id="motivation_letter" rows="4" class="w-full p-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 focus:border-purple-500" required></textarea>
                @error('motivation_letter')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Relevant Experience -->
            <div class="mb-6">
                <label for="relevant_experience" class="block text-sm font-medium text-purple-700 mb-2">Kinh nghiệm liên quan</label>
                <textarea name="relevant_experience" id="relevant_experience" rows="4" class="w-full p-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 focus:border-purple-500" required></textarea>
                @error('relevant_experience')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Availability Note -->
            <div class="mb-8">
                <label for="availability_note" class="block text-sm font-medium text-purple-700 mb-2">Ghi chú thời gian sẵn sàng</label>
                <textarea name="availability_note" id="availability_note" rows="3" class="w-full p-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300 focus:border-purple-500"></textarea>
                @error('availability_note')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:shadow-xl transition transform hover:scale-105">
                    Gửi Đơn Ứng Tuyển
                </button>
            </div>
        </form>
    </div>
</div>
@endsection