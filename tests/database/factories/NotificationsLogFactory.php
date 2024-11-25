<?php

namespace TomatoPHP\FilamentDiscordDriver\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TomatoPHP\FilamentDiscordDriver\Tests\Models\NotificationsLogs;
use TomatoPHP\FilamentDiscordDriver\Tests\Models\NotificationsTemplate;

class NotificationsLogFactory extends Factory
{
    protected $model = NotificationsLogs::class;

    public function definition(): array
    {
        return [
            'model_type' => NotificationsTemplate::class,
            'model_id' => NotificationsTemplate::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['info', 'success', 'warning', 'error']),
            'provider' => $this->faker->randomElement(['email', 'database']),
        ];
    }
}
