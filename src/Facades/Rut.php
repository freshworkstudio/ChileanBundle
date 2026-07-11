<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Freshwork\ChileanBundle\Rut parse(string|int $rut)
 * @method static \Freshwork\ChileanBundle\Rut set(string|int|null $number = null, string|int|null $vn = null)
 * @method static bool check(string|int $rut)
 * @method static \Freshwork\ChileanBundle\Rut random(int $min = 1000000, int $max = 25999999)
 * @method static array{0: string, 1: string} split(string|int $rut, string|int|null $vn = null)
 *
 * @see \Freshwork\ChileanBundle\Rut
 */
class Rut extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'rut';
    }
}
