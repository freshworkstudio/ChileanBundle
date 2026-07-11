<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle;

/**
 * Chilean VAT (I.V.A.) helpers.
 *
 * All amounts are rounded to the nearest peso (CLP has no decimals),
 * following the SII rounding convention.
 */
final class Iva
{
    /**
     * Current Chilean VAT rate (19%).
     */
    public const RATE = 0.19;

    /**
     * Current Chilean VAT rate as a percentage (19).
     */
    public const PERCENTAGE = 19;

    /**
     * The IVA amount for a given net amount.
     *
     * Iva::of(10000); // 1900
     */
    public static function of(int|float $net): int
    {
        return (int) round($net * self::RATE);
    }

    /**
     * Add IVA to a net amount, returning the gross amount.
     *
     * Iva::add(10000); // 11900
     */
    public static function add(int|float $net): int
    {
        return (int) round($net) + self::of($net);
    }

    /**
     * Get the net amount from a gross (IVA-included) amount.
     *
     * Iva::net(11900); // 10000
     */
    public static function net(int|float $gross): int
    {
        return (int) round($gross / (1 + self::RATE));
    }

    /**
     * The IVA amount contained in a gross (IVA-included) amount.
     *
     * Iva::fromGross(11900); // 1900
     */
    public static function fromGross(int|float $gross): int
    {
        return (int) round($gross) - self::net($gross);
    }
}
