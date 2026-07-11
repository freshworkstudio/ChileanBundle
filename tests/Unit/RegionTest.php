<?php

declare(strict_types=1);

use Freshwork\ChileanBundle\Region;

it('has the 16 regions of Chile', function () {
    expect(Region::cases())->toHaveCount(16);
});

it('is backed by the official region number', function () {
    expect(Region::from(13))->toBe(Region::Metropolitana);
    expect(Region::from(16))->toBe(Region::Nuble);
    expect(Region::Valparaiso->value)->toBe(5);
});

it('exposes official names', function () {
    expect(Region::Metropolitana->officialName())->toBe('Región Metropolitana de Santiago');
    expect(Region::OHiggins->officialName())->toBe("Región del Libertador General Bernardo O'Higgins");
    expect(Region::Nuble->officialName())->toBe('Región de Ñuble');
});

it('exposes roman numerals', function () {
    expect(Region::Tarapaca->romanNumeral())->toBe('I');
    expect(Region::Metropolitana->romanNumeral())->toBe('RM');
    expect(Region::Nuble->romanNumeral())->toBe('XVI');
});

it('exposes regional capitals', function () {
    expect(Region::Metropolitana->capital())->toBe('Santiago');
    expect(Region::Biobio->capital())->toBe('Concepción');
    expect(Region::AricaYParinacota->capital())->toBe('Arica');
});

it('orders regions from north to south', function () {
    $ordered = Region::northToSouth();

    expect($ordered)->toHaveCount(16);
    expect($ordered[0])->toBe(Region::AricaYParinacota);
    expect($ordered[15])->toBe(Region::Magallanes);
});

it('builds options for selects', function () {
    $options = Region::options();

    expect($options)->toHaveCount(16);
    expect($options[13])->toBe('Región Metropolitana de Santiago');
    expect(array_key_first($options))->toBe(15); // Arica y Parinacota first (north)
});
