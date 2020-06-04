<?php

namespace App\Helpers;
 
use App\Post;

class Helper{
    
    public static function searchPostByTitleOrContent($request)
    {
        $search = $request['search'];
        
        $posts = Post::where(function($q) use ($search){
                        $q->where('title', 'LIKE', '%' . $search . '%');
                        $q->orWhere('content', 'LIKE', '%' . $search . '%');
                    })
                    ->whereNotNull('published_at')
                    ->orderBy('published_at', 'desc')
                    ->get();

        return view('post.index', ['posts' => $posts]);
    }
};