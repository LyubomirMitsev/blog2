<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Comment;
use App\User;
use Session;

use App\Http\Requests\SearchPostRequest;
use App\Http\Requests\SendEmailRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserSendEmail;

class BlogPublicController extends Controller
{
    public function welcomePage() 
    {
        $posts = Post::where('published_at', '!=', null)
                            ->orderBy('published_at', 'desc')
                            ->paginate(10);

        $comments = Comment::orderBy('created_at', 'desc')
                            ->where('approved', '!=', 0)
                            ->take(30)
                            ->get();
    
        return view('welcome', ['posts' => $posts, 'comments' => $comments]);
    }

    public function contactPage() 
    {
        $comments = Comment::orderBy('created_at', 'desc')
                            ->where('approved', '!=', 0)
                            ->take(30)
                            ->get();

        return view('contact', ['comments' => $comments]);
    }

    public function postContact(SendEmailRequest $request)
    {
        $data = $request->only(['your-name', 'your-email', 'your-subject', 'your-message']);
        
        $user = User::role('admin')->get();
        
        $response = [
            'status' => 'success', 
            'message' => 'Your email has successfully been send.'
        ];

        try {
            Mail::to($user)->send(new UserSendEmail($data));
            
        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        }

        Session::flash($response['status'], $response['message']);

        return redirect()->route('contact');
    }

    public function rulesPage() 
    {    
        $comments = Comment::orderBy('created_at', 'desc')
                            ->where('approved', '!=', 0)
                            ->take(30)
                            ->get();

        return view('rules', ['comments' => $comments]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function viewPost(Post $post)
    {
        $comments = Comment::orderBy('created_at', 'desc')
                            ->where('approved', '!=', 0)
                            ->take(30)
                            ->get();

        if($post->published_at == null) {
            abort(404);
        }

        return view('post.show', ['post' => $post, 'comments' => $comments]);
    }

    /**
     * Display posts from a specified category
     * 
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function viewPostsFromCategory(Category $category)
    {
        $posts = $category->posts->where('published_at', '!=', null)
                                ->sortByDesc('published_at');

        $comments = Comment::orderBy('created_at', 'desc')
                            ->where('approved', '!=', 0)
                            ->take(30)
                            ->get();

        return view('post.index', ['posts' => $posts, 'comments' => $comments, 'category' => $category]);
    }

    public function searchPostByTitle(SearchPostRequest $request) 
    {
        $search = $request['search'];
        
        $posts = Post::where([
                        ['published_at', '!=', null],
                        ['title', 'LIKE', '%' . $search . '%']
                    ])
                    ->orWhere([
                        ['published_at', '!=', null],
                        ['content', 'LIKE', '%' . $search . '%']
                    ])
                    ->orderBy('published_at', 'desc')
                    ->get();

        $comments = Comment::orderBy('created_at', 'desc')
                            ->where('approved', '!=', 0)
                            ->take(30)
                            ->get();

        return view('post.index', ['posts' => $posts, 'comments' => $comments]);
    }
}
