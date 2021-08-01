<?php

namespace App\Providers;

use Illuminate\Broadcasting\BroadcastController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app
            ->get('router')
            ->post('/broadcasting/auth', [BroadcastController::class, 'authenticate'])
            ->middleware('web')
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->name('messenger.getPrivateToken');

        require base_path('routes/channels.php');
    }
}
