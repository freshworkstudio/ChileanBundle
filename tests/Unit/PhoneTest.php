<?php

declare(strict_types=1);

use Freshwork\ChileanBundle\Phone;

it('validates chilean mobile numbers in multiple formats', function ($input) {
    expect(Phone::check($input))->toBeTrue();
    expect(Phone::parse($input)->isMobile())->toBeTrue();
    expect(Phone::parse($input)->isLandline())->toBeFalse();
})->with([
    '987654321',
    '+56987654321',
    '+56 9 8765 4321',
    '56 9 8765 4321',
    '09-8765 4321',
    '(9) 8765-4321',
]);

it('validates chilean landline numbers', function ($input) {
    expect(Phone::check($input))->toBeTrue();
    expect(Phone::parse($input)->isLandline())->toBeTrue();
    expect(Phone::parse($input)->isMobile())->toBeFalse();
})->with([
    '221234567', // Santiago
    '+56 2 2123 4567', // Santiago
    '452123456', // Temuco
    '32 2123456', // Valparaíso
]);

it('rejects invalid phone numbers', function ($input) {
    expect(Phone::check($input))->toBeFalse();
})->with([
    '12345678', // too short
    '1234567890', // too long
    '187654321', // starts with 1
    '887654321', // starts with 8
    'not-a-phone',
    '',
]);

it('normalizes to the national number', function () {
    expect(Phone::parse('+56 9 8765 4321')->number())->toBe('987654321');
    expect(Phone::parse('09-8765-4321')->number())->toBe('987654321');
});

it('formats to E.164', function () {
    expect(Phone::parse('9 8765 4321')->e164())->toBe('+56987654321');
    expect(Phone::parse('22 123 4567')->e164())->toBe('+56221234567');
    expect(Phone::parse('invalid')->e164())->toBeNull();
});

it('formats to a human-readable string', function () {
    expect(Phone::parse('987654321')->format())->toBe('+56 9 8765 4321');
    expect(Phone::parse('221234567')->format())->toBe('+56 2 2123 4567');
    expect(Phone::parse('invalid')->format())->toBeNull();
});

it('casts to string', function () {
    expect((string) Phone::parse('987654321'))->toBe('+56 9 8765 4321');
    expect((string) Phone::parse('invalid'))->toBe('');
});
