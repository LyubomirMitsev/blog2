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

Route::get('/', 'BlogPublicController@welcomePage')->name('welcome');

Route::get('/contact', 'BlogPublicController@contactPage')->name('contact');

Route::post('/contact', 'BlogPublicController@postContact')->name('contact.send');

Route::get('/rules', 'BlogPublicController@rulesPage')->name('rules');

Route::get('/posts', 'BlogPublicController@searchPostByTitle')->name('post.search');

Route::get('/posts/{post}', 'BlogPublicController@viewPost')->name('post.view');

Route::get('/posts/category/{category}', 'BlogPublicController@viewPostsFromCategory')->name('post.from.category');

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

    Route::post('/comment', 'CommentController@store')->name('comment.store');

    Route::middleware('role:admin')->group( function () {

        Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

        Route::resource('post', 'PostController')->except([
            'create'
        ]);

        Route::resource('category', 'CategoryController')->except([
            'create'
        ]);

        Route::resource('comment', 'CommentController')->except([
            'create', 'store'
        ]);

        Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');

    });
});
