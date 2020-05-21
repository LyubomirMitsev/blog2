<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group( function () {

    Route::resource('sign-up', 'SignUpController')->only([
        'create', 'store'
    ]);

    Route::get('/admin', 'AdminController@showLoginForm')->name('admin.showLoginForm');

    Route::post('/admin', 'AdminController@login')->name('admin.login');
});

Auth::routes();

Route::middleware('auth')->group( function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::post('/profile/avatar', 'ProfileController@update_avatar')->name('profile.avatar');

    Route::resource('profile', 'ProfileController')->only([
        'show', 'edit' , 'update' , 'destroy'
    ]);


    Route::middleware('role:admin')->group( function () {

        Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    });
});
