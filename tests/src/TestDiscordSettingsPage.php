<?php

namespace TomatoPHP\FilamentDiscordDriver\Tests;

use TomatoPHP\FilamentDiscordDriver\Filament\Pages\DiscordSettingsPage;
use TomatoPHP\FilamentDiscordDriver\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can render Discord Settings Page', function () {
    get(DiscordSettingsPage::getUrl())->assertSuccessful();
});
