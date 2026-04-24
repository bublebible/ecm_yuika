<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.content.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.content.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil dibuat.');
    }

    public function edit(Post $content) // Route uses {content}, so bind this
    {
        return view('admin.content.edit', ['post' => $content]);
    }

    public function update(Request $request, Post $content)
    {
         $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['image']);
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
             if ($content->image) {
                Storage::disk('public')->delete($content->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $content->update($data);

        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy(Post $content)
    {
        if ($content->image) {
            Storage::disk('public')->delete($content->image);
        }
        $content->delete();
        return redirect()->route('admin.content.index')->with('success', 'Konten berhasil dihapus.');
    }
}
