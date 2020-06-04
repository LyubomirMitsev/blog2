<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\SetAvatarRequest;

use Image;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        return view('profile.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user(); 

        return view('profile.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request['password'] = Hash::make($request['password']);

        $response = [
            'status' => 'success',
            'message' => 'Your account has successfully been updated'
        ];

        try {
            Auth::user()->update($request->only(['name', 'email', 'password']));

        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        }

        return redirect()->route('profile.show', Auth::user()->id)->with($response['status'], $response['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();

        Auth::logout();

        $response = [
            'status' => 'success',
            'message' => 'Your account has been deleted'
        ];

        try {
            $user->delete();
            
            return redirect()->route('login');

        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        }

        return redirect()->back()->with($response['status'], $response['message']);
    }


    public function updateAvatar(SetAvatarRequest $request)
    {
        $attempt = boolval($request->hasFile('avatar'));

        if( $attempt ){
            $avatar = $request->file('avatar');
            $filename = time() . "." . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
            
            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }
        
        return redirect()->route('profile.show', $user->id);
    }
}
