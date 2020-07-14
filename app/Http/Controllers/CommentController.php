<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Post;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.comment_index');
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

        $comment = Comment::create($attributes);

        $comment = Comment::where('id', $comment->id)->with('user')->first();

        return $comment->toJson();

        // $response = [
        //     'status' => 'success', 
        //     'message' => 'Your comment has been published!'
        // ];

        // try {
        //     Comment::create($attributes);
            
        // } catch (Exception $exception) {
        //     $response = [
        //         'status' => 'error',
        //         'message' => $exception->message
        //     ];
        // }

        // return redirect()->back()->with($response['status'], $response['message']);
    }

    public function showCommentsFromPost(Post $post) 
    {
        return response()->json($post->comments()->with('user')->latest()->get());
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

        $response = [
            'status' => 'success',
            'message' => 'The comment has been successfully approved so now all end-users may see it on the post.'
        ];

        return redirect()->back()->with($response['status'], $response['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $response = [
            'status' => 'success',
            'message' => 'The requested comment has been successfully deleted.'
        ];

        try {
            $comment->delete();
            
        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        } 

        return redirect()->back()->with($response['status'], $response['message']);
    }

    public function getAllComments()
    {
        $commentQuery = Comment::with('post', 'user')
                                    ->where('approved', '=', '0');

        return datatables()->of($commentQuery)->make();
    }
}
