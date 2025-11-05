<?php

use MoonShine\TlgMiniApp\Http\Middleware\TelegramAuth;
use Illuminate\Support\Facades\Route;
use MoonShine\Contracts\Core\DependencyInjection\RouterContract;

Route::moonshine(static function () {
    Route::view('/telegram-startapp', 'ms-telegram-mini-app::startapp')
        ->name('telegram-startapp');

    Route::middleware(TelegramAuth::class)->post('/telegram-login', function (RouterContract $router) {
        return response()->json([
            'url' => $router->getEndpoints()->home(),
        ]);
    })->name('telegram-login');
});
