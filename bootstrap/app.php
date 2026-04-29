<?php

use App\Jobs\ReportExceptionToGithub;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn() => url(env('APP_URL') . '/login'));

        $middleware->statefulApi();
        $middleware->throttleApi();

        $middleware->alias([
            'apply_locale' => \App\Http\Middleware\ApplyLocale::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (Throwable $e) {
                // Ignorar validaciones, 404 y ViteException (deprecado: ViteManifestNotFoundException)
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return;
                };
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    return;
                };
                if ($e instanceof \Illuminate\Foundation\ViteException) {
                    return;
                };
                if ($e instanceof \Spatie\LaravelIgnition\Exceptions\ViewException && $e->getPrevious() instanceof \Illuminate\Foundation\ViteException) {
                    return;
                };
                \App\Jobs\ReportExceptionToGithub::dispatch($e);
        });
    })->create();
