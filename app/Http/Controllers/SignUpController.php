<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session;
use App\UnregisteredUser;
use App\Http\Requests\SignUpRequest;
use App\Helpers\Helper;

class SignUpController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sign-up');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SignUpRequest $request)
    {
        $user = boolval(UnregisteredUser::create( $request->only(['email']) ));

        if( $user )
        {
            Session::flash('success', 'You have successfully signed up. In order to get 
                                        notified whenever a new post is published you 
                                        still need to verify your email. please check your 
                                        email for a verification link.');
        }

        return redirect()->route('sign-up.create');
    }
}
