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
use Session;
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
        $posts = DB::table('posts')
            ->where('deleted_at', null)
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($posts as $post) {
            $author = User::find($post->user_id);
            $categories = Post::find($post->id)->categories;
            $comments = Comment::where('post_id', $post->id)
                ->get();

            $post->author = $author->name;
            $post->comments = $comments;
            $post->categories = $categories;
        }

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $attributes = $request->only(['title', 'content']);

        $attributes['user_id'] = Auth::user()->id;

        $attributes['slug'] = Str::slug($attributes['title'], '-');

        if ($request->status == "publish") {

            $attributes['published_at'] = Carbon::now();

        }

        Purifier::clean($attributes['content']);

        try {
            Post::create($attributes)->categories()->sync(Category::find($request->categories));
            Session::flash('success', 'Post saved successfully!');
        } catch (Exception $exception) {
            Session::flash('error', 'An error occured and the post could not be created.');
        } catch (Error $error) {
            Session::flash('error', 'An error occured and the post could not be created.');
        }

        return redirect()->route('admin.dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        $categories = Post::find($id)->categories;

        $post->categories = $categories;

        return response()->json($post);
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

        try {
            $post->update($attributes);
            $post->categories()->sync(Category::find($request->categories));
            Session::flash('success', 'The requested post has successfully been updated.');
        } catch (Exception $exception) {
            Session::flash('error', 'An error occured and we could not update the requested post!');
        } catch (Error $error) {
            Session::flash('error', 'An error occured and we could not update the requested post!');
        }

        return redirect()->route('admin.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
            Session::flash('success', 'The requested post has been successfully deleted.');
        } catch (Exception $exception) {
            Session::flash('error', 'An error occured and we could not delete the requested post!');
        } catch (Error $error) {
            Session::flash('error', 'An error occured and we could not delete the requested post!');
        }

        return redirect()->route('admin.dashboard');
    }
}
