<?php

declare(strict_types=1);

use Freshwork\ChileanBundle\Laravel\Rules\Rut as RutRule;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\Validator;

it('passes the cl_rut validation rule with a valid rut', function () {
    $validator = Validator::make(['rut' => '12.345.678-5'], ['rut' => 'required|cl_rut']);

    expect($validator->passes())->toBeTrue();
});

it('fails the cl_rut validation rule with an invalid rut', function ($value) {
    $validator = Validator::make(['rut' => $value], ['rut' => 'required|cl_rut']);

    expect($validator->fails())->toBeTrue();
})->with(['12.345.678-9', 'not-a-rut', '123-1']);

it('returns a translated message for the cl_rut rule', function () {
    $validator = Validator::make(['rut' => '12.345.678-9'], ['rut' => 'cl_rut']);

    expect($validator->errors()->first('rut'))
        ->toBe('The rut field must be a valid Chilean R.U.T.');
});

it('returns a spanish message when the locale is es', function () {
    $this->app->setLocale('es');

    $validator = Validator::make(['rut' => '12.345.678-9'], ['rut' => 'cl_rut']);

    expect($validator->errors()->first('rut'))
        ->toBe('El campo rut debe ser un R.U.T. válido.');
});

it('validates using the Rut rule object', function () {
    $valid = Validator::make(['rut' => '12.345.678-5'], ['rut' => [new RutRule]]);
    $invalid = Validator::make(['rut' => '12.345.678-9'], ['rut' => [new RutRule]]);
    $notString = Validator::make(['rut' => ['array']], ['rut' => [new RutRule]]);

    expect($valid->passes())->toBeTrue();
    expect($invalid->fails())->toBeTrue();
    expect($invalid->errors()->first('rut'))->toBe('The rut field must be a valid Chilean R.U.T.');
    expect($notString->fails())->toBeTrue();
});

it('resolves the rut binding and facade', function () {
    expect(app('rut'))->toBeInstanceOf(Rut::class);
    expect(Freshwork\ChileanBundle\Facades\Rut::check('12.345.678-5'))->toBeTrue();
});
