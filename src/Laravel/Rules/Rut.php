<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle\Laravel\Rules;

use Closure;
use Freshwork\ChileanBundle\Rut as RutValue;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validation rule object for Chilean RUTs.
 *
 * Usage: $request->validate(['rut' => ['required', new Rut]]);
 */
class Rut implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) && ! is_int($value)) {
            $fail('chilean-bundle::validation.cl_rut')->translate();

            return;
        }

        if (! RutValue::check($value)) {
            $fail('chilean-bundle::validation.cl_rut')->translate();
        }
    }
}
