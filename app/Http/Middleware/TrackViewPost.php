<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Post;

class TrackViewPost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('post_slug');

        $post = Post::where('slug', $slug)->first();

        if ($post && !$request->session()->has("viewed_post_{$post->id}")) {
            $post->increment('views');
            $request->session()->put("viewed_post_{$post->id}", true);
        }
        return $next($request);
    }
}
