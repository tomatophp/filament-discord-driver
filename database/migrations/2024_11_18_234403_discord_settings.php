<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('discord.discord_webhook', '');
        $this->migrator->add('discord.discord_error_webhook', '');
        $this->migrator->add('discord.discord_error_webhook_active', false);
    }
};
