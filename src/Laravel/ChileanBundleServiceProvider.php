<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle\Laravel;

use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ChileanBundleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('rut', fn (): Rut => new Rut);
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'chilean-bundle');

        $this->publishes([
            __DIR__.'/../../lang' => $this->app->langPath('vendor/chilean-bundle'),
        ], 'chilean-bundle-lang');

        Validator::extend('cl_rut', fn ($attribute, $value): bool => (is_string($value) || is_int($value)) && Rut::check($value));

        Validator::replacer('cl_rut', function (string $message, string $attribute) {
            return $message === 'validation.cl_rut'
                ? trans('chilean-bundle::validation.cl_rut', ['attribute' => $attribute])
                : str_replace(':attribute', $attribute, $message);
        });
    }
}
