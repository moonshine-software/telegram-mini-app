<?php

declare(strict_types=1);

namespace MoonShine\TlgMiniApp\Providers;

use Illuminate\Support\ServiceProvider;

final class TlgMiniAppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/ms-telegram-mini-app.php' => config_path('ms-telegram-mini-app.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'ms-telegram-mini-app');

        $this->publishes([
            __DIR__ . '/../../dist' => public_path('vendor/ms-telegram-mini-app'),
        ], ['ms-telegram-mini-app-assets', 'laravel-assets']);

        $this->publishesMigrations([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ]);
    }
}
