<?php namespace Freshwork\ChileanBundle\Laravel;

use App;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\ServiceProvider;
use Validator;

class ChileanBundleServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        Validator::extend('cl_rut', function ($attribute, $value, $parameters, $validator) {
            $validator->addReplacer('cl_rut', function ($message, $attribute, $rule, $parameters) {
                return str_replace(':attribute', $attribute, $message == 'validation.cl_rut'
                    ? 'El atributo :attribute no es válido.'
                    : $message);
            });

            return Rut::parse($value)->quiet()->validate();
        });

        app()->bind('rut', function () {
            return new Rut;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
