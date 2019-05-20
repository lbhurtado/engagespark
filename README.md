# engageSpark Laravel Notification Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lbhurtado/engagespark.svg?style=flat-square)](https://packagist.org/packages/lbhurtado/engagespark)
[![Build Status](https://img.shields.io/travis/lbhurtado/engagespark/master.svg?style=flat-square)](https://travis-ci.org/lbhurtado/engagespark)
[![Quality Score](https://img.shields.io/scrutinizer/g/lbhurtado/engagespark.svg?style=flat-square)](https://scrutinizer-ci.com/g/lbhurtado/engagespark)
[![Total Downloads](https://img.shields.io/packagist/dt/lbhurtado/engagespark.svg?style=flat-square)](https://packagist.org/packages/lbhurtado/engagespark)

## Installation

You can install the package via composer:

```bash
composer require lbhurtado/engagespark
php artisan notifications:table
php artisan migrate
```

required environment variables:

```dotenv
ENGAGESPARK_API_KEY=
ENGAGESPARK_ORGANIZATION_ID=
```

optional environment variables:

```dotenv
ENGAGESPARK_SENDER_ID=
ENGAGESPARK_SMS_WEBHOOK=
ENGAGESPARK_AIRTIME_WEBHOOK=
NOTIFICATION_CLASS=
ENGAGESPARK_MIN_TOPUP=
```

optional configuration:

```bash
php artisan vendor:publish --provider="LBHurtado\EngageSpark\EngageSparkServiceProvider"
```

## Usage

in your notification:

``` php
use LBHurtado\EngageSpark\EngageSparkChannel;
use LBHurtado\EngageSpark\EngageSparkMessage;

public function via($notifiable)
{
    return [EngageSparkChannel::class];
}
 
public function toEngageSpark($notifiable)
{
    return (new EngageSparkMessage())
        ->content('The quick brown fox jumps over the lazy dog.')
        ;
}   
```

in your notifiable model:
``` php
use Illuminate\Notifications\Notifiable;

public function routeNotificationForEngageSpark()
{
    return $this->mobile;
} 
```
or use the trait:
``` php
use LBHurtado\EngageSpark\Traits\HasEngageSpark;

class Contact extends Model 
{
    use HasEngageSpark;
}
```

in your application:

``` php
use LBHurtado\EngageSpark\Notifications\Toup;
use LBHurtado\EngageSpark\Notifications\Adhoc;

$user->notify(new Adhoc('The quick brown fox...'));
$user->notify(new Topup(25);
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email lester@hurtado.ph instead of using the issue tracker.

## Credits

- [Lester Hurtado](https://github.com/lbhurtado)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
