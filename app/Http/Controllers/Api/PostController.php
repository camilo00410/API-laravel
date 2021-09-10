<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::included()
                    ->filter()
                    ->sort()
                    ->getOrPaginate();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return auth()->user();

        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts',
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            // 'user_id' => 'required|exists:users,id'
        ]);

        $user = auth()->user();

        $data['user_id'] = $user->id;

        // $posts = Post::create($request->all());
        $posts = Post::create($data);

        return 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $pst = Post::included()
                    ->findOrFail($post->id);
        return PostResource::make($pst);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' =>  'required|max:255',
            'slug' => 'required|max:255|unique:posts, slug, ' . $post->id,
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categires, id',
            // 'user_id' => 'required|exists:users, id'
        ]);

        $post->update($request->all());
        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return PostResource::make($post);
    }
}
