![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-discord-driver/master/art/3x1io-tomato-discord-driver.jpg)

# Filament discord driver

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-discord-driver/version.svg)](https://packagist.org/packages/tomatophp/filament-discord-driver)
[![License](https://poser.pugx.org/tomatophp/filament-discord-driver/license.svg)](https://packagist.org/packages/tomatophp/filament-discord-driver)
[![Downloads](https://poser.pugx.org/tomatophp/filament-discord-driver/d/total.svg)](https://packagist.org/packages/tomatophp/filament-discord-driver)

Discord Server WebHook Notification for Filament Alerts Sender

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


## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-discord-driver-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-discord-driver-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-discord-driver-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-discord-driver-migrations"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
