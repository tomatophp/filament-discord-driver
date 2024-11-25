![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-discord-driver/master/art/3x1io-tomato-discord-driver.jpg)

# Filament Discord Driver

[![Dependabot Updates](https://github.com/tomatophp/filament-discord-driver/actions/workflows/dependabot/dependabot-updates/badge.svg)](https://github.com/tomatophp/filament-discord-driver/actions/workflows/dependabot/dependabot-updates)
[![PHP Code Styling](https://github.com/tomatophp/filament-discord-driver/actions/workflows/fix-php-code-styling.yml/badge.svg)](https://github.com/tomatophp/filament-discord-driver/actions/workflows/fix-php-code-styling.yml)
[![Tests](https://github.com/tomatophp/filament-discord-driver/actions/workflows/tests.yml/badge.svg)](https://github.com/tomatophp/filament-discord-driver/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-discord-driver/version.svg)](https://packagist.org/packages/tomatophp/filament-discord-driver)
[![License](https://poser.pugx.org/tomatophp/filament-discord-driver/license.svg)](https://packagist.org/packages/tomatophp/filament-discord-driver)
[![Downloads](https://poser.pugx.org/tomatophp/filament-discord-driver/d/total.svg)](https://packagist.org/packages/tomatophp/filament-discord-driver)

Discord Server WebHook Notification for [Filament Alerts Sender](https://github.com/tomatophp/filament-alerts)

## Screenshots

![Preview](https://raw.githubusercontent.com/tomatophp/filament-discord-driver/master/art/preview.png)
![Setting Hub](https://raw.githubusercontent.com/tomatophp/filament-discord-driver/master/art/setting-hub.png)
![Settings](https://raw.githubusercontent.com/tomatophp/filament-discord-driver/master/art/settings.png)
![Driver](https://raw.githubusercontent.com/tomatophp/filament-discord-driver/master/art/driver.png)

## Installation

```bash
composer require tomatophp/filament-discord-driver
```
after install your package please run this command

```bash
php artisan filament-discord-driver:install
```

finally register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugin(\TomatoPHP\FilamentDiscordDriver\FilamentDiscordDriverPlugin::make())
```


## Usage

to set up any model to get notifications you

```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use TomatoPHP\FilamentDiscordDriver\Traits\InteractsWithDiscord;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use InteractsWithDiscord;
    ...
```

### Queue

the notification is run on queue, so you must run the queue worker to send the notifications

```bash
php artisan queue:work
```

### Use Filament Native Notification

you can use the filament native notification and we add some `macro` for you

```php
use Filament\Notifications\Notification;

Notification::make('send')
    ->title('Test Notifications')
    ->body('This is a test notification')
    ->icon('heroicon-o-bell')
    ->color('success')
    ->actions([
        \Filament\Notifications\Actions\Action::make('view')
            ->label('View')
            ->url('https://google.com')
            ->markAsRead()
    ])
    ->sendUse(auth()->user(), \TomatoPHP\FilamentDiscordDriver\Services\DiscordDriver::class, ['image' => 'https://via.placeholder.com/150']);
  
```

### Notification Service

to create a new template you can use template CRUD and make sure that the template key is unique because you will use it on every single notification.

### Send Notification

to send a notification you must use our helper SendNotification::class like

```php
use TomatoPHP\FilamentAlerts\Facades\FilamentAlerts;

FilamentAlerts::notify(User::first())
    ->template($template->id)
    ->title([
        "find-text" => "change with this"
    ])
    ->body([
        "find-text" => "change with this"
    ])
    ->drivers(\TomatoPHP\FilamentDiscordDriver\Services\DiscordDriver::class)
    ->data(['image' => 'https://via.placeholder.com/150'])
    ->send();
```

where `$template` is selected of the template by key or id, and title, body use to select and replace string on the template with custom data


### Notification Channels

it can be working with direct user methods like

```php
$user->notifyDiscord(string $title, ?string $message = null, ?string $url = null, ?string $image = null, ?string $webhook = null);
```

## Allow Discord Error Logger

you can use Discord channel as an error logger to log and followup your error with a very easy way, on your `bootstrap/app.php` add this class like this

```php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use ProtoneMedia\Splade\Http\SpladeMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        \TomatoPHP\FilamentDiscordDriver\Helpers\DiscordErrorReporter::make($exceptions);
    })->create();
```

make sure you allow the Discord Error Log on the Discord Settings Page


## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-discord-driver-config"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-discord-driver-lang"
```

## Testing

if you like to run `PEST` testing just use this command

```bash
composer test
```

## Code Style

if you like to fix the code style just use this command

```bash
composer format
```

## PHPStan

if you like to check the code by `PHPStan` just use this command

```bash
composer analyse
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
