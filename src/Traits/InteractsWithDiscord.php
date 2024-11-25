<?php

namespace TomatoPHP\FilamentDiscordDriver\Traits;

use TomatoPHP\FilamentDiscordDriver\Jobs\NotifyDiscordJob;

trait InteractsWithDiscord
{
    public function notifyDiscord(
        string $title,
        ?string $message = null,
        ?string $url = null,
        ?string $image = null,
        ?string $webhook = null
    ): void {
        dispatch(new NotifyDiscordJob([
            'webhook' => $this->webhook ?: $webhook,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'image' => $image,
        ]));
    }
}
