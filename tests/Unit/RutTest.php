<?php

declare(strict_types=1);

use Freshwork\ChileanBundle\Exceptions\InvalidFormatException;
use Freshwork\ChileanBundle\Rut;
use Freshwork\ChileanBundle\RutFormat;

beforeEach(function () {
    $this->ruts = [
        'valid' => ['11.111.111-1', '111111111', '11111112-K', '11111112-k'],
        'invalid' => ['11111112-9', '17601065fail-7', '123-1', '123.456.789-3', '11.111.111-L'],
    ];
});

it('validates valid ruts using static methods', function () {
    foreach ($this->ruts['valid'] as $valid_rut) {
        expect(Rut::parse($valid_rut)->validate())->toBeTrue();
    }

    expect(Rut::set('11.111.111', '1')->validate())->toBeTrue();
    expect(Rut::set('11111112', 'K')->validate())->toBeTrue();
    expect(Rut::set('11111112', 'K')->isValid())->toBeTrue();
});

it('validates valid ruts as object', function () {
    foreach ($this->ruts['valid'] as $valid_rut) {
        expect((new Rut)->parse($valid_rut)->validate())->toBeTrue();
    }

    expect((new Rut('11111112', 'K'))->validate())->toBeTrue();
    expect((new Rut('11111112', 'K'))->isValid())->toBeTrue();
});

it('validates invalid ruts as false', function () {
    expect(Rut::parse($this->ruts['invalid'][0])->validate())->toBeFalse();
});

it('throws InvalidFormatException for each invalid RUT', function () {
    foreach ($this->ruts['invalid'] as $invalid_rut) {
        Rut::parse($invalid_rut)->validate();
    }
})->throws(InvalidFormatException::class);

it('validates invalid RUT in quiet mode as false', function () {
    expect(Rut::parse($this->ruts['invalid'][1])->quiet()->validate())->toBeFalse();
    expect(Rut::parse($this->ruts['invalid'][2])->quiet()->validate())->toBeFalse();
    expect(Rut::parse($this->ruts['invalid'][3])->quiet()->validate())->toBeFalse();
});

it('checks ruts with the static check shortcut without throwing', function () {
    expect(Rut::check('11.111.111-1'))->toBeTrue();
    expect(Rut::check('12.345.678-5'))->toBeTrue();
    expect(Rut::check('12.345.678-9'))->toBeFalse();
    expect(Rut::check('not-a-rut'))->toBeFalse();
    expect(Rut::check(''))->toBeFalse();
});

it('calculates verification number correctly', function () {
    expect((new Rut('11.111.111'))->calculateVerificationNumber())->toBe('1');
    expect(Rut::parse('1.23.4.567-8-K')->calculateVerificationNumber())->toBe('5');
    expect(Rut::set('11111112')->calculateVerificationNumber())->toBe('K');
});

it('formats RUT in different formats', function ($input, $format, $expected) {
    expect(Rut::parse($input)->format($format))->toBe($expected);
})->with([
    ['1.23.4.567-8-9', RutFormat::Complete, '12.345.678-9'],
    ['1.23.4.567-8-K', RutFormat::Complete, '12.345.678-K'],
    ['1.23.4.567-8-9', RutFormat::WithDash, '12345678-9'],
    ['1.23.4.567-8-9', RutFormat::Escaped, '123456789'],
    // Legacy int constants still work
    ['1.23.4.567-8-9', Rut::FORMAT_COMPLETE, '12.345.678-9'],
    ['1.23.4.567-8-9', Rut::FORMAT_WITH_DASH, '12345678-9'],
    ['1.23.4.567-8-9', Rut::FORMAT_ESCAPED, '123456789'],
]);

it('throws when formatting a RUT with invalid format', function () {
    Rut::parse('123-1')->format();
})->throws(InvalidFormatException::class);

it('returns false when formatting a RUT with invalid format in quiet mode', function () {
    expect(Rut::parse('123-1')->quiet()->format())->toBeFalse();
});

it('joins RUT parts correctly', function () {
    expect(Rut::set('12345678', '9')->join())->toBe('12345678-9');
});

it('uses a custom verification number separator', function () {
    expect(Rut::set('12345678', '9')->vnSeparator('–')->join())->toBe('12345678–9');
    expect(Rut::set('12345678', '9')->vnSeparator())->toBe('-');
});

it('normalizes RUT correctly', function () {
    expect(Rut::parse('1.2.3.45.67.8-9')->normalize())->toBe('123456789');
});

it('fixes an invalid RUT', function () {
    $rut = Rut::parse($this->ruts['invalid'][0])->fix();

    expect($rut)->toBeValidRut();

    expect($rut->normalize())->toBe('11111112K');
    expect($rut->format())->toBe('11.111.112-K');
    expect(Rut::parse('12.345.678-9')->fix()->isValid())->toBeTrue();
});

it('generates random valid RUTs', function () {
    foreach (range(1, 20) as $i) {
        expect(Rut::random())->toBeValidRut();
    }

    $rut = Rut::random(1000000, 1000000);
    expect($rut->number())->toBe('1000000');
});

it('returns the RUT as an array', function ($validRut, $expected) {
    expect(Rut::parse($validRut)->toArray())->toBe($expected);
})->with([
    ['11.111.111-1', ['11111111', '1']],
    ['11111112-K', ['11111112', 'K']],
]);

it('casts to string and serializes to JSON', function () {
    expect((string) Rut::parse('123456785'))->toBe('12.345.678-5');
    expect(json_encode(Rut::parse('123456785')))->toBe('"12.345.678-5"');
    expect((string) Rut::parse('123-1')->quiet())->toBe('');
    expect(json_encode(Rut::parse('123-1')->quiet()))->toBe('null');
});

it('uses the setters correctly', function () {
    expect(Rut::set()->number('12.345.678')->vn('5')->format())->toBe('12.345.678-5');
});

it('respects min and max chars boundaries', function () {
    expect(Rut::parse('12.345-1')->quiet()->validate())->toBeFalse(); // 5 digits <= minChars
    expect(Rut::parse('12.345-1')->minChars(4)->fix()->validate())->toBeTrue();
    expect(Rut::parse('1.234.567.890-1')->quiet()->validate())->toBeFalse(); // 10 digits >= maxChars
});

it('rejects verification numbers longer than one character', function () {
    expect(Rut::set('12345678', 'XK')->quiet()->validate())->toBeFalse();
});
