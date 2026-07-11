<?php

declare(strict_types=1);

use Freshwork\ChileanBundle\Iva;

it('exposes the current IVA rate', function () {
    expect(Iva::RATE)->toBe(0.19);
    expect(Iva::PERCENTAGE)->toBe(19);
});

it('calculates the IVA of a net amount', function () {
    expect(Iva::of(10000))->toBe(1900);
    expect(Iva::of(1000))->toBe(190);
    expect(Iva::of(0))->toBe(0);
});

it('rounds the IVA to the nearest peso', function () {
    expect(Iva::of(999))->toBe(190); // 189.81
    expect(Iva::of(997))->toBe(189); // 189.43
});

it('adds IVA to a net amount', function () {
    expect(Iva::add(10000))->toBe(11900);
    expect(Iva::add(999))->toBe(1189);
});

it('rounds the net to the peso before calculating the IVA', function () {
    expect(Iva::add(1.4))->toBe(1); // net 1 + iva 0
    expect(Iva::add(999.6))->toBe(1190); // net 1000 + iva 190
    expect(Iva::add(999.6))->toBe(Iva::add(1000));
});

it('gets the net amount from a gross amount', function () {
    expect(Iva::net(11900))->toBe(10000);
    expect(Iva::net(1190))->toBe(1000);
});

it('gets the IVA contained in a gross amount', function () {
    expect(Iva::fromGross(11900))->toBe(1900);
    expect(Iva::fromGross(1190))->toBe(190);
});
