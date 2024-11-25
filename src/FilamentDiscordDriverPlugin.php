<?php

namespace TomatoPHP\FilamentDiscordDriver;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentAlerts\Services\Concerns\NotificationDriver;
use TomatoPHP\FilamentDiscordDriver\Filament\Pages\DiscordSettingsPage;
use TomatoPHP\FilamentDiscordDriver\Services\DiscordDriver;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;

class FilamentDiscordDriverPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-discord-driver';
    }

    public function register(Panel $panel): void
    {
        if (class_exists(FilamentSettingsHub::class) && $panel->getPlugin('filament-alerts')->useSettingsHub) {
            $panel->pages([
                DiscordSettingsPage::class,
            ]);
        }
    }

    public function boot(Panel $panel): void
    {

        if (class_exists(FilamentSettingsHub::class) && filament('filament-alerts')->useSettingsHub) {
            FilamentSettingsHub::register([
                SettingHold::make()
                    ->label('filament-discord-driver::messages.settings.discord.title')
                    ->icon('bxl-discord')
                    ->page(DiscordSettingsPage::class)
                    ->order(2)
                    ->description('filament-discord-driver::messages.settings.discord.description')
                    ->group('filament-alerts::messages.settings.group'),
            ]);
        }

        FilamentAlerts::register(
            NotificationDriver::make('discord')
                ->label('Discord')
                ->driver(DiscordDriver::class)
        );
    }

    public static function make(): self
    {
        return new FilamentDiscordDriverPlugin;
    }
}
