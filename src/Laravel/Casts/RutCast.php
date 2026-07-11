<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle\Laravel\Casts;

use Freshwork\ChileanBundle\Rut;
use Freshwork\ChileanBundle\RutFormat;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Eloquent cast for Chilean RUTs.
 *
 * Exposes the attribute as a Rut object and stores it as a string.
 * The storage format can be set per attribute:
 *
 *     protected function casts(): array
 *     {
 *         return [
 *             'rut' => RutCast::class,             // stored escaped: 123456785
 *             'rut' => RutCast::class.':dash',     // stored as: 12345678-5
 *             'rut' => RutCast::class.':complete', // stored as: 12.345.678-5
 *         ];
 *     }
 *
 * @implements CastsAttributes<Rut|null, string|null>
 */
class RutCast implements CastsAttributes
{
    protected RutFormat $format;

    public function __construct(string $format = 'escaped')
    {
        $this->format = match ($format) {
            'escaped' => RutFormat::Escaped,
            'dash' => RutFormat::WithDash,
            'complete' => RutFormat::Complete,
            default => throw new InvalidArgumentException("Invalid RUT storage format '{$format}'. Valid formats: escaped, dash, complete."),
        };
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): ?Rut
    {
        if ($value === null || $value === '') {
            return null;
        }

        return Rut::parse((string) $value)->quiet();
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $rut = $value instanceof Rut ? clone $value : Rut::parse((string) $value);

        return ($formatted = $rut->quiet()->format($this->format)) === false
            ? (string) $value
            : $formatted;
    }
}
