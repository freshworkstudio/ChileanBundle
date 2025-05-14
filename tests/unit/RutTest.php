<?php

use Freshwork\ChileanBundle\Rut;
use Freshwork\ChileanBundle\Exceptions\InvalidFormatException;

// Define test data set
beforeEach(function() {
    $this->ruts = [
        'valid'   => ['11.111.111-1', '111111111', '11111112-K', '11111112-k'],
        'invalid' => ['11111112-9', '17601065fail-7', '123-1', '123.456.789-3', '11.111.111-L']
    ];
});

// Test validation of valid RUTs using static methods
it('validates valid ruts using static methods', function() {
    foreach ($this->ruts['valid'] as $valid_rut) {
        expect(Rut::parse($valid_rut)->validate())->toBeTrue();
    }

    expect(Rut::set('11.111.111', '1')->validate())->toBeTrue();
    expect(Rut::set('11111112', 'K')->validate())->toBeTrue();
    expect(Rut::set('11111112', 'K')->isValid())->toBeTrue();
});

// Test validation of valid RUTs using object instantiation
it('validates valid ruts as object', function() {
    foreach ($this->ruts['valid'] as $valid_rut) {
        expect((new Rut())->parse($valid_rut)->validate())->toBeTrue();
    }

    expect((new Rut('11111112', 'K'))->validate())->toBeTrue();
    expect((new Rut('11111112', 'K'))->isValid())->toBeTrue();
});

// Test invalid RUT without exception
it('validates invalid ruts as false', function() {
    expect(Rut::parse($this->ruts['invalid'][0])->validate())->toBeFalse();
});

// Test Exceptions with invalid RUT using Pest's approach
it('throws InvalidFormatException for each invalid RUT', function() {
    foreach ($this->ruts['invalid'] as $invalid_rut) {
        Rut::parse($invalid_rut)->validate();
    }
})->throws(InvalidFormatException::class);

// Test invalid RUT in quiet mode (without exceptions)
it('validates invalid RUT in quiet mode as false', function() {
    expect(Rut::parse($this->ruts['invalid'][1])->quiet()->validate())->toBeFalse();
    expect(Rut::parse($this->ruts['invalid'][2])->quiet()->validate())->toBeFalse();
    expect(Rut::parse($this->ruts['invalid'][3])->quiet()->validate())->toBeFalse();
});

// Test calculateVerificationNumber method
it('calculates verification number correctly', function() {
    expect((new Rut('11.111.111'))->calculateVerificationNumber())->toBe('1');
    expect(Rut::parse('1.23.4.567-8-K')->calculateVerificationNumber())->toBe('5');
});

// Test format method with Pest 2.x dataset feature
it('formats RUT in different formats', function($input, $format, $expected) {
    expect(Rut::parse($input)->format($format))->toBe($expected);
})->with([
    ['1.23.4.567-8-9', Rut::FORMAT_COMPLETE, '12.345.678-9'],
    ['1.23.4.567-8-K', Rut::FORMAT_COMPLETE, '12.345.678-K'],
    ['1.23.4.567-8-9', Rut::FORMAT_WITH_DASH, '12345678-9'],
    ['1.23.4.567-8-9', Rut::FORMAT_ESCAPED, '123456789']
]);

// Test join method
it('joins RUT parts correctly', function() {
    expect(Rut::set('12345678', '9')->join())->toBe('12345678-9');
});

// Test normalize method
it('normalizes RUT correctly', function() {
    expect(Rut::parse('1.2.3.45.67.8-9')->normalize())->toBe('123456789');
});

// Test fix method
it('fixes an invalid RUT', function() {
    $rut = Rut::parse($this->ruts['invalid'][0])->fix();
    
    // Using custom expectation
    expect($rut)->toBeValidRut();
    
    expect($rut->normalize())->toBe('11111112K');
    expect($rut->format())->toBe('11.111.112-K');
    expect(Rut::parse('12.345.678-9')->fix()->isValid())->toBeTrue();
});

// Test toArray method
it('returns the RUT as an array', function($validRut, $expected) {
    expect(Rut::parse($validRut)->toArray())->toBe($expected);
})->with([
    ['11.111.111-1', ['11111111', '1']],
    ['11111112-K', ['11111112', 'K']]
]);

// Test setters
it('uses the setters correctly', function() {
    expect(Rut::set()->number('12.345.678')->vn('5')->format())->toBe('12.345.678-5');
}); 