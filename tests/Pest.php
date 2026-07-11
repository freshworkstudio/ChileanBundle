<?php

declare(strict_types=1);

use Freshwork\ChileanBundle\Rut;
use Freshwork\ChileanBundle\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

uses(TestCase::class)->in('Laravel');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeValidRut', function () {
    return $this->toBeTruthy()
        ->and($this->value->validate())->toBeTrue();
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

function createRut(string $rut): Rut
{
    return Rut::parse($rut);
}

function validRuts(): array
{
    return ['11.111.111-1', '111111111', '11111112-K', '11111112-k'];
}

function invalidRuts(): array
{
    return ['11111112-9', '17601065fail-7', '123-1', '123.456.789-2', '11.111.111-L'];
}
