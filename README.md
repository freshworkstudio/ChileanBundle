# Chilean Bundle

[![Tests](https://github.com/freshworkstudio/ChileanBundle/actions/workflows/run-tests.yml/badge.svg)](https://github.com/freshworkstudio/ChileanBundle/actions/workflows/run-tests.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/freshwork/chilean-bundle.svg)](https://packagist.org/packages/freshwork/chilean-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/freshwork/chilean-bundle.svg)](https://packagist.org/packages/freshwork/chilean-bundle)
[![License](https://img.shields.io/packagist/l/freshwork/chilean-bundle.svg)](LICENSE)

A PHP composer package with Chilean validations, common variables, etc.
Viva Chile Mier...

## This package includes:

* R.U.T. validation, formatting and generation
* Laravel integration: `cl_rut` validation rule, Rule object, Facade and Eloquent cast
* More functions coming soon...

## Requirements

* PHP 8.2+
* Laravel 11+ (optional, only for the Laravel integration)

> Using PHP 5.x/7.x or an older Laravel? Stick with `freshwork/chilean-bundle:^1.0`.

## Installation

From the command line, run:

```bash
composer require freshwork/chilean-bundle
```

If you're using Laravel, the package supports Auto-Discovery, so you're done.
If you're not using Laravel, just use the `Freshwork\ChileanBundle\Rut` class directly.

## Usage

### The Basics

```php
use Freshwork\ChileanBundle\Rut;

Rut::parse('11.111.111-1')->validate(); // true
Rut::check('11.111.111-1'); // true (never throws)

$rut = new Rut('11.111.111', '1');
$rut->validate(); // true
```

### The `parse()` method

Is the recommended way of using the object. It will automatically separate the Verification Number (dígito verificador) and the rest of the number.

```php
Rut::parse('11.111.111-1')->validate(); // true
Rut::parse('11111111-1')->validate(); // true
Rut::parse('12.345.678-5')->validate(); // true
Rut::parse('123456785')->validate(); // true
Rut::parse('1.23.45.6.7.8-5')->validate(); // true. It escapes all the dots and dashes.
```

### The `check()` method

The quickest way to know if a string is a valid RUT. It never throws exceptions.

```php
Rut::check('12.345.678-5'); // true
Rut::check('12.345.678-9'); // false
Rut::check('not-a-rut'); // false
```

### The `set()` method

This is a shortcut for `(new Rut($number, $vn))`.

```php
Rut::set('10.123.123', '5');
```

### The `validate()` & `isValid()` methods

`validate()` is an alias of `isValid()`.

```php
Rut::parse('12345678-5')->isValid(); // true
```

### Invalid R.U.T.

If the R.U.T. is invalid, it will return false.

```php
Rut::parse('12.345.678-9')->validate(); // false
```

If the R.U.T. has a wrong format, it will throw a `Freshwork\ChileanBundle\Exceptions\InvalidFormatException`.

```php
Rut::parse('12.3k5.6L8-9')->validate(); // throws InvalidFormatException
Rut::set('12.345.678')->validate(); // throws exception. We didn't set the verification number
```

#### `Quiet` mode

You can prevent the object from throwing an `InvalidFormatException`, so `validate()` will just return false, using the `quiet()` method.

```php
Rut::parse('12.3k5.6L8-9')->quiet()->validate(); // returns false. No exception
```

You can re-enable exceptions with `use_exceptions()`.

### The `calculateVerificationNumber()` method

You can get the correct verification number of a RUT. Note that we are passing just one argument to the `set()` method: we are not defining a verification number.

```php
Rut::set('12.345.678')->calculateVerificationNumber(); // returns '5'
Rut::parse('12.345.678-9')->calculateVerificationNumber(); // returns '5'
```

Esta clase se basa en esta simple, pero eficiente función:
[http://www.dcc.uchile.cl/~mortega/microcodigos/validarrut/php.php](http://www.dcc.uchile.cl/~mortega/microcodigos/validarrut/php.php)

### The `format()` method

Returns the RUT as a string in one of the available formats.

```php
use Freshwork\ChileanBundle\RutFormat;

Rut::parse('123456785')->format(); // returns 12.345.678-5
Rut::parse('123456785')->format(RutFormat::Complete); // returns 12.345.678-5
Rut::parse('123456785')->format(RutFormat::WithDash); // returns 12345678-5
Rut::parse('123456785')->format(RutFormat::Escaped); // returns 123456785
```

The legacy `Rut::FORMAT_COMPLETE`, `Rut::FORMAT_WITH_DASH` and `Rut::FORMAT_ESCAPED` constants still work.

If the RUT has an invalid format, `format()` throws an `InvalidFormatException` (or returns `false` in quiet mode).

### The `normalize()` method

If you are saving RUTs in the database, I recommend saving the normalized rut string. This method is an alias of `->format(RutFormat::Escaped)`.

```php
Rut::parse('12.345.678-5')->normalize(); // returns '123456785'
```

### The `toArray()` method

```php
Rut::parse('12.345.678-5')->toArray(); // returns ['12345678', '5']
```

### String & JSON serialization

The `Rut` object implements `Stringable` and `JsonSerializable`:

```php
(string) Rut::parse('123456785'); // '12.345.678-5'
json_encode(['rut' => Rut::parse('123456785')]); // {"rut":"12.345.678-5"}
```

### The `fix()` method

Fixes the current RUT: it takes the number part (without verification number), calculates the correct verification number, and updates it.

```php
Rut::parse('12.345.678-9')->fix()->format(); // returns '12.345.678-5'

// Set a new rut without setting any verification number
Rut::set('12345678')->fix()->format(); // returns '12.345.678-5'

Rut::parse('12.345.678-9')->validate(); // returns false
Rut::parse('12.345.678-9')->fix()->validate(); // returns true
```

### The `random()` method

Generates a random valid RUT. Useful for seeders, factories and tests.

```php
Rut::random(); // e.g. 17.062.139-5
Rut::random()->format(RutFormat::WithDash); // e.g. 18815969-9

// Custom range
Rut::random(5000000, 30000000);
```

### The `vn()` and `number()` methods

You can get and set the RUT number and verification number with these methods. With no arguments they act as getters; otherwise they set the value and return the object.

```php
// Getters
Rut::parse('12.345.678-9')->vn(); // returns '9'
Rut::parse('12.345.678-9')->number(); // returns '12345678'

// Setters
Rut::parse('12.345.678-9')->vn('5')->format(); // returns '12.345.678-5'
Rut::set()->number('12.345.678')->vn('5')->format(); // returns '12.345.678-5'
```

# Laravel

### Validation

You can validate RUTs using Laravel's validation system with the `cl_rut` rule:

```php
$request->validate([
    'name' => 'required|min:2',
    'email' => 'required|email',
    'rut' => 'required|cl_rut',
]);
```

Or, if you prefer a dedicated Rule object:

```php
use Freshwork\ChileanBundle\Laravel\Rules\Rut;

$request->validate([
    'rut' => ['required', new Rut],
]);
```

Error messages are translated (English and Spanish included). You can publish and customize them:

```bash
php artisan vendor:publish --tag=chilean-bundle-lang
```

### Eloquent cast

Expose a model attribute as a `Rut` object and control how it's stored:

```php
use Freshwork\ChileanBundle\Laravel\Casts\RutCast;

class Client extends Model
{
    protected function casts(): array
    {
        return [
            'rut' => RutCast::class, // stored escaped: 123456785 (recommended)
            // 'rut' => RutCast::class.':dash', // stored as: 12345678-5
            // 'rut' => RutCast::class.':complete', // stored as: 12.345.678-5
        ];
    }
}

$client->rut = '12.345.678-5';
$client->rut->format(); // '12.345.678-5'
```

### Facade

```php
use Freshwork\ChileanBundle\Facades\Rut;

Rut::check('12.345.678-5'); // true
Rut::parse('12.345.678-5')->format(); // '12.345.678-5'
```

---

# Upgrading from 1.x

* PHP 8.2+ is now required.
* `format()` and `normalize()` now throw an `InvalidFormatException` on invalid RUTs when exceptions are enabled (before, they silently returned `false`). In `quiet()` mode they still return `false`.
* `vnSeparator()` now takes a `string` (the previous `array` type hint was a bug).
* `scape_chars()` is deprecated in favor of `escapeChars()` (the old method still works).
* `Freshwork\ChileanBundle\Laravel\Facades\Rut` is deprecated in favor of `Freshwork\ChileanBundle\Facades\Rut`.
* Everything else keeps the same API: `parse()`, `set()`, `validate()`, `isValid()`, `fix()`, `join()`, `toArray()`, etc.

---

# Testing

```bash
composer test # Run the test suite (Pest)
composer lint # Check code style (Pint)
composer analyse # Static analysis (PHPStan)
```

---

# Licencia y Postalware

Puedes usar este paquete gratuitamente sin ninguna restricción, aunque como está de moda, implementamos una licencia 'Postalware'. Si usas este paquete en producción y te gusta como funciona, agradeceríamos bastante si nos envías una postal de tu ciudad/comuna, una nota de agradecimiento o un súper8.

Dirección:
Gonzalo De Spirito
Providencia 229, Providencia.
Chile

---

# Contributing

Pull requests are welcome! Please make sure `composer test`, `composer lint` and `composer analyse` pass.

You can also contact me at gonzalo@freshworkstudio.com
