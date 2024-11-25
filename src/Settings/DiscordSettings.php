<?php

namespace TomatoPHP\FilamentDiscordDriver\Settings;

use Spatie\LaravelSettings\Settings;

class DiscordSettings extends Settings
{
    public ?string $discord_webhook = null;

    public ?string $discord_error_webhook = null;

    public bool $discord_error_webhook_active = false;

    public static function group(): string
    {
        return 'discord';
    }
}
