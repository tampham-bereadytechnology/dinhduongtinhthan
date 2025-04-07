@extends('layout')

@section('title', 'DinhDuongTinhThan')

@section('description', 'Nơi giúp bạn cân bằng thân – tâm – trí!
Chúng tôi mang đến những bài viết chuyên sâu về sức khỏe tinh thần và dinh dưỡng')

@section('navbar', view('navbar'))
@php
    use App\Models\Category;
    $categories = Category::where('is_published', true)->get();
@endphp

@section('content')
    <div class="bg-gray-100 dark:bg-gray-900">
        <x-two-cols>
            @slot('header')
                <div class="relative w-full h-[70vh]">
                    {{-- Preload hero image --}}
                    <link rel="preload" as="image" href="https://dinhduongtinhthan.com/storage/thumbnails/5eLR9nYr0ZWnlhLXPsz2StfpRngzsi-metaTW9pLW5ndW9pLWNhbi1uYW0tZHVvYy1zdWMta2hvZS10aW5oLXRoYW4tbGEtZ2ktZGUtY28tYmllbi1waGFwLWNhaS10aGllbi1waHUtaG9wLmpwZw==-.webp">
                    <img 
                        loading="eager" 
                        class="w-full h-full object-cover" 
                        src="https://dinhduongtinhthan.com/storage/thumbnails/5eLR9nYr0ZWnlhLXPsz2StfpRngzsi-metaTW9pLW5ndW9pLWNhbi1uYW0tZHVvYy1zdWMta2hvZS10aW5oLXRoYW4tbGEtZ2ktZGUtY28tYmllbi1waGFwLWNhaS10aGllbi1waHUtaG9wLmpwZw==-.webp" 
                        width="1920" 
                        height="1080" 
                        alt="hero-background-image"
                        decoding="async"
                        fetchpriority="high"
                    >
                    <div class="absolute inset-0 w-full h-full bg-[#0a072ad3]"></div>
                    <div class="absolute inset-0 flex flex-col justify-center text-center">
                        <div class="">
                            <h1 class="text-[#6875F5] mb-4 text-4xl font-extrabold tracking-tight md:text-5xl lg:text-6xl">Nơi giúp bạn cân bằng thân – tâm – trí!</h1>
                            <h2 class="mb-6 text-lg font-normal lg:text-xl sm:px-16 xl:px-48 text-gray-300">Chúng tôi mang đến những bài viết chuyên sâu về sức khỏe tinh thần và dinh dưỡng</h2>
                        </div>
                    </div>
                </div>
            @endslot
        
            <!-- Nội dung cột 8 (slot mặc định) -->
            <!-- Những bài post mới nhất -->
            <div class="mb-8">
                <div class="flex justify-between items-center text-left mb-6">
                    <h2 class="text-2xl font-extrabold md:font-3xl text-black dark:text-white inline-block border-b-4 border-purple-500 pb-1">Mới nhất</h2>
                    <span><a href="/latest-posts" class="text-black dark:text-white font-medium hover:text-orange-500 dark:hover:text-orange-500">Xem tất cả</a></span>
                </div>
                <div class="flex flex-wrap mx-[-0.5rem]">
                    @foreach($posts as $post)
                    <div class="w-full md:w-6/12 p-2">
                        <div class="dark:bg-gray-700 shadow-lg rounded-lg bg-white w-full">
                            <div class="relative pt-[62.5%] block overflow-hidden rounded-t-lg">
                                <a href="{{'/' . $post->category->slug . '/' . $post->slug}}"><img loading="lazy" width="100%" height="100%" class="absolute inset-0 w-full h-full object-cover scale-[1.01] hover:scale-105" src="{{env('APP_URL') . '/storage/' . $post->thumbnail}}" alt="{{$post->name}}"></a>
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
            </div>

            <!-- Những bài posts theo từng category -->
            @foreach ($categories as $category)
            <div class="mb-8">
                <div class="flex justify-between mb-6">
                    <h2 class="text-2xl font-extrabold md:font-3xl text-black dark:text-white inline-block border-b-4 border-purple-500 pb-1">{{$category->name}}</h2>
                    <span><a class="text-black dark:text-white font-medium hover:text-orange-500 dark:hover:text-orange-500" href="{{ '/' . $category->slug }}">Xem tất cả</a></span>
                </div>
                <div class="flex flex-wrap mx-[-0.5rem]">
                    @foreach($category->posts()->orderBy('created_at', 'desc')->take(4)->get() as $post)
                    <div class="w-full p-2">
                        <div class="dark:bg-gray-700 shadow-lg rounded-lg bg-white w-full">
                            <div class="flex flex-wrap">
                                <div class="w-full md:w-5/12 lg:w-4/12">
                                    <div class="relative pt-[62.5%] block overflow-hidden rounded-t-lg">
                                        <a href="{{'/' . $post->category->slug . '/' . $post->slug}}"><img loading="lazy" width="100%" height="100%" class="absolute inset-0 w-full h-full object-cover scale-[1.01] hover:scale-105" src="{{env('APP_URL') . '/storage/' . $post->thumbnail}}" alt="{{$post->name}}"></a>
                                        <a class="absolute top-2 left-2 px-2 py-1 z-10 text-sm font-medium text-center text-white rounded-lg bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br" href="{{ '/' . $post->category->slug }}">{{ $post->category->name }}</a>
                                    </div>
                                </div>
                                <div class="p-4 w-full md:w-7-12 lg:w-8/12">
                                    <a href="{{'/' . $post->category->slug . '/' . $post->slug}}">
                                        <h3 class="font-bold hover:text-orange-400 text-xl mb-4 line-clamp-1">{{$post->name}}</h3>
                                    </a>
                                    <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-3">{{$post->description}}</p>
                                    <p class="italic">{{$post->created_at->locale('vi')->isoFormat('dddd, DD-MM-YYYY')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <!-- Nội dung cột 4 (slot aside) -->
            {{-- @slot('aside')
                @include('aside')
            @endslot --}}
        </x-two-cols>
    </div>
@endsection