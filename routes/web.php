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

Route::get('/', 'PostViewController@welcome')->name('welcome');

Route::get('/contact', 'ContactController@contact')->name('contact');

Route::post('/contact', 'ContactController@postContact')->name('contact.send');

Route::get('/rules', 'RuleController@rules')->name('rules');

Route::get('/posts', 'PostSearchController@search')->name('post.search');

Route::get('/posts/{post}', 'PostViewController@show')->name('post.view');

Route::get('/posts/category/{category}', 'PostViewController@showPostsFromCategory')->name('post.from.category');

Route::middleware('guest')->group( function () {

    Route::get('/admin', 'AdminController@showLoginForm')->name('admin.showLoginForm');

    Route::post('/admin', 'AdminController@login')->name('admin.login');
});

Auth::routes(['verify' => true]);

Route::resource('sign-up', 'SignUpController')->only([
    'create', 'store'
]);

Route::middleware('auth')->group( function () {

    Route::middleware('verified')->group( function () {
        
        Route::post('/profile/avatar', 'ProfileController@updateAvatar')->name('profile.avatar');

        Route::resource('profile', 'ProfileController')->only([
            'show', 'edit' , 'update' , 'destroy'
        ]);

        Route::post('/comment', 'CommentController@store')->name('comment.store');
    });

    Route::middleware('role:admin')->group( function () {

        Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

        Route::resource('post', 'PostController');

        Route::resource('category', 'CategoryController')->except([
            'show'
        ]);

        Route::resource('comment', 'CommentController')->except([
            'create', 'store'
        ]);

        Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');

    });
});
