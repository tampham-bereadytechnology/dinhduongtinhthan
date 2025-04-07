@extends('layout')

@section('title', 'Những bài viết mới nhất')

@section('description', 'danh sách những bài viết mới nhất thuộc những chủ đề khác nhau')

@section('navbar', view('navbar'))

@section('content')

<main>
    <div class="w-full lg:max-w-[80%] mt-28 mb-12 mx-auto font-bold text-center">
        <h1 class="mb-2 text-2xl lg:text-4xl font-bold text-primary-600 dark:text-primary-500">Bài viết</h1>
        <h2 class="max-w-[80%] mx-auto font-normal text-gray-700 dark:text-gray-400">Cùng khám phá để hiểu thêm về sức khoẻ và cơ thể của chúng ta</h2>
    </div>
    <div class="container flex flex-wrap mx-auto mt-5">
        {{-- Col-8 --}}
        <div class="w-full mb-8 pr-0 lg:w-8/12 lg:mb-0 lg:pr-4">
            {{-- Những bài post mới nhất --}}
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
            
        </div>
        {{-- Col-4 --}}
        <div class="w-full pl-0 rounded-lg lg:pl-4 lg:w-4/12 mt-[-70px]">
            @include('aside')
        </div>
    </div>
</main>
@endsection