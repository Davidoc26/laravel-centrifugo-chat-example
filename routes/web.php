<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CentrifugoController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MessageController;
use App\Http\Middleware\VerifyCsrfToken;
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

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/messenger', [MainController::class, 'index']);
Route::post('/messenger/gentoken', [CentrifugoController::class, 'generateToken'])
    ->middleware('auth')
    ->withoutMiddleware(VerifyCsrfToken::class)->name('messenger.gentoken');

Route::post('/messenger/auth', [AuthController::class, 'authenticate'])->name('messenger.auth');
Route::post('/messenger/logout', [AuthController::class, 'logout'])->name('messenger.logout');

Route::get('/messenger/{id}', [MainController::class, 'messenger'])->name('messenger')->middleware('auth');

Route::group(['middleware' => 'auth'], static function () {
    Route::post('/messages', [MessageController::class, 'getMessages'])->withoutMiddleware(VerifyCsrfToken::class)->name('messages.get');
    Route::post('/messages/send', [MessageController::class, 'send'])->withoutMiddleware(VerifyCsrfToken::class)->name('messages.send');
});
