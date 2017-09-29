# Laravel 5.5.x Front-end Preset For

This package makes it easy to use [Polymer 2.x starter kit (webpack version)](https://github.com/Banno/polymer-2-starter-kit-webpack) with Laravel 5.5+.

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

To install this preset on your laravel application, simply run:

``` bash
composer require jlndk/laravel-polymer-webpack-frontend-preset
```

In Laravel 5.5+ this package should be discovered automaticly, but if you for some reason want to register it manually add this line to the service provider array in `config/app.php`.
```php
Jlndk\PolymerWebpackPreset\PolymerPresetServiceProvider::class,
```

## Usage
**Notice: It is only recommended to run this package once and only on a fresh laravel installation. It is not our responserbility if you loose existing data.**

This package ships with two presets. One without authentication scaffolding, and one with.
To use the one without simply run:
```bash
php artisan preset polymer
```
To use the one with authentication scaffolding run:
```bash
php artisan preset polymer-auth
```

## Contributing

Please check our contributing rules in [our website](https://laravel-frontend-presets.github.io) for details.

## Credits

- [Jonas Lindenskov Nielsen (jlndk)](https://github.com/jlndk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT).
