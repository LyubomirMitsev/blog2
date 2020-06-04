<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['welcome', 'contact', 'rules', 'post.show', 'post.index', 'profile.show', 'profile.edit', 'auth.register', 'auth.login', 'sign-up'], function ($view) {

            $comments =  \App\Comment::orderBy('created_at', 'desc')
                                    ->where('approved', '!=', 0)
                                    ->take(30)
                                    ->get();

            $view->with('comments', $comments);
        });

        view()->composer(['post.show_admin'], function ($view) {

            $comments =  \App\Comment::orderBy('created_at', 'desc')
                                    ->take(30)
                                    ->get();

            $view->with('comments', $comments);
        });
    }
}
