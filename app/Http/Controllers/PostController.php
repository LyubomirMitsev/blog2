<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Purifier;
use View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['categories', 'comments'])
            ->orderBy('updated_at', 'desc')
            ->paginate(5);

        return view('admin.post_index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        
        return view('admin.post_create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $attributes = $request->validated();

        $attributes['user_id'] = Auth::user()->id;

        $attributes['slug'] = Str::slug($attributes['title'], '-');

        if ($request->status == "publish") {

            $attributes['published_at'] = Carbon::now();

        }

        $response = [
            'status' => 'success', 
            'message' => 'The new post has successfully been saved.'
        ];

        Purifier::clean($attributes['content']);

        try {
            Post::create($attributes)->categories()->sync($request->categories);
            
        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        } 

        return redirect()->route('post.index')->with($response['status'], $response['message']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {        
        return view('post.show_admin', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('admin.post_edit', ['post' => $post, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $attributes = $request->only(['title', 'content']);

        if ($request->status == "publish") {
            $attributes['published_at'] = Carbon::now();
        }

        $response = [
            'status' => 'success',
            'message' => 'The requested post has successfully been updated.'
        ];

        try {
            $post->update($attributes);
            $post->categories()->sync($request->categories);
            
        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        } 

        return redirect()->route('post.index')->with($response['status'], $response['message']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $response = [
            'status' => 'success',
            'message' => 'The requested post has successfully been deleted.'
        ];

        try {
            $post->delete();
            
        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        } 

        return redirect()->route('post.index')->with($response['status'], $response['message']);
    }
}
