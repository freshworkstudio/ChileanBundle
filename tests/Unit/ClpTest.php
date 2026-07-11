<?php

declare(strict_types=1);

use Freshwork\ChileanBundle\Clp;

it('formats amounts as Chilean pesos', function () {
    expect(Clp::format(1234567))->toBe('$1.234.567');
    expect(Clp::format(1000))->toBe('$1.000');
    expect(Clp::format(999))->toBe('$999');
    expect(Clp::format(0))->toBe('$0');
});

it('formats negative amounts', function () {
    expect(Clp::format(-1234567))->toBe('-$1.234.567');
});

it('formats without symbol', function () {
    expect(Clp::format(1234567, symbol: false))->toBe('1.234.567');
});

it('rounds float amounts to the nearest peso', function () {
    expect(Clp::format(1234.56))->toBe('$1.235');
});

it('parses CLP-formatted strings', function () {
    expect(Clp::parse('$1.234.567'))->toBe(1234567);
    expect(Clp::parse('1.234.567'))->toBe(1234567);
    expect(Clp::parse('$ 1.000'))->toBe(1000);
    expect(Clp::parse('-$1.234'))->toBe(-1234);
    expect(Clp::parse(''))->toBe(0);
});

it('roundtrips format and parse', function () {
    expect(Clp::parse(Clp::format(9876543)))->toBe(9876543);
    expect(Clp::parse(Clp::format(-500)))->toBe(-500);
});
