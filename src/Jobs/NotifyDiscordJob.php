<?php

namespace TomatoPHP\FilamentDiscordDriver\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use TomatoPHP\FilamentAlerts\Models\NotificationsLogs;

class NotifyDiscordJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public ?string $webhook;

    public ?string $title;

    public ?string $message;

    public ?string $url;

    public ?string $image;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $arg)
    {
        $this->webhook = $arg['webhook'];
        $this->title = $arg['title'];
        $this->message = $arg['message'] ?? null;
        $this->url = $arg['url'] ?? null;
        $this->image = $arg['image'] ?? null;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $embeds = [];
        if ($this->message) {
            $embeds = [
                'title' => $this->title,
                'description' => $this->message,
            ];
        }

        if ($this->url && ! $this->message) {
            $embeds = [
                'title' => $this->title,
            ];
        }

        if ($this->url) {
            $embeds['url'] = $this->url;
        }

        if ($this->image) {
            $embeds['image'] = [
                'url' => $this->image,
            ];
        }

        if (count($embeds) > 0) {
            $params = [
                'content' => '@everyone',
                'embeds' => [
                    $embeds,
                ],
            ];
        } else {
            $params = [
                'content' => $this->title,
            ];
        }

        Http::post($this->webhook ?: config('filament-discord-driver.webhook'), $params)->json();

        $log = new NotificationsLogs;
        $log->title = $this->title;
        $log->description = $this->message;
        $log->provider = 'discord';
        $log->type = 'info';
        $log->save();
    }
}
