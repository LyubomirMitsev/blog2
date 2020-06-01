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
        Auth::user()->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->route('profile.show', Auth::user()->id);
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

        try {
            $user->delete();
            
            session()->flash('success', 'Your account has been deleted');

            return redirect()->route('login');

        } catch (Exception $exception) {
            Session::flash('error', 'An error occured and your profile was not deleted.');
        } catch (Error $error) {
            Session::flash('error', 'An error occured and your profile was not deleted.');
        }

        return redirect()->back();
    }


    public function update_avatar(SetAvatarRequest $request)
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
