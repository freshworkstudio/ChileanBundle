<?php namespace Freshwork\ChileanBundle\Laravel;

use App;
use Validator;
use Faker\Factory;
use Faker\Provider\Base;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Support\ServiceProvider;

class ChileanBundleServiceProvider extends ServiceProvider {

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = FALSE;

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register() {
    $this->app->singleton('Faker', function($app) {
      $faker    = Factory::create();
      $newClass = new class($faker) extends Base {
        public function rut() {
          return Rut::set(rand(1000000, 25000000))
                    ->fix()
                    ->format(Rut::FORMAT_ESCAPED);
        }
      };

      $faker->addProvider($newClass);

      return $faker;
    });
  }

  public function boot() {
    Validator::extend('cl_rut', function($attribute, $value, $parameters, $validator) {
      $validator->addReplacer('cl_rut', function($message, $attribute, $rule, $parameters) {
        return str_replace(':attribute', $attribute, $message == 'validation.cl_rut'
         ? 'El atributo :attribute no es válido.'
         : $message);
      });

      return Rut::parse($value)
                ->quiet()
                ->validate();
    });

    app()->bind('rut', function() {
      return new Rut;
    });
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides() {
    return [];
  }
}
