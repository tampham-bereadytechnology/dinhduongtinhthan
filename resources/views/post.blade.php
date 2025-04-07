@extends('layout')

@section('title', $post->meta_name)

@section('description', $post->meta_desc)

@section('navbar', view('navbar'))
@php
    use App\Models\Post;
// {{-- Query and show relative posts --}}
    $posts_relative = Post::where(['is_published' => true, 'category_id' => $post->category->id])->orderBy('created_at', 'desc')->take(5)->get();
@endphp

@section('content')
<x-two-cols>
    <h1 class="mt-10 text-3xl md:text-4xl leading-tight md:leading-[50px] font-bold dark:text-white mb-5">{{$post->name}}</h1>
    {{-- Created_At --}}
    <p class="font-semibold italic capitalize mb-5">{{$post->created_at->locale('vi')->isoFormat('dddd, DD-MM-YYYY')}}</p>
    <!-- Post content -->
    <div class="prose prose-lg max-w-none dark:prose-invert text-justify leading-[40px]">
        {!!$post->content!!}
        <style>
            .prose img{
                padding: 10px 0;
                max-width: 100%;
                height: auto;
            }
            .prose h2{
                font-weight: bold;
                font-size: 22px;
                padding: 10px 0;
            }
            .prose h3{
                font-weight: bold;
                font-size: 20px;
                padding: 10px 0;
            }
            .prose h4{
                font-weight: bold;
                font-size: 18px;
                padding: 10px 0;
            }
            .prose p{
                font-size: 16px;
            }
        </style>
        {{-- Rating Post --}}
        <hr class="h-[2px] my-5 bg-gray-300 dark:bg-gray-700">
        <div class="rating">
            <p class="font-medium">Đánh giá bài viết</p>
            <p id="rating-result" class="font-medium mb-3"></p>
            <i class="star hover:cursor-pointer text-yellow-400 text-[25px] far fa-star"></i>
            <i class="star hover:cursor-pointer text-yellow-400 text-[25px] far fa-star"></i>
            <i class="star hover:cursor-pointer text-yellow-400 text-[25px] far fa-star"></i>
            <i class="star hover:cursor-pointer text-yellow-400 text-[25px] far fa-star"></i>
            <i class="star hover:cursor-pointer text-yellow-400 text-[25px] far fa-star"></i>
            <p id="rating-message" class="font-medium"></p>
        </div>
        <hr class="h-[2px] my-5 bg-gray-300 dark:bg-gray-700">

        <!-- Related posts section - visible on all screen sizes but only within article on larger screens -->
        <div class="md:block mb-20 dark:bg-gray-700 rounded-lg p-5 shadow-lg">
            <h2 class="mb-5 font-bold text-2xl md:text-3xl">Các bài viết cùng chủ đề</h2>
            <div class="relative-posts flex flex-col gap-6 md:gap-10">
                @foreach ($posts_relative as $post)
                    <div class="flex flex-col sm:flex-row items-start sm:items-center">
                        <figure class="flex-none mb-3 sm:mb-0">
                            <a href="{{ '/' . $post->category->slug . '/' . $post->slug }}">
                                <img width="100%" height="100%" class="aspect-[16/15] w-full sm:w-[160px] h-auto object-cover hover:scale-110 hover:cursor-pointer transition-transform" src="{{ env('APP_URL') . '/storage/' . $post->thumbnail }}" alt="{{ $post->name }}" loading="lazy">
                            </a>
                        </figure>
                        <div class="sm:pl-4">
                            <p class="italic text-gray-500 text-sm">{{ $post->created_at->locale('vi')->isoFormat('dddd, DD-MM-YYYY') }}</p>
                            <a href="{{ '/' . $post->category->slug . '/' . $post->slug }}">
                                <h3 class="font-semibold text-[10px] lg:text-lg py-1 leading-6 hover:text-sky-500 hover:cursor-pointer">{{$post->name}}</h3>
                            </a>
                            <p class="line-clamp-2 text-gray-500 text-sm leading-6">{{$post->description}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-two-cols>



<script>
    const ratingStars = document.getElementsByClassName('star');
    function highlightStar (index) {
        for (let j = 0; j <= index; j++) {
            ratingStars[j].classList.remove('far');
            ratingStars[j].classList.add('fas');
        }
        for (let j = index + 1; j < ratingStars.length; j++) {
            ratingStars[j].classList.remove('fas');
            ratingStars[j].classList.add('far');
        }
    }
    function resetStar () {
        for (j = 0; j < ratingStars.length; j++) {
            ratingStars[j].classList.remove('fas');
            ratingStars[j].classList.add('far');
        }
    }
    for (let i = 0; i < ratingStars.length; i++) {
        selectedStar = 0;
        ratingStars[i].addEventListener('mouseenter', () => {
            highlightStar(i);
        })
        ratingStars[i].addEventListener('mouseleave', () => {
            if (selectedStar === 0 ){
                resetStar();
            } else {
                highlightStar(selectedStar - 1);
            }
        })
        ratingStars[i].addEventListener('click', () => {
            selectedStar = i + 1;
            fetch("/rate-post", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    post_id: {{$post->id}},
                    rating: selectedStar,
                    category: "{{ $post->category->slug }}",
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('rating-result').innerText = `Xếp hạng: ${selectedStar} sao / 5 sao`;
                    document.getElementById('rating-message').innerText = `Bạn đã đánh giá ${selectedStar}  sao thành công`;
                } else {
                    document.getElementById('rating-message').innerText = data.message;
                }
            })
            .catch(error => {
                console.log('Lỗi fetch: ', error);
                document.getElementById('rating-result').innerText = 'Có lỗi xảy ra.'
            });
        });
    }
</script>
<!-- End Content -->
@endsection

