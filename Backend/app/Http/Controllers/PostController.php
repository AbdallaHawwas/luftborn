<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(["user","category"])->get();
        return response(["posts" => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();  
        $user = $request->user();      
        $post = Post::create([
            'title' => $data["title"],
            'content' => $data["content"],
            'user_id' => $user->id,
            "category_id" => $data["category"] ?? null
        ]);

        return response()->json(["post" => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $postId)
    {
        $post = Post::with(["user","category"])->find($postId);

        return response()->json(["post" => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request,string $postId)
    {
        
        $data = $request->validated();
        $user = $request->user();
        $post = Post::find($postId)->update([
            'title' => $data["title"],
            'content' => $data["content"],
            'user_id' => $user->id,
            "category_id" => $data["category"] ?? null
        ]);

        return response()->json(["post" => $postId]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $postId)
    {
        $post = Post::find($postId)->delete();
        return response("Post Deleted Successfully");
    }
}
