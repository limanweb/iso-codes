# limanweb/iso-codes

This package provides any ISO-code lists to use in your Laravel-application. 

List of sections and available locales:

* **iso_country** - ISO 3166-1 country codes;
    * locales: `en`, `fr`, `ru`, `ka`, `hy`
* **iso_currency** - ISO 4217 currency codes;
    * locales: `en`, `ru`, `ka`

## Installation

Run command:

```bash
composer require "limanweb/iso-codes"
```

Add service provider class to `provider` section of your `config/app.php`

```php
    Limanweb\IsoCodes\Providers\IsoCodesServiceProvider::class,
```

Add alias for facade to `alias` section of your `config/app.php`

```php
    'IsoCodes' => Limanweb\IsoCodes\Services\IsoCodesServiceFacade::class,
```

Run command:

```bash
php artisan vendor:publish
```

and input index number of `Limanweb\IsoCodes\Providers\IsoCodesServiceProvider` provider.

## Using

Service `Limanweb\IsoCodes\Service\IsoCodesService` provides a method `get()` to get any data.

You can access to service throught facade alias `\IsoCodes`

Syntax:

```
\IsoCode::get($section, $path = null, $locale = null)
```

Arguments:

* **$section** - section name. Argument is required.
* **$path** - dot-path to filter result. Argument is not required.
* **$locale** - locale name. Argument is not required. By default is current application locale.


## Examples

To get full country list put `iso_country` section name into first argument

```
>>> IsoCodes::get('iso_country')
=> [
     "AFG" => [
       "alpha2" => "AF",
       "alpha3" => "AFG",
       "num" => 4,
       "title" => "Afghanistan",
     ],
     "ALB" => [
       "alpha2" => "AL",
       "alpha3" => "ALB",
       "num" => 8,
       "title" => "Albania",
     ],
     ...
   ]
```

To get one country item you can put second argument

```
>>> IsoCodes::get('iso_country','USA')
=> [
     "alpha2" => "US",
     "alpha3" => "USA",
     "num" => 840,
     "title" => "United States of America (the)",
   ]
```

By default title translates to current application locale. Use third argument to get data in other locale (if it available).

```
>>> IsoCodes::get('iso_country','USA', 'ru')
=> [
     "alpha2" => "US",
     "alpha3" => "USA",
     "num" => 840,
     "title" => "США",
   ]
```

To get full currency list put `iso_currency` section name into first argument

```
>>> IsoCodes::get('iso_currency')
=> [
     "AED" => [
       "alpha" => "AED",
       "num" => 784,
       "minor_unit" => 2,
       "title" => "United Arab Emirates dirham",
     ],
     "AFN" => [
       "alpha" => "AFN",
       "num" => 971,
       "minor_unit" => 2,
       "title" => "Afghan afghani",
     ],
     ...
   ]
```
