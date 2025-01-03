<?php

namespace TomatoPHP\FilamentDiscordDriver\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\Artisan;
use TomatoPHP\FilamentDiscordDriver\Settings\DiscordSettings;
use TomatoPHP\FilamentSettingsHub\Pages\SettingsHub;

class DiscordSettingsPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = DiscordSettings::class;

    public function getTitle(): string
    {
        return trans('filament-discord-driver::messages.settings.discord.title');
    }

    protected function getActions(): array
    {
        return [
            Action::make('back')->url(SettingsHub::getUrl()),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(['default' => 1])->schema([
                TextInput::make('discord_webhook')
                    ->url()
                    ->label(trans('filament-discord-driver::messages.settings.discord.webhook'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("discord_webhook")' : null),
                TextInput::make('discord_error_webhook')
                    ->url()
                    ->label(trans('filament-discord-driver::messages.settings.discord.error_webhook'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("discord_error_webhook")' : null),
                Toggle::make('discord_error_webhook_active')
                    ->label(trans('filament-discord-driver::messages.settings.discord.error_webhook_active'))
                    ->hint(config('filament-alerts.show_hint') ? 'setting("discord_error_webhook_active")' : null),
            ]),
        ];
    }

    public function afterSave(): void
    {
        Artisan::call('cache:clear');
    }
}
