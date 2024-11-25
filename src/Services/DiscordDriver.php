<?php

namespace TomatoPHP\FilamentDiscordDriver\Services;

use TomatoPHP\FilamentAlerts\Services\Drivers\Driver;
use TomatoPHP\FilamentDiscordDriver\Jobs\NotifyDiscordJob;

class DiscordDriver extends Driver
{
    public function setup(): void
    {
        // TODO: Implement setup() method.
    }

    public function sendIt(
        string $title,
        string $model,
        int | string | null $modelId = null,
        ?string $body = null,
        ?string $url = null,
        ?string $icon = null,
        ?string $image = null,
        ?string $type = 'info',
        ?string $action = 'system',
        ?array $data = [],
        ?int $template_id = null
    ): void {
        dispatch(new NotifyDiscordJob([
            'title' => $title,
            'message' => $body,
            'url' => $url,
            'webhook' => config('filament-discord-driver.webhook'),
            'image' => $image,
        ]));
    }
}
