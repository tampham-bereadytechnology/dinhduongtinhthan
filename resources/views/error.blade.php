@extends('layout')

@section('title', 'Error')

@section('description', 'Không tìm thấy nội dung yêu cầu')

@section('navbar', view('navbar'))

@section('content')
<div class="text-center mt-[10%]">
    <h1 class="text-4xl font-semibold">Không tìm thấy nội dung yêu cầu</h1>
    <a href="/" class="text-2xl underline text-red-400 mt-5 block">Click vào đây đề quay lại trang chủ</a>
</div>
@endsection