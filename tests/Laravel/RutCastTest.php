<?php

declare(strict_types=1);

use Freshwork\ChileanBundle\Laravel\Casts\RutCast;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Database\Eloquent\Model;

function makeCastModel(string $cast): Model
{
    return new class(['rut' => null], $cast) extends Model
    {
        protected $guarded = [];

        public function __construct(array $attributes = [], ?string $rutCast = null)
        {
            if ($rutCast !== null) {
                $this->casts = ['rut' => $rutCast];
            }
            parent::__construct($attributes);
        }
    };
}

it('stores the rut escaped by default and exposes it as a Rut object', function () {
    $model = makeCastModel(RutCast::class);
    $model->rut = '12.345.678-5';

    expect($model->getAttributes()['rut'])->toBe('123456785');
    expect($model->rut)->toBeInstanceOf(Rut::class);
    expect($model->rut->format())->toBe('12.345.678-5');
});

it('stores the rut with dash when configured', function () {
    $model = makeCastModel(RutCast::class.':dash');
    $model->rut = '12.345.678-5';

    expect($model->getAttributes()['rut'])->toBe('12345678-5');
});

it('stores the rut complete when configured', function () {
    $model = makeCastModel(RutCast::class.':complete');
    $model->rut = '123456785';

    expect($model->getAttributes()['rut'])->toBe('12.345.678-5');
});

it('accepts a Rut object when setting', function () {
    $model = makeCastModel(RutCast::class);
    $model->rut = Rut::parse('12.345.678-5');

    expect($model->getAttributes()['rut'])->toBe('123456785');
});

it('keeps the raw value when the rut is not formattable', function () {
    $model = makeCastModel(RutCast::class);
    $model->rut = 'invalid';

    expect($model->getAttributes()['rut'])->toBe('invalid');
});

it('handles null values', function () {
    $model = makeCastModel(RutCast::class);
    $model->rut = null;

    expect($model->getAttributes()['rut'])->toBeNull();
    expect($model->rut)->toBeNull();
});

it('rejects an invalid storage format', function () {
    new RutCast('csv');
})->throws(InvalidArgumentException::class);
