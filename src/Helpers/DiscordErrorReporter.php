<?php

namespace TomatoPHP\FilamentDiscordDriver\Helpers;

use Illuminate\Foundation\Configuration\Exceptions;
use Throwable;
use TomatoPHP\FilamentDiscordDriver\Jobs\NotifyDiscordJob;

class DiscordErrorReporter
{
    public static function make(Exceptions $exceptions): void
    {
        $exceptions->reportable(function (Throwable $e) {
            if (config('filament-discord-driver.error-webhook-active')) {
                try {
                    dispatch(new NotifyDiscordJob([
                        'webhook' => config('filament-discord-driver.error-webhook'),
                        'title' => $e->getMessage(),
                        'message' => collect([
                            'File: ' . $e->getFile(),
                            'Line: ' . $e->getLine(),
                            'Time: ' . \Carbon\Carbon::now()->toDateTimeString(),
                            'Trace: ```' . str($e->getTraceAsString())->limit(2500) . '```',
                        ])->implode("\n"),
                        'url' => url()->current(),
                    ]));
                } catch (\Exception $exception) {
                    // do nothing
                }
            }
        });
    }
}
