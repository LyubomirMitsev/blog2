<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Post;
use App\Category;
use App\Comment;
use App\User;
use App\UnregisteredUser;
use Session;

class PostViewController extends Controller
{
    public function welcome(Request $request) 
    {
        if( $request->has('hashedEmail') ) {

            $response = [
                'status' => 'success', 
                'message' => 'Your email has been varified! You will recieve an email to notify you 
                                whenever a new post is published.'
            ];

            try{
                $email = decrypt($request->hashedEmail);

                $userToBeVerified = UnregisteredUser::where('email', $email)->first();

                $userToBeVerified->markEmailAsVerified();

                $userToBeVerified->save();

            } catch (DecryptException $exception) {
                $response = [
                    'status' => 'error',
                    'message' => 'The hash code given is invalid'
                ];
            } catch (Exception $exception) {
                $response = [
                    'status' => 'error',
                    'message' => $exception->message
                ];
            }

            Session::flash($response['status'], $response['message']);
        }
        
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

    public function getComments(Post $post) 
    {
        return view('partials.commentlist', ['post' => $post]);
    }
}
