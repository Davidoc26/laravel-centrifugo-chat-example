<?php

namespace App\Providers;

use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app
            ->get('router')
            ->post('/broadcasting/auth', [BroadcastController::class, 'authenticate'])
            ->withoutMiddleware(VerifyCsrfToken::class);

        require base_path('routes/channels.php');
    }
}
