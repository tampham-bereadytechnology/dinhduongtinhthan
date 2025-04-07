@extends('layout')

@section('title', $find)

@section('description', $find)

@section('navbar', view('navbar'))

@section('content')
<x-two-cols>
    @if ($posts->isEmpty())
    @slot('header')
        <div class="pt-20">
            <div class="text-center">
                <h1 class="text-center text-3xl font-semibold">Không tìm thấy kết quả cho từ khoá: {{$find}}.</h1>
                <a href="/" class="text-2xl underline text-red-400 my-5 block">Click vào đây đề quay lại trang chủ</a>
            </div>
        </div>
    @endslot
    @else
    <h1 class="text-center text-[25px] text-bold py-10">Kết quả tìm kiếm của: {{$find}}</h1>
    <main class="mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
            @foreach ($posts as $post)
            <div class="bg-white dark:bg-gray-700 shadow-lg rounded-lg overflow-hidden transition duration-300 hover:shadow-xl">
                <a href="{{'/' . $post->category->slug . '/' . $post->slug}}"><img src="{{env('APP_URL') . '/storage/' . $post->thumbnail}}" alt="{{$post->name}}" class="w-full h-48 object-cover"></a>
                <div class="p-6">
                    <a href="{{'/' . $post->category->slug . '/' . $post->slug}}">
                        <h2 class="font-bold hover:text-orange-400 text-xl line-clamp-2 mb-4 text-primary-light dark:text-primary-dark">{{$post->name}}</h2>
                    </a>
                    <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">{{$post->description}}</p>
                    <p class="font-bold">{{$post->category->name}}</p>
                    <p class="italic">{{$post->created_at->locale('vi')->isoFormat('dddd, DD-MM-YYYY')}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </main>
    @endif
    <div class="pagination flex justify-center">
        {{ $posts->links() }}
    </div>
</x-two-cols>
@endsection