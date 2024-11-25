<?php

namespace TomatoPHP\FilamentDiscordDriver\Tests;

use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;
use TomatoPHP\FilamentDiscordDriver\Services\DiscordDriver;
use TomatoPHP\FilamentDiscordDriver\Tests\Models\NotificationsTemplate;
use TomatoPHP\FilamentDiscordDriver\Tests\Models\User;

use function Pest\Laravel\assertDatabaseHas;

it('can use FilamentAlerts Facade To Notify User Discord Message', function () {
    $user = User::factory()->create();
    $template = NotificationsTemplate::factory()->create();

    FilamentAlerts::notify($user)
        ->template($template->id)
        ->drivers([DiscordDriver::class])
        ->title([
            'name' => $user->name,
        ])
        ->body([
            'date' => now()->toDateTimeString(),
        ])
        ->send();

    assertDatabaseHas('notifications_logs', [
        'title' => $template->title,
        'description' => $template->body,
        'provider' => 'discord',
        'type' => 'info',
    ]);
});
