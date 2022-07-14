# Package for interacting with api from `card charging v2` (thesieure.com, doithengay.com,...)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dinhdjj/card-charging-v2.svg?style=flat-square)](https://packagist.org/packages/dinhdjj/card-charging-v2)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/dinhdjj/card-charging-v2/run-tests?label=tests)](https://github.com/dinhdjj/card-charging-v2/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/dinhdjj/card-charging-v2/Check%20&%20fix%20styling?label=code%20style)](https://github.com/dinhdjj/card-charging-v2/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/dinhdjj/card-charging-v2.svg?style=flat-square)](https://packagist.org/packages/dinhdjj/card-charging-v2)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require dinhdjj/laravel-card-charging-v2
```

You can publish and run the migrations with:

```php
    php artisan vendor:publish --tag="card-charging-v2-migrations"
    php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="card-charging-v2-config"
```

This is the contents of the published config file:

```php
return [
    // Default connection
    'default' => env('THESIEURE_CONNECTION', 'default'),

    // List config connection
    'connections' => [
        'default' => [
            'domain' => env('THESIEURE_DOMAIN', 'thesieure.com'),
            'partner_id' => env('THESIEURE_PARTNER_ID'),
            'partner_key' => env('THESIEURE_PARTNER_KEY'),
        ],
    ],

    // Related to card model
    'card' => [
        'table' => 'card_charging_v2',
        'model' => Dinhdjj\CardChargingV2\Models\Card::class,
    ],

    'callback' => [
        'uri' => 'api/card-charging-v2/callback',
        'middleware' => ['api'],
        'name' => 'card-charging-v2-callback',
        'controller' => Dinhdjj\CardChargingV2\Controllers\CallbackController::class,
        // Event will dispatch after callback is called (validated callback signature)
        'event' => Dinhdjj\CardChargingV2\Events\CallbackCalled::class,
    ],
];
```

## Usage

```php
use CardChargingV2;

/** @var \Dinhdjj\CardChargingV2\Data\CardType[] */
$cardTypes =  CardChargingV2::getFee();

/** @var \Dinhdjj\CardChargingV2\Models\Card[] */
$card = CardChargingV2::charging('VIETTEL', 10000, '1000372684732', '3729473289432', '1');
$card = CardChargingV2::check('VIETTEL', 10000, '1000372684732', '3729473289432', '1');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/dinhdjj/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [dinhdjj](https://github.com/dinhdjj)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
