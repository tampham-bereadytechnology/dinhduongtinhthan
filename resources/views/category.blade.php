@extends('layout')
@section('title', $category->meta_name)
@section('description', $category->meta_desc)
@section('navbar', view('navbar'))
@section('content')
<x-two-cols>
    @slot('header')
    <div class="w-full lg:max-w-[80%] pt-28 mb-12 mx-auto font-bold text-center">
        <h1 class="mb-2 text-2xl lg:text-4xl font-bold text-primary-600 dark:text-primary-500">Bài viết</h1>
        <h2 class="max-w-[80%] mx-auto font-normal text-gray-700 dark:text-gray-400">Cùng khám phá để hiểu thêm về sức khoẻ và cơ thể của chúng ta</h2>
    </div>
    @endslot
    <div class="mb-8">
        <div class="flex flex-wrap mx-[-0.5rem]">
            @foreach($posts as $post)
            <!--Lastest Post -->
            <div class="w-full md:w-6/12 p-2">
                <div class="dark:bg-gray-700 shadow-lg rounded-lg bg-white w-full">
                    <div class="relative pt-[62.5%] block overflow-hidden rounded-t-lg">
                        <a href="{{'/' . $post->category->slug . '/' . $post->slug}}"><img loading="lazy" class="absolute inset-0 w-full h-full object-cover scale-[1.01] hover:scale-105" src="{{env('APP_URL') . '/storage/' . $post->thumbnail}}" alt="{{$post->name}}"></a>
                        <a class="absolute top-2 left-2 px-2 py-1 z-10 text-sm font-medium text-center text-white rounded-lg bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br" href="{{ '/' . $post->category->slug }}">{{ $post->category->name }}</a>
                    </div>
                    <div class="p-6">
                        <a href="{{'/' . $post->category->slug . '/' . $post->slug}}">
                            <h3 class="font-bold hover:text-orange-400 text-xl mb-4 line-clamp-1">{{$post->name}}</h3>
                        </a>
                        <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">{{$post->description}}</p>
                        <p class="italic">{{$post->created_at->locale('vi')->isoFormat('dddd, DD-MM-YYYY')}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="pagination flex justify-center">
            {{ $posts->links() }}
        </div>
    </div>
    @slot('aside')
        @include('aside')
        <style>
            .aside-part{
                margin-top: 10px;
            }
        </style>
    @endslot
</x-two-cols>
@endsection
    
