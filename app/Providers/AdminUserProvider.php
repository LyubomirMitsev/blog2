<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class AdminUserProvider implements UserProvider
{
    /**
     * The Admin User Model
     */
    private $model;
    
    /**
     * Create a new admin user provider.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @return void
     */
    public function __construct(\App\User $userModel)
    {
        $this->model = $userModel;
    }

    public function retrieveById($identifier)
    {

    }

    public function retrieveByToken($identifier, $token)
    {

    }

    public function updateRememberToken(Authenticatable $user, $token)
    {

    }

    public function retrieveByCredentials(array $credentials)
    {
        if(empty($credentials)) {
            return;
        }

        $user = \App\User::whereEmail($credentials['email'])->first();
        $user = password_verify($credentials['password'], optional($user)->getAuthPassword()) ? $user : false;
        
        return $user;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if ( $user->isAdmin() ) {
            return (Auth::attempt($credentials));
        }
        return;
    }
}
