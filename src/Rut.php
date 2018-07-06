<?php namespace Freshwork\ChileanBundle;

/**
 * Author: Gonzalo De Spirito
 * Email: gonzalo@freshworkstudio.com
 * Date: 06-08-14 18:31
 */
use Freshwork\ChileanBundle\Exceptions\InvalidFormatException;

/**
 * Class Rut
 * Validation and Utils for RUT
 * @package Freshwork\ChileanBundle
 */
class Rut
{

    /**
     * Characters to scape from RUT
     *
     * Caracteres que queremos eliminar del rut para realizar la validación
     *
     * @var array
     */
    protected $escapeChars = [".", ",", "-", "_", " "];

    /**
     * @var string
     */
    protected $regex = '/([^0-9kK])/';

    /**
     * RUT verification number separator.
     * @var string
     */
    protected $vnSeparator  = "-";

    /**
     * Min amount of chars a RUT can have beign normalized (without dashes or spaces)
     * @var int
     */
    protected $minChars = 5;

    /**
     * Max amount of chars a RUT can have beign normalized (without dashes or spaces)
     * @var int
     */
    protected $maxChars = 10;

    /**
     * Determines if the class throws exceptions on validations errors
     * @var bool
     */
    protected $useExceptions = true;

    /**
     * RUT Number
     * The number part of the RUT. Example: 12.345.678-9 ($rut = 12345678)
     * @var integer
     */
    protected $number = null;

    /**
     * Verification Number of the RUT
     * The verification number part of the RUT. Example: 12.345.678-9 ($vn = 9)
     * @var string
     */
    protected $vn = null;

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
     * Rut constructor.
     * @param null $rut
     * @param null $vn
     */
    public function __construct($rut = null, $vn = null)
    {
        if ($rut != null) {
            $this->number($rut);
        }
        if ($vn !== null) {
            $this->vn($vn);
        }
    }

    /**
     * Shortcut for (new Rut($rut, $dv)) and automatically detect
     *
     * @param string|integer $rut Rut Number with the verification number
     * @return Rut
     */
    public static function parse($rut)
    {
        list($rut, $vn) = self::split($rut);

        return (new self($rut, $vn));
    }

    /**
     * Shortcut for (new Rut($rut, $dv))
     *
     * @param string|integer $number Rut Number without the verification number
     * @param null|integer|string $vn Verification number
     * @return Rut
     */
    public static function set($number = null, $vn = null)
    {
        return (new self($number, $vn));
    }


    /**
     * Gets or sets the verification number
     * @param null $vn
     * @return $this|null|string
     */
    public function vn($vn = null)
    {
        if ($vn !== null) {
            $this->vn = strtoupper($this->escape($vn));
            return $this;
        }
        return $this->vn;
    }

    /**
     * Get or sets the RUT Number
     * @param $number
     * @return $this|int
     */
    public function number($number = null)
    {
        if ($number !== null) {
            $this->number = $this->escape($number);
            return $this;
        }
        return $this->number;
    }

    /**
     * Get or sets the scape chars
     * @param array $chars
     * @return $this|array
     */
    public function scape_chars(array $chars = null)
    {
        if ($chars !== null) {
            $this->escapeChars = $chars;
            return $this;
        }
        return $this->escapeChars;
    }

    /**
     * Get or sets the verification number separator
     * @param array|null $vnSeparator
     * @return $this|string
     */
    public function vnSeparator(array $vnSeparator = null)
    {
        if ($vnSeparator !== null) {
            $this->vnSeparator = $vnSeparator;
            return $this;
        }
        return $this->vnSeparator;
    }

    /**
     * Check if the $rut argument is a valid RUT
     *
     * Devuelve true si el parámetro $rut es válido
     *
     * @return bool
     * @throws InvalidFormatException
     */
    public function isValid()
    {
        if (!$this->hasValidFormat()) {
            return false;
        }

        $vn_has_to_be = $this->calculateVerificationNumber();
        if ($this->vn == $vn_has_to_be) {
            return true;
        }

        return false;
    }

    /**
     * Alias of isValid($rut,$vn);
     *
     * @param $rut
     * @param  $vn
     * @return bool
     * @throws InvalidFormatException
     */
    public function validate()
    {
        return $this->isValid();
    }

    /**
     * Calculate the verification number based on  a R.U.T. number $this->rut ($this->number())
     *
     * Devuelve el dígito verificador que debe tener el $rut ingresado.
     * Si quieres pasarle el RUT completo, puedes 'setear' el último
     * parámetro como true para que la función lo haga por ti
     * Fuente: http://www.dcc.uchile.cl/~mortega/microcodigos/validarrut/php.php*
     * @author Luis Dujovne
     *
     *
     * @return string
     */
    public function calculateVerificationNumber()
    {
        $rut = $this->number;
        $s=1;
        for ($m=0; $rut != 0; $rut /= 10) {
            $s=($s+$rut % 10 * (9-$m++%6))%11;
        }
        return chr($s?$s+47:75);
    }

    /**
     * Splits the rut into rut and verification number.
     *
     * Si no le pasas el $vn digito verificador, separa el rut del dígito verificador.
     * Si le pasas el $vn digito verificador te devuelve ambos parámetros como array.
     *
     * @param $rut
     * @param null $vn
     * @return array [$rut,$vn]
     */
    public static function split($rut, $vn = null)
    {
        if (!is_null($vn)) {
            return [$rut, $vn];
        }
        $vn = (substr($rut, -1));//Get the last character
        $rut = substr($rut, 0, -1); //Remove tha last char from the rut

        return [$rut, $vn];
    }
    /**
     * Escape the RUT or any string. Remove the $scape_chars of the string.
     *
     * Quita los caracteres ($scape_chars) que no queremos del RUT/String
     *
     * @param string $string
     * @return string
     */

    public function escape($string)
    {
        return str_replace($this->scape_chars(), "", $string);
    }

    /**
     * Get the normalized version of the RUT.
     * @return string
     * @throws InvalidFormatException
     */
    public function normalize()
    {
        return $this->format(self::FORMAT_ESCAPED);
    }

    /**
     * Fix the RUT, so the verification number is now valid. This method overrides the verification number provided
     *
     * @return $this
     */
    public function fix()
    {
        $this->vn($this->calculateVerificationNumber());
        return $this;
    }

    /**
     * Format R.U.T
     *
     * Formatea el RUt en alguno de los 3 formatos disponibles.
     *
     * @param int $format
     * @return string
     * @throws InvalidFormatException
     */
    public function format($format = self::FORMAT_COMPLETE)
    {
        if (!$this->hasValidFormat()) {
            return false;
        }
        switch ($format) {
            case static::FORMAT_COMPLETE:
                return $this->join(
                    number_format($this->number, 0, null, "."),
                    $this->vn
                );
                break;

            case static::FORMAT_WITH_DASH:
                return $this->join($this->number, $this->vn);
                break;
        }
        return $this->number . $this->vn;
    }

    /**
     * Check if RUT has a valid format. If not, throws an Exception
     *
     * REvisa si el R.U.T. tiene un formato válido. De ser inválido, arroja una excepción o returna false si $use_exections = true;
     *
     * @param $rut
     * @param null $vn
     * @throws \Freshwork\ChileanBundle\Exceptions\InvalidFormatException
     *
     * @return bool
     */
    public function hasValidFormat()
    {
        $is_ok = (preg_match('/^[0-9]+$/', $this->number) && preg_match('/([K0-9])$/', $this->vn) && strlen($this->number) > $this->minChars && strlen($this->number) < $this->maxChars);
        if (!$is_ok && $this->useExceptions) {
            throw new InvalidFormatException("R.U.T. '{$this->number}' with verification code '{$this->vn}' has an invalid format");
        }

        return $is_ok;
    }

    /**
     * Join two parts of a RUT. Rut and verification number.
     * @param null|string $str1 (optional)
     * @param null|string $str2 (optional)
     *
     * @return string
     */
    public function join($str1 = null, $str2 = null)
    {
        if (is_null($str1)) {
            $str1 = $this->number();
        }
        if (is_null($str2)) {
            $str2 = $this->vn();
        }

        return $str1 . $this->vnSeparator . $str2;
    }


    /**
     * Set the object to a quiet status, without throwing exceptions
     *
     * @return $this
     */
    public function quiet()
    {
        $this->useExceptions = false;
        return $this;
    }

    /**
     * Let the object throw exception on validation failures
     *
     * @return $this
     */
    public function use_exceptions()
    {
        $this->useExceptions = true;
        return $this;
    }

    /**
     * Return exceptions throwing status
     * @return bool
     */
    public function is_using_exceptions()
    {
        return $this->useExceptions;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [$this->number, $this->vn];
    }

    /**
     * @return string
     * @throws InvalidFormatException
     */
    public function __toString()
    {
        return $this->format();
    }
}
