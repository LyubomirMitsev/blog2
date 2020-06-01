<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\User;
use App\Post;
use Session;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = DB::table('comments')
                            ->where('deleted_at', null)
                            ->where('approved', 0)
                            ->orderBy('created_at', 'desc')
                            ->get();

        foreach($comments as $comment) {
            $author = User::find($comment->user_id);
            $post = Post::find($comment->post_id);

            $comment->author = $author->name;
            $comment->email = $author->email;
            $comment->post = $post->title;
            $comment->post_slug = $post->slug;
            $comment->avatar = $author->avatar;
        }

        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->only(['content', 'user_id', 'post_id']);

        $response = [
            'status' => 'success', 
            'message' => 'Your comment has been published!'
        ];

        try {
            Comment::create($attributes);
            
        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        }

        Session::flash($response['status'], $response['message']);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $comment = DB::table('comments')
                            ->where('id', $id)
                            ->update(['approved' => 1]);

        Session::flash('success', 'The comment has been successfully approved so now all end-users may see it on the post.');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        $comment->delete();

        Session::flash('success', 'The requested comment has been successfully deleted.');

        return redirect()->back();
    }
}
