<?php

namespace App\Helpers;
 
use App\Post;

class Helper {
    
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

    public static function handleRecaptchaVerification($request)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
                'secret' => '6LdbawEVAAAAAF6idHjtJvpa8g6ASf1hv8KbdS68',
                'response' => $request->get('recaptcha'),
                'remoteip' => $remoteip
            ];
        $options = [
                'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
                ]
            ];
        $context = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                $resultJson = json_decode($result);

        if ($resultJson->success != true) {
                return back()->withErrors(['captcha' => 'ReCaptcha Error']);
                }
        if ($resultJson->score <= 0.3) {
                
                return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        }
    }
};