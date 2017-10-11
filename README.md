# Chilean Bundle

A PHP composer package with Chilean validations, common variables, etc.
Viva Chile Mierda!

## This package includes:

* R.U.T. validation
* More functions coming soon...

## Installation

### Step 1: Composer

From the command line, run:

```
composer require freshwork/chilean-bundle 
```
If you're not using Laravel, you are done.

### Step 2: Laravel Service Provider

If you're using **Laravel 5.5** this package supports Auto-Discovery. So you can skip this step.

**For Laravel 5.4 or below**

Append this line to your `providers` array in your  `config/app.php` file:

```php
'providers' => [
    ...
    Freshwork\ChileanBundle\Laravel\ChileanBundleServiceProvider::class
];
```
and you can add the `RUT` Facade
```php
'aliases' => [
    ...
    'Rut'   => Freshwork\ChileanBundle\Laravel\Facades\Rut::class
];
```
## Usage

### The Basics
You can use the RUT object, but I recommend using the Rut::parse() method.
```php
include('vendor/autoload.php'); //Enable composer autloading if not using laravel
use Freshwork\ChileanBundle\Rut;

$rut = new Rut('11.111.111', '1');
$rut->validate(); //true

(new Rut('12345678', '5'))->validate(); //true

```

### The `parse()` method
Is the recommended way of using the object. It will automatically separate the Verification Number (Dígito verrificador) and the rest of the number.
```php
    Rut::parse('11.111.111-1')->validate(); //true
    Rut::parse('11111111-1')->validate(); //true
    Rut::parse('12.345.678-5')->validate(); //true
    Rut::parse('123456785')->validate(); //true
    Rut::parse('1.23.45.6.7.8-5')->validate(); //true. It escapes all the dots and dashes.
```

### The `set()` method
This is a shortcut for `(new Rut($number, $vn))`
```php
Rut::set('10.123.123', '5'); //return true
```

### The `validate()` & `isValid()` method
`validate()` is an alias of `isValid()`
```php
Rut::parse('12345678-5')->isValid(); //true
```
### Invalid Formatted R.U.T.
if the R.U.T. is invalid, it will return false
```php
Rut::parse('12.345.678-9')->validate(); //false
```
### Invalid Formatted R.U.T.
if the R.U.T. has a wrong format, it will throw an `Freshwork\ChileanBundle\Exceptions\InvalidFormatException`
```php
Rut::parse('12.3k5.6L8-9')->validate(); //throw Freshwork\ChileanBundle\Exceptions\InvalidFormatException
Rut::set('12.345.678')->validate(); // throw exception. We didn't set the verification number
```
##### `Quiet` mode
You can prevent that the object throws an `InvalidFormatException`, so `validate()` will just return false, using the `quiet()` mehtod.
```php
Rut::parse('12.3k5.6L8-9')->quiet()->validate(); //return false. No exception
```
You can re-enable exceptions with `use_exceptions()`

### The `calculateVerificationNumber()` method
You can get the correct verification number of a RUT.  Note that the we are passing just one argument to the `set()` method. We are not defining a verification number.
```php
Rut::set('12.345.678')->calculateVerificationNumber(); //return 5
Rut::set('12.345.678-9')->calculateVerificationNumber(); //return 5
Rut::parse('12.345.678-9')->calculateVerificationNumber(); //return 5
```
Esta clase se basa en está simple, pero eficiente función: 
[http://www.dcc.uchile.cl/~mortega/microcodigos/validarrut/php.php](http://www.dcc.uchile.cl/~mortega/microcodigos/validarrut/php.php)


### The `format()` method
Return the Rut object as string with a definied format.
```php
Rut::parse('123456789')->format(); //return 12.345.678-9. It doesn't validates. It just formats.
Rut::parse('123456785')->format(Rut::FORMAT_COMPLETE); //return 12.345.678-5.
Rut::parse('123456785')->format(Rut::FORMAT_WITH_DASH); //return 12345678-5.
Rut::parse('123456785')->format(Rut::FORMAT_ESCAPED); //return 123456785.
Rut::parse('12.345.678-5')->format(Rut::FORMAT_ESCAPED); //return 123456785.
```

### The `normalize()` method
If you are saving RUTs in the database, I recommend saving the normalized rut string. This method is an alias of `->format(Rut::FORMAT_ESCAPED)`
```php
Rut::parse('12.345.678-5')->normalize(); //return '123456785'
```

### The `toArray()` method
Return the Rut object as string with a definied format.
```php
Rut::parse('12.345.678-5')->toArray(); //return ['12345678', '5']
```

### The `fix()` method
Fix the current RUT.  It will take the number part of the RUT (without verification number) and it will calculate what's the correct verification number for that RUT and then updates the verification number with this result. 
```php
Rut::parse('12.345.678-9')->fix()->format(); //return '12.345.678-5'

//Set a new rut without setting any verification number
Rut::set('12345678')->fix()->format(); //return '12.345.678-5'

//Set a new rut with an invalid verification number that will be replaced
Rut::set('12345678', '6')->fix()->format(); //return '12.345.678-5'

Rut::parse('12.345.678-9')->validate(); //return false
Rut::parse('12.345.678-9')->fix()->validate(); //return true
```

### The `vn()` and `number()` method
You can set and get the RUT number and verification number with this methods. If no argumen are passed to this methods, it will return the corresponding value. Otherwise, it sets the value.
```php
//Getter
Rut::parse('12.345.678-9')->vn(); //return '9'
Rut::parse('12.345.678-9')->number(); //return '12345678'

//Setter
Rut::parse('12.345.678-9')->vn('7')->format(); //return '12.345.678-7'
Rut::parse('12.345.678-9')->number('11111111')->format(); //return '11.111.111-9'
Rut::set()->number('12.345.678')->vn('9')->format() //return '12.345.678-9'
```
# Laravel
### Validations
If you're using the service Provider, you can validate ruts usign the validation system of Laravel using the `cl_rut` validation.
```php
...
class ClientController extends Controller{
    ...
    use ValidateRequests;
    ...
    public function store(Request $request) {
        $this->validate($request, [
            `nombre' => 'required|min:2',
            'email' => 'required|email',
            'rut'   => 'required|cl_rut'
        ]);
        //Do stuff
    }
}
```
---
#Examples
RUT Generator
```php 
<?php

use \Freshwork\ChileanBundle\Rut;

//We loop 100 times
for($i = 0; $i < 10; $i++)
{
    //generate random number between 1.000.000 and 25.000.000
    $random_number = rand(1000000, 25000000);

    //We create a new RUT wihtout verification number (the second paramenter of Rut constructor)
    $rut = new Rut($random_number);

    //The fix method calculates the  
    echo $rut->fix()->format() . " \n";
}
//Output (random)

17.062.139-5
18.815.969-9
14.287.543-8
13.864.006-K
16.724.081-K
20.465.345-3
13.294.672-8
11.102.906-7
8.333.479-7
7.661.557-8
```
This generatos 10 random RUT's between 1.000.000 and 25.000.000

Even a shorter sintaxis: 
```php
<?php
for($i = 0; $i < 10; $i++)
    echo \Freshwork\ChileanBundle\Rut::set(rand(1000000, 25000000))->fix()->format() . "\n";
``` 
---
# Testing
You can run the tests as `./vendor/bin/codecept run`

---
# Contributing
Please, feel free to contact me at gonzalo@freshworkstudio.com.-
