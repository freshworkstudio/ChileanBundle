<?php namespace Freshwork\ChileanBundle\Laravel\Facades;

/**
 * Author: Gonzalo De Spirito
 * Email: gonzalo@freshworkstudio.com
 * Date: 07-08-14 3:09
 */

use Illuminate\Support\Facades\Facade;

class Rut extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rut';
    }
}
