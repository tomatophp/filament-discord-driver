<?php

namespace TomatoPHP\FilamentDiscordDriver;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentDiscordDriverPlugin implements Plugin
{

    public function getId(): string
    {
        return 'filament-discord-driver';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): self
    {
        return new FilamentDiscordDriverPlugin;
    }
}
