<?php

namespace Dice\Types;

/**
 * Integ: A near-natural Integer Implementation
 *
 * @property-read string activeValue Returns the active value of the object
 * @property-read string originalValue The original value with which the object was created
 */
class Integ
{
    /** @var int Original value with which the class was created */
    protected $originalValue;

    /** @var int Active value, used for chaining */
    protected $activeValue;

    /**
     * Integ constructor.
     * @param int $origValue Original value with which the object is to be constructed
     */
    public function __construct($origValue)
    {
        $this->originalValue = $origValue;
        $this->activeValue = (int)$origValue;
    }

    /**
     * Static form of constructor
     * @param int $origValue
     * @return Integ
     */
    public static function create(int $origValue)
    {
        $str = new Integ($origValue);
        return $str;
    }

    /**
     * String representation of the object
     * @return String returns the active text
     */
    public function __toString()
    {
        return (string)$this->activeValue;
    }

    /**
     * Returns the length of the integer's sting representation
     * @return int Length of the Integer as string
     */
    public function length()
    {
        return strlen((string)$this->activeValue);
    }

    /**
     * Returns the float/decimal representation (usually, should append '.0' at the end)
     *
     * @return float
     */
    public function toDecimal()
    {
        return $this->toFloat();
    }

    /**
     * Returns the double/decimal representation (usually, should append '.0' at the end)
     *
     * @return float
     */
    public function toDouble()
    {
        return (double)$this->activeValue;
    }

    /**
     * Returns the rational representation of the integer.
     * Just adds "/1" to the string representation
     *
     * @return string
     */
    public function toRational()
    {
        $strObj = $this->toString();
        $strObj->append('/1');
        return $strObj->toString();
    }

    /**
     * Returns the hexadecimal representation of the integer
     *
     * @param bool $upperCaseHex Should the returned hexadecimal value have alphabetic characters in upper case?
     * @return string
     */
    public function toHex($upperCaseHex = false)
    {
        $val = dechex($this->activeValue);
        if ($upperCaseHex) {
            $val = strtoupper($val);
        }
        return $val;
    }

    /**
     * Returns the binary representation of the Integer
     *
     * @return string
     */
    public function toBinary()
    {
        return decbin($this->activeValue);
    }

    /**
     * Returns the octal representation of the Integer
     *
     * @return string
     */
    public function toOctal()
    {
        return decoct($this->activeValue);
    }

    /**
     * Returns the scalar Integer values for each digit in the active value
     *
     * @return integer[]
     */
    public function digits()
    {
        $stringArray = str_split($this->activeValue);
        $arrToReturn = [];
        foreach ($stringArray as $value) {
            $arrToReturn[] = (int)$value;
        }

        return $arrToReturn;
    }

    /**
     * Magic method for retrieving original or active string
     * @param $name
     * @return String
     * @throws \Exception
     */
    public function __get($name)
    {
        switch ($name) {
            case 'originalValue':
                return $this->originalValue;
            case 'activeValue':
                return $this->activeValue;
            default:
                throw new \Exception('Invalid property requested', 1);
        }
    }

    /**
     * Convert the string to a scalar integer value
     * @return integer
     */
    public function toInt()
    {
        return (int)$this->activeValue;
    }

    /**
     * Convert the string to a scalar float value
     * @return float
     */
    public function toFloat()
    {
        return (float)$this->activeValue;
    }

    /**
     * Puts the integer in an array and returns the array
     * @return array
     */
    public function toArray()
    {
        return [$this->activeValue];
    }

    /**
     * Convert the value to a Str representation of the integer
     * @return Str
     */
    public function toString()
    {
        return new Str($this->activeValue);
    }
}
