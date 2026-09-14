<?php

namespace TomatoPHP\FilamentDiscordDriver;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentDiscordDriver\Console\FilamentDiscordDriverInstall;

class FilamentDiscordDriverServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register generate command
        $this->commands([
            FilamentDiscordDriverInstall::class,
        ]);

        // Register Config file
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-discord-driver.php', 'filament-discord-driver');

        // Publish Config
        $this->publishes([
            __DIR__ . '/../config/filament-discord-driver.php' => config_path('filament-discord-driver.php'),
        ], 'filament-discord-driver-config');

        // Register Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish Migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'filament-discord-driver-migrations');
        // Register views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-discord-driver');

        // Publish Views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-discord-driver'),
        ], 'filament-discord-driver-views');

        // Register Langs
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-discord-driver');

        // Publish Lang
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('lang/vendor/filament-discord-driver'),
        ], 'filament-discord-driver-lang');

        // Register Routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

    }

    public function boot(): void
    {
        try {
            // Settings saved from the settings hub win over the env based config, empty settings keep the config value.
            foreach ([
                'webhook' => 'discord_webhook',
                'error-webhook' => 'discord_error_webhook',
                'error-webhook-active' => 'discord_error_webhook_active',
            ] as $config => $setting) {
                $value = setting($setting);

                if (filled($value)) {
                    Config::set("filament-discord-driver.{$config}", $value);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }
}
