<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\RatePost;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //
    public function home()
    {
        $posts = Post::where(['is_published' => true])->orderBy('created_at', 'desc')->take(4)->get();
        return view('home', compact('posts'));
    }

    public function latestPosts()
    {
        $posts = Post::where('is_published', true)->orderBy('created_at', 'desc')->paginate(8);
        return view('latestPosts', compact('posts'));
    }

    public function getPostByCategory($category_slug, $post_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if (!$category) return view('error');

        $post = Post::where('slug', $post_slug)
            ->where('category_id', $category->id)
            ->first();

        if (!$post) return view('error');
        return view('post', compact('post'));
    }

    public function getCategory($category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if (!$category) return view('error');
        // Phân trang mỗi 12 bài posts
        $posts = $category->posts()->paginate(8);

        if ($posts->isEmpty() && $posts->currentPage() == 1) return abort(404);

        return view('category', compact('posts', 'category'));
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'find' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $find = $request->input('find');
        $posts = Post::where('name', 'like', "%$find%")
            ->orWhere('description', 'like', "%$find%")
            ->orWhere('content', 'like', "%$find%")
            ->paginate(9);
        return view('result', compact('posts', 'find'));
    }

    public function ratingPost(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return response()->json(['error' => 'Không có dữ liệu gửi lên'], 400);
        }
        // check cookie để đảm bảo không bị lặp lại cùng một cookie lại được đánh giá bài viết nhiều lần!
        if ($request->cookie("rated_post_{$data['post_id']}")) {
            return response()->json(['message' => 'Bạn đã đánh giá trước đó']);
        }
        $save = RatePost::create([
            'post_id' => $data['post_id'],
            'post_category' => $data['category'],
            'rating_stars' => $data['rating'],
        ]);

        if (!$save) {
            return response()->json(['error' => 'Không lưu được vào database']);
        }
        return response()->json(['success' => true])->cookie("rated_post_{$data['post_id']}", true, 60 * 24);
    }
}
