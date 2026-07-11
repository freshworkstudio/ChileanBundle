<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle;

use Freshwork\ChileanBundle\Exceptions\InvalidFormatException;
use JsonSerializable;
use Stringable;

/**
 * Validation and utilities for the Chilean R.U.T.
 *
 * Author: Gonzalo De Spirito
 * Email: gonzalo@freshworkstudio.com
 */
class Rut implements JsonSerializable, Stringable
{
    /** @deprecated Use RutFormat::Complete. Ex: 12.345.678-9 */
    public const FORMAT_COMPLETE = 0;

    /** @deprecated Use RutFormat::Escaped. Ex: 123456789 */
    public const FORMAT_ESCAPED = 1;

    /** @deprecated Use RutFormat::WithDash. Ex: 12345678-9 */
    public const FORMAT_WITH_DASH = 2;

    /**
     * Characters to escape from the RUT before validating.
     *
     * Caracteres que queremos eliminar del rut para realizar la validación.
     *
     * @var string[]
     */
    protected array $escapeChars = ['.', ',', '-', '_', ' '];

    /**
     * RUT verification number separator.
     */
    protected string $vnSeparator = '-';

    /**
     * Min amount of chars the number part of a RUT can have once normalized (exclusive).
     */
    protected int $minChars = 5;

    /**
     * Max amount of chars the number part of a RUT can have once normalized (exclusive).
     */
    protected int $maxChars = 10;

    /**
     * Determines if the class throws exceptions on validation errors.
     */
    protected bool $useExceptions = true;

    /**
     * The number part of the RUT. Example: 12.345.678-9 ($number = '12345678').
     */
    protected ?string $number = null;

    /**
     * The verification number part of the RUT. Example: 12.345.678-9 ($vn = '9').
     */
    protected ?string $vn = null;

    final public function __construct(string|int|null $rut = null, string|int|null $vn = null)
    {
        if ($rut !== null) {
            $this->number($rut);
        }
        if ($vn !== null) {
            $this->vn($vn);
        }
    }

    /**
     * Shortcut for (new Rut($rut, $vn)) that automatically splits
     * the verification number from the rest of the RUT.
     */
    public static function parse(string|int $rut): static
    {
        [$rut, $vn] = static::split((string) $rut);

        return new static($rut, $vn);
    }

    /**
     * Shortcut for (new Rut($number, $vn)).
     */
    public static function set(string|int|null $number = null, string|int|null $vn = null): static
    {
        return new static($number, $vn);
    }

    /**
     * Quick check: returns true if $rut is a valid RUT. Never throws.
     */
    public static function check(string|int $rut): bool
    {
        return static::parse($rut)->quiet()->isValid();
    }

    /**
     * Generate a random valid RUT, useful for seeders, factories and tests.
     */
    public static function random(int $min = 1000000, int $max = 25999999): static
    {
        return static::set(random_int($min, $max))->fix();
    }

    /**
     * Gets or sets the verification number.
     */
    public function vn(string|int|null $vn = null): static|string|null
    {
        if ($vn !== null) {
            $this->vn = strtoupper($this->escape((string) $vn));

            return $this;
        }

        return $this->vn;
    }

    /**
     * Gets or sets the RUT number (without the verification number).
     */
    public function number(string|int|null $number = null): static|string|null
    {
        if ($number !== null) {
            $this->number = $this->escape((string) $number);

            return $this;
        }

        return $this->number;
    }

    /**
     * Gets or sets the minimum amount of characters the number part can have to be valid (exclusive).
     */
    public function minChars(?int $minChars = null): static|int
    {
        if ($minChars !== null) {
            $this->minChars = $minChars;

            return $this;
        }

        return $this->minChars;
    }

    /**
     * Gets or sets the maximum amount of characters the number part can have to be valid (exclusive).
     */
    public function maxChars(?int $maxChars = null): static|int
    {
        if ($maxChars !== null) {
            $this->maxChars = $maxChars;

            return $this;
        }

        return $this->maxChars;
    }

    /**
     * Gets or sets the characters that are stripped from the RUT before validating.
     *
     * @param  string[]|null  $chars
     * @return static|string[]
     */
    public function escapeChars(?array $chars = null): static|array
    {
        if ($chars !== null) {
            $this->escapeChars = $chars;

            return $this;
        }

        return $this->escapeChars;
    }

    /**
     * Alias of escapeChars(), kept for backwards compatibility.
     *
     * @deprecated Use escapeChars() instead.
     *
     * @param  string[]|null  $chars
     * @return static|string[]
     */
    public function scape_chars(?array $chars = null): static|array
    {
        return $this->escapeChars($chars);
    }

    /**
     * Gets or sets the verification number separator.
     */
    public function vnSeparator(?string $vnSeparator = null): static|string
    {
        if ($vnSeparator !== null) {
            $this->vnSeparator = $vnSeparator;

            return $this;
        }

        return $this->vnSeparator;
    }

    /**
     * Check if the RUT is valid.
     *
     * Devuelve true si el RUT es válido.
     *
     * @throws InvalidFormatException
     */
    public function isValid(): bool
    {
        if (! $this->hasValidFormat()) {
            if ($this->useExceptions) {
                throw new InvalidFormatException("R.U.T. '{$this->number}' with verification code '{$this->vn}' has an invalid format");
            }

            return false;
        }

        return $this->vn === $this->calculateVerificationNumber();
    }

    /**
     * Alias of isValid().
     *
     * @throws InvalidFormatException
     */
    public function validate(): bool
    {
        return $this->isValid();
    }

    /**
     * Calculate the verification number for the current RUT number.
     *
     * Devuelve el dígito verificador que debe tener el RUT ingresado.
     * Fuente: http://www.dcc.uchile.cl/~mortega/microcodigos/validarrut/php.php
     *
     * @author Luis Dujovne
     */
    public function calculateVerificationNumber(): string
    {
        $rut = (int) $this->number;
        $s = 1;
        for ($m = 0; $rut != 0; $rut = intdiv($rut, 10)) {
            $s = ($s + $rut % 10 * (9 - $m++ % 6)) % 11;
        }

        return $s ? chr($s + 47) : 'K';
    }

    /**
     * Splits the RUT into number and verification number.
     *
     * Si no le pasas el dígito verificador $vn, separa el rut del dígito verificador.
     * Si le pasas el dígito verificador $vn, te devuelve ambos parámetros como array.
     *
     * @return array{0: string, 1: string}
     */
    public static function split(string|int $rut, string|int|null $vn = null): array
    {
        $rut = (string) $rut;

        if ($vn !== null) {
            return [$rut, (string) $vn];
        }

        return [substr($rut, 0, -1), substr($rut, -1)];
    }

    /**
     * Escape the RUT or any string, removing the escapeChars() characters.
     *
     * Quita los caracteres (escapeChars) que no queremos del RUT/string.
     */
    public function escape(string $string): string
    {
        return str_replace($this->escapeChars, '', $string);
    }

    /**
     * Get the normalized version of the RUT. Ex: '123456785'.
     *
     * @throws InvalidFormatException
     */
    public function normalize(): string|false
    {
        return $this->format(RutFormat::Escaped);
    }

    /**
     * Fix the RUT so the verification number is now valid.
     * This method overrides the verification number provided.
     */
    public function fix(): static
    {
        $this->vn($this->calculateVerificationNumber());

        return $this;
    }

    /**
     * Format the RUT in one of the available formats.
     *
     * Formatea el RUT en alguno de los 3 formatos disponibles.
     * Returns false when the RUT has an invalid format and exceptions are disabled.
     *
     * @throws InvalidFormatException
     */
    public function format(RutFormat|int $format = RutFormat::Complete): string|false
    {
        if (! $this->hasValidFormat()) {
            if ($this->useExceptions) {
                throw new InvalidFormatException("R.U.T. '{$this->number}' with verification code '{$this->vn}' has an invalid format");
            }

            return false;
        }

        if (is_int($format)) {
            $format = RutFormat::from($format);
        }

        return match ($format) {
            RutFormat::Complete => $this->join(
                (string) preg_replace('/\B(?=(\d{3})+(?!\d))/', '.', (string) $this->number),
                $this->vn
            ),
            RutFormat::WithDash => $this->join($this->number, $this->vn),
            RutFormat::Escaped => $this->number.$this->vn,
        };
    }

    /**
     * Check if the RUT has a valid format (it does not verify the verification number).
     *
     * Revisa si el RUT tiene un formato válido.
     */
    public function hasValidFormat(): bool
    {
        $number = (string) $this->number;

        if (strlen($number) >= $this->maxChars || strlen($number) <= $this->minChars) {
            return false;
        }

        if (! preg_match('/^[K0-9]$/', (string) $this->vn)) {
            return false;
        }

        return (bool) preg_match('/^[0-9]+$/', $number);
    }

    /**
     * Join two parts of a RUT: number and verification number.
     */
    public function join(?string $number = null, ?string $vn = null): string
    {
        return ($number ?? $this->number).$this->vnSeparator.($vn ?? $this->vn);
    }

    /**
     * Set the object to a quiet status: validation failures return false instead of throwing.
     */
    public function quiet(): static
    {
        $this->useExceptions = false;

        return $this;
    }

    /**
     * Let the object throw exceptions on validation failures.
     */
    public function use_exceptions(): static
    {
        $this->useExceptions = true;

        return $this;
    }

    /**
     * Return exception-throwing status.
     */
    public function is_using_exceptions(): bool
    {
        return $this->useExceptions;
    }

    /**
     * @return array{0: string|null, 1: string|null}
     */
    public function toArray(): array
    {
        return [$this->number, $this->vn];
    }

    public function jsonSerialize(): mixed
    {
        return $this->format() ?: null;
    }

    public function __toString(): string
    {
        return $this->format() ?: '';
    }
}
