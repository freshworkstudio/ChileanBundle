<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle;

/**
 * Chilean peso (CLP) formatting helpers.
 *
 * CLP has no decimals: amounts are rounded to the nearest peso.
 */
final class Clp
{
    /**
     * ISO 4217 currency code.
     */
    public const CODE = 'CLP';

    /**
     * Currency symbol.
     */
    public const SYMBOL = '$';

    /**
     * Format an amount as Chilean pesos.
     *
     * Clp::format(1234567); // '$1.234.567'
     * Clp::format(-1234567); // '-$1.234.567'
     * Clp::format(1234567, symbol: false); // '1.234.567'
     */
    public static function format(int|float $amount, bool $symbol = true): string
    {
        $amount = (int) round($amount);
        $sign = $amount < 0 ? '-' : '';

        return $sign.($symbol ? self::SYMBOL : '').number_format(abs($amount), 0, ',', '.');
    }

    /**
     * Parse a CLP-formatted string back into an integer amount of pesos.
     *
     * Clp::parse('$1.234.567'); // 1234567
     * Clp::parse('-$1.234'); // -1234
     */
    public static function parse(string $amount): int
    {
        $negative = str_contains($amount, '-');
        $digits = (string) preg_replace('/[^0-9]/', '', $amount);

        return ($negative ? -1 : 1) * (int) $digits;
    }
}
