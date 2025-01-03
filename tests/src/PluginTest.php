<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentDiscordDriver\FilamentDiscordDriverPlugin;

it('registers plugin', function () {
    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        FilamentDiscordDriverPlugin::make(),
    ]);

    expect($panel->getPlugin('filament-discord-driver'))
        ->not()
        ->toThrow(Exception::class);
});
