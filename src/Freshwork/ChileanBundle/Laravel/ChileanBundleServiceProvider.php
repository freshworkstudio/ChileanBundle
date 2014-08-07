<?php namespace Freshwork\ChileanBundle\Laravel;

use Freshwork\ChileanBundle\Validations\Rut;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

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
        \Validator::extend('cl_rut', function($attribute, $value, $parameters)
        {
            Rut::$use_exceptions = false;
            return Rut::validate($value);
        });

        \App::bind('rut', function()
        {
            return new Rut;
        });
        //Automatically alias the package.
        $current_aliases = \Config::get("app.aliases");

        //Get the alias loader instance. Ready to add aliases...
        $loader = AliasLoader::getInstance();

        //Add Sentry Facade Alias if is not already set on app/config/app.php
        if (empty($aliases['Rut']))
        {
            $loader->alias('Rut', 'Freshwork\ChileanBundle\Facades\Rut');
        }
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
