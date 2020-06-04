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
        view()->composer(['partials.sidebar'], function ($view) {

            $comments =  \App\Comment::orderBy('created_at', 'desc')
                                    ->where('approved', '=', 1)
                                    ->take(30)
                                    ->get();

            $view->with('comments', $comments);
        });

        view()->composer(['partials.admin-sidebar'], function ($view) {

            $comments =  \App\Comment::orderBy('created_at', 'desc')
                                    ->take(30)
                                    ->get();

            $view->with('comments', $comments);
        });
    }
}
