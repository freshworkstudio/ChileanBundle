<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle;

use Stringable;

/**
 * Chilean phone number validation and formatting.
 *
 * Chilean numbers have 9 national digits: mobiles start with 9,
 * landlines start with 2-7 (area code included).
 */
final class Phone implements Stringable
{
    /**
     * Chilean country calling code.
     */
    public const COUNTRY_CODE = '56';

    /**
     * The normalized national number (digits only, no country code).
     */
    protected string $number;

    private function __construct(string|int $number)
    {
        $this->number = self::normalize((string) $number);
    }

    /**
     * Parse any common representation of a Chilean phone number.
     *
     * Phone::parse('+56 9 8765 4321');
     * Phone::parse('09-8765 4321');
     * Phone::parse('987654321');
     */
    public static function parse(string|int $number): self
    {
        return new self($number);
    }

    /**
     * Quick check: returns true if $number is a valid Chilean phone number.
     */
    public static function check(string|int $number): bool
    {
        return self::parse($number)->isValid();
    }

    /**
     * Strip formatting, country code and trunk zeros, keeping the national number.
     * Input containing anything other than digits and common formatting
     * characters (+, spaces, dots, dashes, parentheses) is rejected.
     */
    protected static function normalize(string $number): string
    {
        if (preg_match('/^\+?[0-9\s().-]+$/', $number) !== 1) {
            return '';
        }

        $digits = (string) preg_replace('/[^0-9]/', '', $number);

        if (strlen($digits) === 11 && str_starts_with($digits, self::COUNTRY_CODE)) {
            $digits = substr($digits, 2);
        }

        return ltrim($digits, '0');
    }

    /**
     * A valid national number has 9 digits: mobiles start with 9, landlines with 2-7.
     */
    public function isValid(): bool
    {
        return (bool) preg_match('/^[2-79]\d{8}$/', $this->number);
    }

    public function isMobile(): bool
    {
        return $this->isValid() && str_starts_with($this->number, '9');
    }

    public function isLandline(): bool
    {
        return $this->isValid() && ! str_starts_with($this->number, '9');
    }

    /**
     * The normalized national number. Ex: '987654321'.
     */
    public function number(): string
    {
        return $this->number;
    }

    /**
     * E.164 format. Ex: '+56987654321'. Returns null if the number is invalid.
     */
    public function e164(): ?string
    {
        return $this->isValid() ? '+'.self::COUNTRY_CODE.$this->number : null;
    }

    /**
     * Human-readable international format.
     *
     * Mobiles and Santiago landlines have a one-digit prefix (9 / 2); the
     * remaining landlines use a two-digit area code.
     *
     * Ex: '+56 9 8765 4321', '+56 2 2123 4567', '+56 45 212 3456'.
     * Returns null if the number is invalid.
     */
    public function format(): ?string
    {
        if (! $this->isValid()) {
            return null;
        }

        $prefixLength = $this->isMobile() || str_starts_with($this->number, '2') ? 1 : 2;
        $prefix = substr($this->number, 0, $prefixLength);
        $subscriber = substr($this->number, $prefixLength);
        $splitAt = strlen($subscriber) - 4;

        return sprintf(
            '+%s %s %s %s',
            self::COUNTRY_CODE,
            $prefix,
            substr($subscriber, 0, $splitAt),
            substr($subscriber, $splitAt)
        );
    }

    public function __toString(): string
    {
        return $this->format() ?? '';
    }
}
