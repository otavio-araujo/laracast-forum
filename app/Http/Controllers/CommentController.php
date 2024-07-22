<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {

        $data = $request->validate(['body' => ['required', 'string', 'max:2500']]);

        Comment::create([
            ...$data,
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
        ]);

        return to_route('posts.show', $post);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CommentController $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommentController $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommentController $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommentController $comment)
    {
        //
    }
}
