<?php

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;

$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->singleton(
    ExceptionHandler::class,
    Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton('files', function ($app) {
    return new Illuminate\Filesystem\Filesystem;
});

$app->register(Illuminate\View\ViewServiceProvider::class);

return $app;