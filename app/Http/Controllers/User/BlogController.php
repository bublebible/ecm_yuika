<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)->latest()->get();
        return view('user.blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        if (!$post->is_published) {
            abort(404);
        }
        return view('user.blog.show', compact('post'));
    }
}
