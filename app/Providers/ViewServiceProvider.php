<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('components.user-list', static function ($view) {
            if (Auth::check()) {
                $view->with('users', User::where('id', '!=', Auth::user()->id)->get());
            } else {
                $view->with('users', []);
            }
        });
    }
}
