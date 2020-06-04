<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

use App\Http\Requests\SearchPostRequest;
use App\Helpers\Helper;

class PostSearchController extends Controller
{
    public function search(SearchPostRequest $request) 
    {
        return Helper::searchPostByTitleOrContent($request);
    }
}
