Chilean Bundle
=============

A PHP composer package with Chilean validations, common variables, etc.
Viva Chile Mierda :)

#### This package includes: 

* R.U.T. validation
* More functions coming soon...



Installation 
------------

### with composer: 
**1.A)** Edit your composer.json and add the package: 

    {
        "require": {
            "freshwork\chilean-bundle": "dev-master"
        }
    }
    

**1.B)** Or... running this command:
```bash
    composer require freshwork\chilean-bundle dev-master
```

**2)** Run composer install or update
```bash
php composer update
```

**3.A)** Using Laravel?
Just add this to your $providers array at app/config/app.php
```php
//app/config/app.php

$providers = array(
    //...
    'Freshwork\ChileanBundle\Laravel\ChileanBundleServiceProvider'
);

//NOW YOU CAN ACCESS WITH RUT FACADE IN ANY FILE OF YOUR APP

Rut::validate('10.123.123-5'); //return false
Rut::validate('10.123.123-5'); //return false
Rut::validate('12.345.678','5');//return true
Rut::format('123456789'); //return '12.345.678-9
//etc...

```

**3.B)** Not using Laravel: 

```php
<?php 
include('vendor/autoload.php'); //Enable composer autloading

//You have to declare: 
use Freshwork\ChileanBundle\Validation\Rut;

Rut::validate('10.123.123-5'); //return false
Rut::validate('10.123.123-5'); //return false
Rut::validate('12.345.678','5');//return true
Rut::format('123456789'); //return '12.345.678-9
//etc...
```

### We're ready to roll ;)

Checkout this link for packagist: [Link]



### HOW TO USE: Chilean R.U.T. functions




### isValid($rut [,$digito_verificador = null]) or
### validate($rut [,$digito_verificador = null])
If $digito_verificador is null or not set, this digit will be retrieved from the last character of $rut.

@param $rut: RUT with or without $dv (digito_verificador). 
Depends if you include $dv parameter.

@param $dv: (optional) digito verificador


#### Valid RUT EXAMPLE
```php
use Freshwork\ChileanBundle\Validations\Rut;

//For testing 11.111.111-1. (this is valid) 

Rut::validate('11.111.111','1'); ///return true
Rut::validate('11.111.111-1'); ///return true
Rut::validate('111111111'); ///return true
Rut::validate('11111111-1'); ///return true
Rut::isValid('11.111.111','1'); ///return true. validate() is an alias of isValid()
```

#### Invalid verification number ($digito_verificador)
If RUT has an incorrect verification number (digito verificador), it return false
```php
use Freshwork\ChileanBundle\Validations\Rut;

Rut::validate('11.111.111','2'); ///return false
Rut::validate('11.111.111-2'); ///return false
```
#### Invalid formatted $rut
If RUT has an incorrect format it will throw an *InvalidFormatException*
(Example: Too many numbers, or invalid characters)


```php
use Freshwork\ChileanBundle\Validations\Rut;

Rut::validate('11.1K1.111','2'); ///throws InvalidFormatException
Rut::isValid('11.111.111-L'); ///throws InvalidFormatException

//You can disable exceptions with Rut::$use_exceptions = false, 
//so these functions just return false, without throwing exceptions.

Rut::$use_exceptions = false; //Turn Off exceptions.
Rut::validate('11.1K1.111','2'); ///just return false
Rut::isValid('11.111.111-L'); ///just return false
Rut::format('11111111-L'); //just return false
Rut::$use_exceptions = true; //We re-enable exceptions
```
You have to try /catch
```php
use Freshwork\ChileanBundle\Validations\Rut;

//Note this: 
use Freshwork\ChileanBundle\Exceptions\InvalidFormatException;

//So you have to: 
try{
    $is_valid = Rut::validate("1.23.4.567-8-L");
}catch(InvalidFormatException $e){
    echo "Rut is completely invalid";
}
```
---
### getVerificationNumber($rut [,$has_to_remove_last_char = false]);
@param $rut (without veritification number).

The second parameter indicates if the last character of $rut has to be ommited.
```php
//If you pass 11.111.111, the verification code has to be 1
// So: 11.111.111-1 is a valid rut. 

Rut::getVerificationNumber('11.111.111'); //return 1

Rut::getVerificationNumber('11.111.111-K',true);
// return 1, because K is ommited. 
// (and the special characters (. - , _) are escaped
```

---
### split($rut [,$digito_verificador = null]);
@param $rut: RUT with or without $dv (digito_verificador). 
Depends if you include $dv parameter.

@param $dv: (optional) digito verificador

The second parameter indicates if the last character of $rut has to be ommited.
```php
Rut::split('11.111.111-1'); // return array('11111111','1')
Rut::split('12345678',5); // return array('12345678','5')
```

---
### normalize($rut);

Removes special characters from $rut. 
Almost every function call this method internally. 
```php
Rut::normalize('11.111.111-1'); // return '111111111'
Rut::normalize('12345678-5'); // return '123456785'
```
You can set the special characters before call this function.
```php
Rut::$scape_chars = array('.','-','_');
```

---
### format($rut [,$dv = null][,$format]);
@param $rut: RUT with or without $dv (digito_verificador). 
Depends if you include $dv parameter.

@param $dv: (optional) digito verificador

@param $format: Output format. 

Possible formats:
* Rut::FORMAT_COMPLETE = 0
* Rut::FORMAT_WITH_DASH = 1
* Rut::FORMAT_ESCAPED = 2

```php
Rut::format('11.111.111-1'); // return '11.111.111-1'
Rut::format('11-111-111-1'); // return '11.111.111-1'
Rut::format('111111111'); // return '11.111.111-1'
Rut::format('11.111.111','1'); // return '11.111.111-1'

//Antoher formats
Rut::format('11.111.111-1',null,Rut::FORMAT_WITH_DASH); // return '11111111-1'
Rut::format('11.111.111','1',Rut::FORMAT_WITH_DASH); // return '11111111-1'
Rut::format('12.345.678-5',null,Rut::FORMAT_ESCAPED); // return '1234567895'
Rut::format('12.345.678',5,Rut::FORMAT_ESCAPED); // return '1234567895'

```

Remember that if the RUT has an invalid format, it will throw an exception. So: 
```php
//invalid RUT
try{
    $str_rut = Rut::format("12.345.678-L");
}catch(InvalidFormatException $e){
    echo "Rut is completely invalid";
}

//You can also turn off exceptions with :
Rut::$use_exceptions = false; //Turn Off exceptions.
$str_rut = Rut::format("12.345.678-L"); //return false. No exceptions

```

---
### hasValidFormat($rut [,$digito_verificador = null]);
@param $rut: RUT with or without $dv (digito_verificador). 
Depends if you include $dv parameter.

@param $dv: (optional) digito verificador

@thows an exception if is invalid

Check if $rut is formatted correctly. It doesn't check if the $dv (digito verificador) is valid. It just checks format and characters.  

**Almost every function call this method internally.**
```php
Rut::hasValidFormat('11.111.111-1'); // return true
Rut::hasValidFormat('11111111-2');  // return true - 11.111.111-2
Rut::hasValidFormat('11.111.111-3'); // return true - 11.111.111-3
Rut::hasValidFormat('11111111K'); // return true - 11.111.111-K

Rut::hasValidFormat('12345678','L'); // throws an InvalidFormatException - 12.345.678-L

//You can disable exceptions
Rut::$use_exceptions = false; //Turn Off exceptions.
Rut::hasValidFormat('12345678','L'); // it just returns false - 12.345.678-L

```
Some configurable option: 
```php
Rut::$use_exceptions = true;
```
Min and max chars that RUT can have. This variables are used by this method to validate the first part of RUT. It counts the number of characters WITHOUT $dv (digito_verificador)
```php
Rut::$min_chars = 5; 
Rut::$max_chars = 9;
```

---
### join($rut);

Joins two parts of RUT. 
**Almost every function call this method internally.**
```php
Rut::join('11111111','1'); // return '11111111-1'
Rut::join('12345678','5'); // return '12345678-5'

//You cah change the union char
Rut::$dv_separator = '_';
Rut::join('11111111','1'); // return '11111111_1'
```
You can set the special characters before call this function.
```php
Rut::$scape_chars = array('.','-','_');
```

---
Contributing
--------------
Please, feel free to contact me at gonzalo@freshworkstudio.com.-


