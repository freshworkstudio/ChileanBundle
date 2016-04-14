<?php namespace Freshwork\ChileanBundle\Laravel;

use App;
use Freshwork\ChileanBundle\Validations\Rut;
use Illuminate\Foundation\AliasLoader;
use Validator;

class ChileanBundleServiceProvider extends ServiceProvider {

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

    public function boot(){
        Validator::extend('cl_rut', function($attribute, $value, $parameters)
        {
            Rut::quiet();
            return Rut::validate($value);
        });


        app()->bind('rut', function()
        {
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
