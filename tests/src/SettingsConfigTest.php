<?php

namespace TomatoPHP\FilamentDiscordDriver\Tests;

use Illuminate\Support\Facades\DB;
use TomatoPHP\FilamentDiscordDriver\FilamentDiscordDriverServiceProvider;

function saveDiscordSetting(string $name, mixed $value): void
{
    DB::table('settings')->updateOrInsert(
        ['group' => 'discord', 'name' => $name],
        ['payload' => json_encode($value), 'locked' => false],
    );
}

function bootDiscordProvider(): void
{
    (new FilamentDiscordDriverServiceProvider(app()))->boot();
}

it('loads the error webhook settings saved from the settings hub', function () {
    saveDiscordSetting('discord_error_webhook', 'https://discord.test/errors');
    saveDiscordSetting('discord_error_webhook_active', true);

    bootDiscordProvider();

    expect(config('filament-discord-driver.error-webhook'))->toBe('https://discord.test/errors')
        ->and(config('filament-discord-driver.error-webhook-active'))->toBeTrue();
});

it('loads the main webhook saved from the settings hub', function () {
    saveDiscordSetting('discord_webhook', 'https://discord.test/main');

    bootDiscordProvider();

    expect(config('filament-discord-driver.webhook'))->toBe('https://discord.test/main');
});

it('keeps the env webhook when the setting is empty', function () {
    config()->set('filament-discord-driver.webhook', 'https://discord.test/from-env');
    saveDiscordSetting('discord_webhook', '');

    bootDiscordProvider();

    expect(config('filament-discord-driver.webhook'))->toBe('https://discord.test/from-env');
});
