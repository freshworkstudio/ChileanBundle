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
        Validator::extend('cl_rut', function ($attribute, $value, $parameters) {
            return Rut::parse($value)->quiet()->validate();
        });

        Validator::replacer('cl_rut', function ($message, $attribute, $rule, $parameters) {
            return str_replace('El atributo :attribute es inválido', $parameters[0], $message);
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
