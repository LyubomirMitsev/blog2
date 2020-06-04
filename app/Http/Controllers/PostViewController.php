<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Session;

class PostViewController extends Controller
{
    public function welcome() 
    {
        $posts = Post::with(['categories', 'comments'])
                            ->where('published_at', '!=', null)
                            ->orderBy('published_at', 'desc')
                            ->paginate(10);
    
        return view('welcome', ['posts' => $posts]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post->published_at == null) {
            abort(404);
        }

        return view('post.show', ['post' => $post]);
    }

    /**
     * Display posts from a specified category
     * 
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function showPostsFromCategory(Category $category)
    {
        $posts = $category->posts->where('published_at', '!=', null)
                                ->sortByDesc('published_at');

        return view('post.index', ['posts' => $posts, 'category' => $category]);
    }
}
