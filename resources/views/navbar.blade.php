@php
use App\Models\Category;
$categories = Category::where(['is_published' => true])->orderBy('created_at','desc')->get();
@endphp
@foreach ($categories as $category)
<a href="{{'/' . $category->slug}}" class="bg-white dark:bg-gray-800 text-black dark:text-white font-bold hover:bg-secondary-light hover:text-white dark:hover:bg-secondary-dark dark:hover:text-white px-4 py-2 rounded-lg shadow-md transition duration-300">{{$category->name}}</a>
@endforeach
