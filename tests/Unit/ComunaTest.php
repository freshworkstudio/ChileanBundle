<?php

declare(strict_types=1);

use Freshwork\ChileanBundle\Comuna;
use Freshwork\ChileanBundle\Region;

it('has the 346 comunas of Chile', function () {
    expect(Comuna::cases())->toHaveCount(346);
});

it('is backed by the official CUT code', function () {
    expect(Comuna::from(13101))->toBe(Comuna::Santiago);
    expect(Comuna::Iquique->value)->toBe(1101);
    expect(Comuna::Chillan->value)->toBe(16101);
    expect(Comuna::Valparaiso->value)->toBe(5101);
    expect(Comuna::PuntaArenas->value)->toBe(12101);
});

it('exposes the zero-padded CUT code', function () {
    expect(Comuna::Iquique->code())->toBe('01101');
    expect(Comuna::Santiago->code())->toBe('13101');
});

it('derives the region from the CUT code', function () {
    expect(Comuna::Santiago->region())->toBe(Region::Metropolitana);
    expect(Comuna::Nunoa->region())->toBe(Region::Metropolitana);
    expect(Comuna::Chillan->region())->toBe(Region::Nuble);
    expect(Comuna::Iquique->region())->toBe(Region::Tarapaca);
});

it('maps every comuna to a valid region', function () {
    foreach (Comuna::cases() as $comuna) {
        expect($comuna->region())->toBeInstanceOf(Region::class);
        expect($comuna->officialName())->not->toBe('');
    }
});

it('keeps the official spelling with accents', function () {
    expect(Comuna::Nunoa->officialName())->toBe('Ñuñoa');
    expect(Comuna::LosAngeles->officialName())->toBe('Los Ángeles');
    expect(Comuna::LosAlamos->officialName())->toBe('Los Álamos');
    expect(Comuna::Penalolen->officialName())->toBe('Peñalolén');
});

it('finds comunas by name, case and accent insensitive', function () {
    expect(Comuna::fromName('Ñuñoa'))->toBe(Comuna::Nunoa);
    expect(Comuna::fromName('nunoa'))->toBe(Comuna::Nunoa);
    expect(Comuna::fromName('PROVIDENCIA'))->toBe(Comuna::Providencia);
    expect(Comuna::fromName('los angeles'))->toBe(Comuna::LosAngeles);
    expect(Comuna::fromName('Comuna Inexistente'))->toBeNull();
});

it('lists the comunas of a region', function () {
    expect(Comuna::inRegion(Region::Tarapaca))->toHaveCount(7);
    expect(Comuna::inRegion(Region::Nuble))->toHaveCount(21);
    expect(Region::Metropolitana->comunas())->toHaveCount(52);
});

it('builds options for selects', function () {
    $all = Comuna::options();
    $tarapaca = Comuna::options(Region::Tarapaca);

    expect($all)->toHaveCount(346);
    expect($tarapaca)->toHaveCount(7);
    expect($tarapaca[1101])->toBe('Iquique');
});
