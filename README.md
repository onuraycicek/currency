# Laravel Currency Converter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/onuraycicek/currency.svg?style=flat-square)](https://packagist.org/packages/onuraycicek/currency)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/onuraycicek/currency/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/onuraycicek/currency/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/onuraycicek/currency/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/onuraycicek/currency/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/onuraycicek/currency.svg?style=flat-square)](https://packagist.org/packages/onuraycicek/currency)

## Installation

You can install the package via composer:

```bash
composer require onuraycicek/currency
```

```bash
php artisan vendor:publish --tag="currency-migrations"
php artisan vendor:publish --tag="currency-config"
php artisan vendor:publish --tag="currency-seeder"
php artisan migrate
php artisan db:seed --class=CurrencySeeder
```

You must be add this libs: Bootstrap 5, Jquery, Select2.

```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
```

Finally you must be add the end (footer) of the layout file: (it's required when you want to use "select-active" attribute)
```php
@stack("footer")
```

## Usage

![Alt text](assets/preview.jpg)

```php
<x-currency-table select-active></x-currency-table>
```

#### **Attributes:**

__select-active__: It adds a selectbox above the table so you can check your currencies activity values.

```php
$fromId = 53;
$toId = 155;
$amount = 100;
echo \Onuraycicek\Currency\Currency::convertWithId($fromId, $toId, $amount);

$fromCurrencyCode = "TRY";
$toCurrencyCode = "USD";
$amount = 100;
echo \Onuraycicek\Currency\Currency::convert($fromCurrencyCode, $toCurrencyCode, $amount);
```

## Config

```php
return [
    'theme' => 'bootstrap5',
    'currencies' => ['TRY', 'USD', 'EUR'], // if it is null, currencies with status 1 will be shown. -> ('currencies' => null)
];

theme: bootstrap5, bootstrap4 (not supported yet)
currencies: https://www.html-code-generator.com/php/array/currency-names
```


## Testing

```bash
composer test
```

## Credits

-   [onuraycicek](https://github.com/onuraycicek)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
