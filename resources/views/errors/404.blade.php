@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="flex flex-col items-center justify-center h-screen text-center">
    <h1 class="text-6xl font-bold text-red-500">404</h1>
    <p class="mt-4 text-xl text-gray-600">Trang bạn tìm không tồn tại.</p>
    <a href="{{ url('/') }}" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded-lg">Quay lại trang chủ</a>
</div>
@endsection
