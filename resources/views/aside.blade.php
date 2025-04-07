@php
    use App\Models\Post;
    use App\Models\Category;
    $posts_aside = Post::where('is_published', true)->orderBy('views', 'desc')->take(7)->get();
    $categories = Category::where('is_published', true)->get();
@endphp

{{-- Những bài posts phổ biến  --}}
<div class="aside-part mt-0 lg:mt-20 h-fit shadow-lg dark:bg-gray-700 rounded-lg">
    <div class="p-6">
        <div>
            <h3 class="text-2xl font-bold text-black dark:text-white inline-block border-b-4 border-purple-500 pb-1">Phổ biến</h3>
        </div>
        <div class="w-full">
            @foreach ($posts_aside as $post)
                <div class="flex items-center w-full mt-8">
                    <div class="w-4/12 pr-2">
                        <div class="relative w-full pt-[62.5%] rounded-md overflow-hidden">
                            <a href="{{'/' . $post->category->slug . '/' . $post->slug }}">
                                <img width="100%" height="100%" loading="lazy" class="absolute inset-0 w-full h-full hover:scale-105" src="{{'/storage/' . $post->thumbnail }}" alt="{{ $post->name }}">
                            </a>
                        </div>
                    </div>
                    <div class="w-8/12">
                        <a href="{{'/' . $post->category->slug . '/' . $post->slug }}">
                            <h4 class="font-bold line-clamp-2 hover:text-orange-400">{{ $post->name }}</h4>
                        </a>
                        <span>{{$post->created_at->format('d-m-Y')}}</span>
                    </div>
                </div>
                <hr class="my-4 border-gray-200 sm:mx-auto dark:border-gray-500">
            @endforeach
        </div>
    </div>
</div>
{{-- Những chủ đề của web --}}
<div class="mt-10 mb-10 h-fit shadow-lg dark:bg-gray-700 rounded-lg">
    <div class="p-6">
        <div>
            <h3 class="text-2xl font-bold text-black dark:text-white inline-block border-b-4 border-purple-500 pb-1">Chủ đề</h3>
        </div>
        <ul class="w-full mt-5">
            @foreach ($categories as $category)
            <li class="flex justify-between">
                <a href="{{ '/' . $category->slug }}" class="flex items-center font-bold hover:text-orange-500 group">
                    <i class="mr-4 group-hover:translate-x-1 text-xs transition-all fa-solid fa-chevron-right"></i>
                    {{ $category->name }}
                </a>
                <span class="text-gray-400">({{$category->posts->count()}})</span>
            </li>
            <hr class="my-2 border-gray-200 sm:mx-auto dark:border-gray-500">
            @endforeach
        </ul>
    </div>
</div>