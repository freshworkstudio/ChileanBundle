<?php namespace Freshwork\ChileanBundle\Validations;
/**
 * Author: Gonzalo De Spirito
 * Email: gonzalo@freshworkstudio.com
 * Date: 06-08-14 18:31
 */
use Freshwork\ChileanBundle\Exceptions\InvalidFormatException;

/**
 * Class Rut
 * Validation and Utils for RUT
 * @package Freshwork\ChileanBundle\Validations
 */
class Rut {

    /**
     * Characters to scape from RUT
     *
     * Caracteres que queremos eliminar del rut para realizar la validación
     *
     * @var array
     */
    public static $scape_chars = [".",",","-","_"];

    /**
     * @var string
     */
    public static $dv_separator  = "-";

    /**
     * @var int
     */
    public static $min_chars = 5;

    /**
     * @var int
     */
    public static $max_chars = 9;

    public static $use_exceptions = true;

    /**
     *
     */
    const FORMAT_COMPLETE = 0; //Ex: 12.345.678-9
    /**
     *
     */
    const FORMAT_ESCAPED = 1; //Ex:  123456789

    /**
     *
     */
    const FORMAT_WITH_DASH = 2; //Ex:  12345678-9

    /**
     * Check if the $rut argument is a valid RUT
     *
     * Devuelve true si el parámetro $rut es válido
     *
     * @param $rut
     * @param null $dv
     * @return bool
     */
    static public function isValid($rut,$dv = null){
        list($rut,$dv) = static::split($rut,$dv);

        if(!static::hasValidFormat($rut,$dv))
            return false;

        $dv_has_to_be = static::getVerificationNumber($rut);

        if($dv == $dv_has_to_be)return true;
        return false;
    }

    /**
     * Alias of isValid($rut,$dv);
     *
     * @param $rut
     * @param  $dv
     * @return bool
     */
    static public function validate($rut,$dv = null){
        return static::isValid($rut,$dv);
    }

    /**
     * Returns the valid verification number that $rut has to have.
     * Devuelve el dígito verificador que debe tener el $rut ingresado.
     * Si quieres pasarle el RUT completo, puedes 'setear' el último
     * parámetro como true para que la función lo haga por ti

     * Fuente: http://www.dcc.uchile.cl/~mortega/microcodigos/validarrut/php.php
     * @author Luis Dujovne
     *
     * @param $r
     * @param bool $has_to_remove_last_char
     * @return string
     */
    static public function getVerificationNumber($r,$has_to_remove_last_char = false){
        $r = static::normalize($r);
        if($has_to_remove_last_char)$r = substr($r,0,-1);

        $s=1;
        for($m=0;$r!=0;$r/=10)
            $s=($s+$r%10*(9-$m++%6))%11;
        return chr($s?$s+47:75);
    }

    /**
     * Splits the rut into rut and verification number.
     *
     * Si no le pasas el $dv digito verificador, separa el rut del dígito verificador.
     * Si le pasas el $dv digito verificador te devuelve ambos parámetros como array.
     *
     * @param $rut
     * @param null $dv
     * @return array [$rut,$dv]
     */
    static public function split($rut,$dv = null){
        $rut = static::normalize($rut);

        if(!is_null($dv))
            return [(int)$rut,strtoupper($dv)];
        $dv = strtoupper(substr($rut,-1));//Get the last character
        $rut = (int)substr($rut,0,-1); //Remove tha last char from the rut

        return [$rut,$dv];
    }
    /**
     * Escape the RUT
     * Quita los carácteres ($scape_chars) que no queremos del RUT
    * @param string $rut
    * @return string
     */
    static public function normalize($rut){
        return str_replace(static::$scape_chars,"",$rut);
    }

    /**
     * Format R.U.T
     * Formatea el RUt en alguno de los 3 formatos disponibles.
     *
     * @param $rut
     * @param null $dv
     * @param int $format
     * @return string
     */
    static public function format($rut,$dv=null,$format = 0){
        list($rut,$dv) = static::split($rut,$dv);

        if(!static::hasValidFormat($rut,$dv))return false;

        switch($format)
        {
            case static::FORMAT_COMPLETE:
                return static::join(
                    number_format($rut,0,",","."),
                    $dv
                );
                break;

            case static::FORMAT_WITH_DASH:
                return static::join($rut,$dv);
                break;
        }
        return $rut.$dv;
    }

    /**
     * Check if RUT has a valid format. If not, throws an Exception
     *
     * @param $rut
     * @param null $dv
     * @throws \Freshwork\ChileanBundle\Exceptions\InvalidFormatException
     *
     * @return bool
     */
    static public function hasValidFormat($rut,$dv = null){
        list($rut,$dv) = static::split($rut,$dv);
        $is_ok = (preg_match('/^[0-9]+$/', $rut) && preg_match('/([K0-9])$/',$dv) && strlen($rut)>static::$min_chars && strlen($rut)<static::$max_chars);

        if(!static::$use_exceptions)return $is_ok;

        if(!$is_ok)
            throw new InvalidFormatException("R.U.T. '{$rut}' with verification code '{$dv}' has an invalid format");

        return true;
    }

    /**
     * Join two parts of a RUT. Rut and verification number.
     * @param $rut
     * @param $dv
     * @return string
     */
    static public function join($rut,$dv){
        return $rut.static::$dv_separator.$dv;
    }
}

