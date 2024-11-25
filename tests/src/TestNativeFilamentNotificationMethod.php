<?php

namespace TomatoPHP\FilamentDiscordDriver\Tests;

use Filament\Notifications\Notification;
use TomatoPHP\FilamentDiscordDriver\Services\DiscordDriver;
use TomatoPHP\FilamentDiscordDriver\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can send notification using Filament Native Notification', function () {
    $user = User::factory()->create();

    Notification::make()
        ->title('Test title')
        ->body('Test body')
        ->icon('heroicon-o-bell')
        ->info()
        ->sendUse($user, DiscordDriver::class);

    assertDatabaseHas('notifications_logs', [
        'title' => 'Test title',
        'description' => 'Test body',
        'provider' => 'discord',
        'type' => 'info',
    ]);

});
