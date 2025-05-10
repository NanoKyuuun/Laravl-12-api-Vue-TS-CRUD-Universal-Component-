<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            if ($post->thumbnail) {
                $post->thumbnail = asset('storage/public/post/' . $post->thumbnail);
            }
        }
        return response()->json([
            'posts' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fileName = null;
        if ($request->file('thumbnail')) {
            $fileName = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $request->file('thumbnail')->storeAs('public/post', $fileName);
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'thumbnail' => $fileName,
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return response()->json([
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('thumbnail')) {
            Storage::delete('public/post/' . $post->thumbnail);
            $fileName = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $request->file('thumbnail')->storeAs('public/post', $fileName);
            $post->thumbnail = $fileName;
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'thumbnail' => $post->thumbnail,
        ]);

        if ($post->thumbnail) {
            $post->thumbnail = asset('storage/post/' . $post->thumbnail);
        }

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'thumbnail' => $post->thumbnail ? asset('storage/post/' . $post->thumbnail) : null
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->thumbnail) {
            Storage::delete('public/post/' . $post->thumbnail);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
        ]);
    }
}
