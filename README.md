<p align="center">
  <img src="https://github.com/user-attachments/assets/8848dc2e-dc62-4ad5-847c-502568b8e0ca" alt="Chilean Bundle — PHP utilities for Chile: RUT, IVA, CLP, Phones, Regions" width="100%">
</p>

# Chilean Bundle

[![Tests](https://github.com/freshworkstudio/ChileanBundle/actions/workflows/run-tests.yml/badge.svg)](https://github.com/freshworkstudio/ChileanBundle/actions/workflows/run-tests.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/freshwork/chilean-bundle.svg)](https://packagist.org/packages/freshwork/chilean-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/freshwork/chilean-bundle.svg)](https://packagist.org/packages/freshwork/chilean-bundle)
[![License](https://img.shields.io/packagist/l/freshwork/chilean-bundle.svg)](LICENSE)

A PHP composer package with Chilean validations, formatters and utilities.
Viva Chile Mier...

```php
use Freshwork\ChileanBundle\{Rut, Iva, Clp, Phone, Region};

Rut::check('12.345.678-5'); // true
Iva::add(10000); // 11900
Clp::format(1234567); // '$1.234.567'
Phone::check('+56 9 8765 4321'); // true
Region::Metropolitana->capital(); // 'Santiago'
```

## This package includes

| Feature | Class | Description |
|---|---|---|
| **R.U.T.** | `Rut` | Validation, formatting, parsing and generation of Chilean RUTs |
| **I.V.A.** | `Iva` | Chilean VAT (19%) constants and calculations |
| **Pesos (CLP)** | `Clp` | Format and parse Chilean peso amounts |
| **Phones** | `Phone` | Validate, normalize and format Chilean phone numbers |
| **Regions** | `Region` | Enum with the 16 regions of Chile (names, numerals, capitals) |
| **Comunas** | `Comuna` | Enum with the 346 comunas backed by their official CUT code |
| **Laravel** | — | `cl_rut` / `cl_phone` validation rules, Rule object, Facade and Eloquent cast |

## Requirements

* PHP 8.2+
* Laravel 11+ (optional, only for the Laravel integration)

> Using PHP 5.x/7.x or an older Laravel? Stick with `freshwork/chilean-bundle:^2.2` — the legacy 2.x series supports PHP 5.4+.

## Installation

```bash
composer require freshwork/chilean-bundle
```

If you're using Laravel, the package supports Auto-Discovery, so you're done.
If you're not using Laravel, just use the classes directly — they have no dependencies.

---

## R.U.T.

### The Basics

```php
use Freshwork\ChileanBundle\Rut;

Rut::parse('11.111.111-1')->validate(); // true
Rut::check('11.111.111-1'); // true (never throws)

$rut = new Rut('11.111.111', '1');
$rut->validate(); // true
```

### `parse()`

The recommended way of creating a `Rut`. It automatically separates the verification number (dígito verificador) from the rest of the number, and escapes dots, dashes and spaces.

```php
Rut::parse('11.111.111-1')->validate(); // true
Rut::parse('12.345.678-5')->validate(); // true
Rut::parse('123456785')->validate(); // true
Rut::parse('1.23.45.6.7.8-5')->validate(); // true
```

### `check()`

The quickest way to know if a string is a valid RUT. It never throws exceptions.

```php
Rut::check('12.345.678-5'); // true
Rut::check('12.345.678-9'); // false
Rut::check('not-a-rut'); // false
```

### `validate()` / `isValid()`

`validate()` is an alias of `isValid()`. If the RUT is well-formed but the verification number is wrong, it returns `false`:

```php
Rut::parse('12.345.678-9')->validate(); // false
```

If the RUT has an invalid **format**, it throws `Freshwork\ChileanBundle\Exceptions\InvalidFormatException`:

```php
Rut::parse('12.3k5.6L8-9')->validate(); // throws InvalidFormatException
Rut::set('12.345.678')->validate(); // throws: no verification number set
```

#### Quiet mode

Use `quiet()` to return `false` instead of throwing. Re-enable exceptions with `use_exceptions()`.

```php
Rut::parse('12.3k5.6L8-9')->quiet()->validate(); // false, no exception
```

### `format()` & `normalize()`

```php
use Freshwork\ChileanBundle\RutFormat;

Rut::parse('123456785')->format(); // '12.345.678-5'
Rut::parse('123456785')->format(RutFormat::Complete); // '12.345.678-5'
Rut::parse('123456785')->format(RutFormat::WithDash); // '12345678-5'
Rut::parse('123456785')->format(RutFormat::Escaped); // '123456785'

// normalize() is an alias of format(RutFormat::Escaped) — ideal for storing in a database
Rut::parse('12.345.678-5')->normalize(); // '123456785'
```

The legacy `Rut::FORMAT_*` int constants still work. On an invalid RUT, `format()` throws an `InvalidFormatException` (or returns `false` in quiet mode).

### `calculateVerificationNumber()` & `fix()`

```php
Rut::set('12.345.678')->calculateVerificationNumber(); // '5'

Rut::parse('12.345.678-9')->fix()->format(); // '12.345.678-5' (vn corrected)
Rut::set('12345678')->fix()->validate(); // true
```

### `random()`

Generates a random valid RUT. Useful for seeders, factories and tests.

```php
Rut::random(); // e.g. 17.062.139-5
Rut::random(5000000, 30000000); // custom range
```

### Getters, setters & serialization

```php
Rut::parse('12.345.678-5')->number(); // '12345678'
Rut::parse('12.345.678-5')->vn(); // '5'
Rut::parse('12.345.678-5')->toArray(); // ['12345678', '5']

(string) Rut::parse('123456785'); // '12.345.678-5' (Stringable)
json_encode(['rut' => Rut::parse('123456785')]); // {"rut":"12.345.678-5"} (JsonSerializable)
```

---

## I.V.A.

Chilean VAT helpers. All amounts are rounded to the nearest peso (CLP has no decimals).

```php
use Freshwork\ChileanBundle\Iva;

Iva::RATE; // 0.19
Iva::PERCENTAGE; // 19

Iva::of(10000); // 1900 — IVA for a net amount
Iva::add(10000); // 11900 — gross (net + IVA)
Iva::net(11900); // 10000 — net from a gross amount
Iva::fromGross(11900); // 1900 — IVA contained in a gross amount
```

---

## Pesos (CLP)

```php
use Freshwork\ChileanBundle\Clp;

Clp::format(1234567); // '$1.234.567'
Clp::format(-1234567); // '-$1.234.567'
Clp::format(1234567, symbol: false); // '1.234.567'

Clp::parse('$1.234.567'); // 1234567
Clp::parse('-$1.234'); // -1234
```

---

## Phones

Chilean phone numbers have 9 national digits: mobiles start with `9`, landlines with `2`–`7` (area code included).

```php
use Freshwork\ChileanBundle\Phone;

Phone::check('+56 9 8765 4321'); // true
Phone::check('09-8765 4321'); // true
Phone::check('12345678'); // false

$phone = Phone::parse('09 8765 4321');
$phone->isValid(); // true
$phone->isMobile(); // true
$phone->isLandline(); // false
$phone->number(); // '987654321' (normalized national number)
$phone->e164(); // '+56987654321'
$phone->format(); // '+56 9 8765 4321'
(string) $phone; // '+56 9 8765 4321'
```

---

## Regions

An enum with the 16 regions of Chile, backed by their official region number.

```php
use Freshwork\ChileanBundle\Region;

Region::Metropolitana->value; // 13
Region::Metropolitana->officialName(); // 'Región Metropolitana de Santiago'
Region::Metropolitana->romanNumeral(); // 'RM'
Region::Metropolitana->capital(); // 'Santiago'

Region::from(9); // Region::Araucania
Region::cases(); // all 16 regions

Region::northToSouth(); // regions in geographic order
Region::options(); // [15 => 'Región de Arica y Parinacota', ...] ready for selects
```

---

## Comunas

An enum with the 346 comunas of Chile, backed by their official territorial code (Código Único Territorial — CUT, [SUBDERE](https://www.subdere.gov.cl)). The first digits of the code are the region number, so every comuna knows its region.

```php
use Freshwork\ChileanBundle\Comuna;
use Freshwork\ChileanBundle\Region;

Comuna::Santiago->value; // 13101
Comuna::Santiago->code(); // '13101' (zero-padded official format, e.g. '01101' for Iquique)
Comuna::Nunoa->officialName(); // 'Ñuñoa'
Comuna::Nunoa->region(); // Region::Metropolitana

Comuna::from(16101); // Comuna::Chillan
Comuna::fromName('ñuñoa'); // Comuna::Nunoa (case and accent insensitive)

Comuna::inRegion(Region::Nuble); // the 21 comunas of Ñuble
Region::Metropolitana->comunas(); // the 52 comunas of the RM

Comuna::options(); // [1101 => 'Iquique', ...] ready for selects
Comuna::options(Region::Tarapaca); // only Tarapacá's comunas
```

---

## Laravel

### Validation rules

```php
$request->validate([
    'rut' => 'required|cl_rut',
    'phone' => 'required|cl_phone',
]);
```

Or with a dedicated Rule object:

```php
use Freshwork\ChileanBundle\Laravel\Rules\Rut;

$request->validate([
    'rut' => ['required', new Rut],
]);
```

Error messages are translated (English and Spanish included). Publish and customize them with:

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
```

---

## Upgrading from 2.x

v3.0 is a major release ([full release notes](https://github.com/freshworkstudio/ChileanBundle/releases/tag/v3.0.0)). The core API is unchanged — `parse()`, `set()`, `validate()`, `isValid()`, `fix()`, `join()`, `toArray()` all work exactly as before — but there are a few breaking changes to review.

### Still on PHP 5.x or 7.x? Stay on 2.x

The **legacy 2.x series remains available and compatible with PHP 5.4+** (and older Laravel versions). It's not going anywhere — if you can't upgrade PHP yet, just pin the previous major:

```bash
composer require freshwork/chilean-bundle:^2.2
```

### 1. PHP 8.2+ (and Laravel 11+) required

v3 uses modern PHP features (enums, strict types, first-class match expressions). The Laravel integration (validation rules, cast, facade) targets Laravel 11+.

### 2. `format()` and `normalize()` now throw on invalid RUTs

In 2.x they silently returned `false` even with exceptions enabled — which also made `(string) $rut` fatal on PHP 8. Now they behave like `validate()`:

```php
// 2.x
Rut::parse('123-1')->format(); // false (silently)

// 3.x
Rut::parse('123-1')->format(); // throws InvalidFormatException
Rut::parse('123-1')->quiet()->format(); // false — same behavior as 2.x
```

If you relied on the silent `false`, add `->quiet()` to keep the old behavior.

### 3. `vnSeparator()` now takes a `string`

The 2.x type hint was `?array` by mistake, which made the method unusable (passing a string threw a `TypeError`). Now it works as documented:

```php
Rut::set('12345678', '9')->vnSeparator('·')->join(); // '12345678·9'
```

### 4. Deprecations (still working, removed in a future major)

| Deprecated | Use instead |
|---|---|
| `scape_chars()` | `escapeChars()` |
| `Freshwork\ChileanBundle\Laravel\Facades\Rut` | `Freshwork\ChileanBundle\Facades\Rut` |

### What's new in v3

Besides the modernized `Rut` (with `Rut::check()`, `Rut::random()`, `RutFormat` enum, `Stringable`/`JsonSerializable`), v3 adds `Iva`, `Clp`, `Phone`, `Region` and `Comuna`, plus the `cl_phone` validation rule, the `Rules\Rut` rule object and the `RutCast` Eloquent cast — all documented above.

---

## Testing & code quality

```bash
composer test # Run the test suite (Pest)
composer lint # Check code style (Pint)
composer analyse # Static analysis (PHPStan)
```

---

## Licencia y Postalware

Puedes usar este paquete gratuitamente sin ninguna restricción, aunque como está de moda, implementamos una licencia 'Postalware'. Si usas este paquete en producción y te gusta como funciona, agradeceríamos bastante si nos envías una postal de tu ciudad/comuna, una nota de agradecimiento o un súper8.

Dirección:
Gonzalo De Spirito
Providencia 229, Providencia.
Chile

---

## Contributing

Pull requests are welcome! Please make sure `composer test`, `composer lint` and `composer analyse` pass.

You can also contact me at gonzalo@freshworkstudio.com
